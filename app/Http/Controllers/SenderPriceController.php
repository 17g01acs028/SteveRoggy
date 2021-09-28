<?php

namespace App\Http\Controllers;

use App\SenderPrice;
use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Sender;

class SenderPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            $data = SenderPrice::latest()->with('client')->select('sender_prices.*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('client', function (SenderPrice $senderPrice) {
                        return $senderPrice->client ? Str::limit($senderPrice->client->clientName, 30, '...') : '';
                    })
                    ->addColumn('sender', function (SenderPrice $senderPrice) {
                       return $senderPrice->sender ? Str::limit($senderPrice->sender->name, 30, '...') : '';
                    })
                    ->addColumn('action', function($row){
                      $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
                      $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem">Edit</a>';
                      $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';
                     return $btn;
                    })
                    ->rawColumns(['action'])
                    ->editColumn('created_at', function ($data) {
                       return [
                          'display' => date('d/m/Y H:i:s A', strtotime($data->created_at)),
                          'timestamp' => $data->created_at->timestamp
                       ];
                    })
                    ->filterColumn('created_at', function ($query, $keyword) {
                       $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                    })
                    ->make(true);
        }
    
        return view('sender_prices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $clients = Client::all();
      $senders = Sender::all();
      return view('sender_prices.create',compact('clients','senders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $validator = Validator::make($request->all(),[
      'client_id' => ['required'],
      'sender_id' => ['required'],
      'price' => ['required'],
      'description' => ['required'],
        ]);

        $validator->after(function ($validator) use ($request) {
            if (SenderPrice::where('client_id', $request->input('client_id'))->where('sender_id', $request->input('sender_id'))->first()) {
                $validator->errors()->add('client_id', 'The client already has this sender!!');
            }

        });
        if ($validator->fails()) {
            return redirect(route('sender_prices.create'))
                ->withErrors($validator)
                ->withInput();
        }

      SenderPrice::updateOrCreate(['id' => $request->id],
      ['client_id' => $request->client_id, 'sender_id' => $request->sender_id, 'description' => $request->description, 'price' => $request->price]);

    return redirect("/sender_prices");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SenderPrice  $senderPrice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $sender_price = SenderPrice::find(id($id));
      return view('sender_prices.show',compact('sender_price'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SenderPrice  $senderPrice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $clients = Client::all();
      $senders = Sender::all();
      $sender_price = SenderPrice::find(id($id));
      return view('sender_prices.edit',compact('clients','sender_price','senders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SenderPrice  $senderPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SenderPrice $senderPrice)
    {
      $request->validate([
        'client_id' => 'required',
        'sender_id' => 'required',
        'description' => 'required',
        'price' => 'required',
      ]);
      // FLUSH REDIS data        
      shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");
      
      $senderPrice->update($request->all());
      return redirect("/sender_prices");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SenderPrice  $senderPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
          SenderPrice::find(id($id))->delete();
        // FLUSH REDIS data        
          shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");
    
          return response()->json(['success'=>'deleted successfully.']);
        } else {
          return response()->json(array(
                  'success' => false,
                  'errors' => 'You are not admin'
              ), 400);
        }
    }

}
