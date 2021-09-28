<?php

namespace App\Http\Controllers;

use App\ShortcodePrice;
use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\ShortCode;

class ShortcodePriceController extends Controller
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
            $data = ShortcodePrice::latest()->with('client')->select('shortcode_prices.*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('client', function (ShortcodePrice $shortCodePrice) {
                        return $shortCodePrice->client ? Str::limit($shortCodePrice->client->clientName, 30, '...') : '';
                    })
                    ->addColumn('shortcode', function (ShortcodePrice $shortCodePrice) {
                       return $shortCodePrice->short_code ? Str::limit($shortCodePrice->short_code->short_code, 30, '...') : '';
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
    
        return view('shortcode_prices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $clients = Client::all();
      $shortcodes = ShortCode::all();
      return view('shortcode_prices.create',compact('clients','shortcodes'));
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
      'short_code_id' => ['required'],
      'price' => ['required'],
      'description' => ['required'],
        ]);

        $validator->after(function ($validator) use ($request) {
            if (ShortcodePrice::where('client_id', $request->input('client_id'))->where('short_code_id', $request->input('short_code_id'))->first()) {
                $validator->errors()->add('client_id', 'The client already has this shortcode!!');
            }

        });
        if ($validator->fails()) {
            return redirect(route('shortcode_prices.create'))
                ->withErrors($validator)
                ->withInput();
        }

      ShortcodePrice::updateOrCreate(['id' => $request->id],
      ['client_id' => $request->client_id, 'short_code_id' => $request->short_code_id, 'description' => $request->description, 'price' => $request->price]);

    return redirect("/shortcode_prices");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShortcodePrice  $shortcodePrice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $short_code_price = ShortcodePrice::find(id($id));
      return view('shortcode_prices.show',compact('short_code_price'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShortcodePrice  $shortcodePrice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $clients = Client::all();
      $shortcodes = ShortCode::all();
      $short_code_price = ShortcodePrice::find(id($id));
      return view('shortcode_prices.edit',compact('clients','short_code_price','shortcodes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShortcodePrice  $shortcodePrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShortcodePrice $shortcodePrice)
    {
      $request->validate([
        'client_id' => 'required',
        'short_code_id' => 'required',
        'description' => 'required',
        'price' => 'required',
      ]);
      // FLUSH REDIS data        
      shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");
      
      $shortcodePrice->update($request->all());
      return redirect("/shortcode_prices");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShortcodePrice  $shortcodePrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
          ShortcodePrice::find(id($id))->delete();
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
