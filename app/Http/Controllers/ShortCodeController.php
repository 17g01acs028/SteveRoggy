<?php

namespace App\Http\Controllers;

use App\Client;
use App\Message;
use App\Schedule;
use App\Sender;
use App\ShortCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;

class ShortCodeController extends Controller
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
            $data = ShortCode::latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function (ShortCode $sender) {
                    return $sender->client ? Str::limit($sender->client->clientName, 30, '...') : '';
                })

                ->addColumn('action', function($row){
//                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem">Edit</a>';
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
                ->editColumn('updated_at', function ($data) {
                    return [
                        'display' => date('d/m/Y H:i:s A', strtotime($data->updated_at)),
                        'timestamp' => $data->updated_at->timestamp
                    ];
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                })
                ->filterColumn('updated_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(updated_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                })
                ->make(true);
        }

        return view('shortcode.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $clients = Client::all();
        return view('shortcode.create',compact('clients'));
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
            'short_code' => ['required', 'unique:short_codes', 'max:255'],
            'client_id' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect(route('shortcodes.create'))
                ->withErrors($validator)
                ->withInput();
        }
        ShortCode::updateOrCreate(['id' => $request->id],
            ['client_id' => $request->client_id, 'description' => $request->description, 'short_code' => $request->short_code]);

        return redirect("/shortcodes");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShortCode  $shortCode
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shortcode = ShortCode::find($id);
        return view('shortcode.show',compact('shortcode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShortCode  $shortCode
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shortcode = ShortCode::find(id($id));
        $clients = Client::all();
        return view('shortcode.edit',compact('shortcode','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShortCode  $shortCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'short_code' => 'required',
            'client_id' => 'required',
        ]);

        // FLUSH REDIS data        
        shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");

        $shortCode = ShortCode::find($id);
        $shortCode->short_code = $request->short_code;
        $shortCode->client_id = $request->client_id;
        $shortCode->description = $request->description;
        $shortCode->save();
      
        return redirect("/shortcodes");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShortCode  $shortCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->hasRole('super-admin|admin|manager')) {
            ShortCode::find(id($id))->delete();
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
