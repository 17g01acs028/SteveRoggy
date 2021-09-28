<?php

namespace App\Http\Controllers;

use App\ClientSender;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Sender;

class ClientSenderController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:clientSender-show', ['only' => ['show']]);
         $this->middleware('permission:clientSender-detach', ['only' => ['detach']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientSender  $clientSender
     * @return \Illuminate\Http\Response
     */
     public function show(Sender $clientSender, Request $request)
     {
       $user = Auth::user();
       if ($user->hasRole('super-admin|admin|manager')) {
         $sender = Sender::find($clientSender->id);
       } else {
         $sender = Sender::where('id',$clientSender->id)->where('client_id',$user->client_id)->first();
       }
       $data = $sender->clients;
       // return response()->json($data);
       if ($request->ajax()) {
           return Datatables::of($data)
                   ->addIndexColumn()

                   ->addColumn('action', function($row){
                     $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Remove</a>';
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
                   ->make(true);
       }
       return view('client_senders.show',compact('clientSender','sender'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientSender  $clientSender
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientSender $clientSender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientSender  $clientSender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientSender $clientSender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientSender  $clientSender
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientSender $clientSender)
    {
        //
    }

    public function detach(Request $request)
    {
      $sender = Sender::find(id($request->sender));
      $sender->clients()->detach(id($request->row));
      return response()->json($request);
    }

}
