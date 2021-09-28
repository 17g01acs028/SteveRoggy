<?php

namespace App\Http\Controllers;

use App\Sender;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;

class SenderController extends Controller
{
  function __construct()
  {
       $this->middleware('permission:sender-list|sender-create|sender-edit|sender-delete', ['only' => ['index','show']]);
       $this->middleware('permission:sender-create', ['only' => ['create','store']]);
       $this->middleware('permission:sender-edit', ['only' => ['edit','update']]);
       $this->middleware('permission:sender-delete', ['only' => ['destroy']]);
  }

  public function index(Request $request)
  {
    $user = Auth::user();

    if ($request->ajax()) {
        $data = Sender::latest()->with('user')->with('client')->select('senders.*');
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function (Sender $sender) {
                    return $sender->client ? Str::limit($sender->client->clientName, 30, '...') : '';
                })
                ->addColumn('user', function (Sender $sender) {
                    return $sender->user ? Str::limit($sender->user->username, 30, '...') : '';
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

    return view('senders.index');
  }

  public function create(Request $request)
  {
    $senders = Sender::all();
    $clients = Client::all();
    return view('senders.create',compact('senders','clients'));
  }

  public function store(Request $request)
  {
    $user = Auth::user();
    if ($request->name) {

      $validator = $request->validate([
      'name' => ['required', 'unique:senders', 'max:255'],
      'client_name_id' => ['required'],
        ]);
      $sender = Sender::updateOrCreate(['id' => $request->id],
      ['client_id' => $user->client_id, 'user_id' => $user->id, 'name' => $request->name]);
      $sender->clients()->attach($request->client_name_id);
      return redirect("/senders");

    } else {
      $validator = Validator::make($request->all(),[
        'existing_sender_ID' => ['required'],
        'client_name_id' => ['required'],
        ]);
      $senderId = Sender::find($request->existing_sender_ID);
      $dt = isset($senderId->clients) ? $senderId->clients : "";
      if ($dt) {
        foreach ($dt as $cli) {
          if ($cli->id == $request->client_name_id ) {
            $validator->after(function ($validator) use ($request) {
              $validator->errors()->add('client_name_id', 'This client already has this senderID!!');
            });
          }
        }
      }

      if ($validator->fails()) {
          return redirect(route('senders.create'))
              ->withErrors($validator)
              ->withInput();
      }
      $senderId->clients()->attach($request->client_name_id);
      return redirect("/senders");
    }

  }

  public function show($id)
  {
    $sender = Sender::find(id($id));
    return view('senders.show',compact('sender'));
  }

  public function edit($id)
  {
    $sender = Sender::find(id($id));
    return view('senders.edit',compact('sender'));
  }

  public function update(Request $request, Sender $sender)
  {
    $request->validate([
      'name' => 'required',
    ]);
    // FLUSH REDIS data        
    shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");

    $sender->update($request->all());
    return redirect("/senders");
  }

  public function destroy($id)
  {
    $user = Auth::user();
    if ($user->hasRole('super-admin|admin|manager')) {
        Sender::find(id($id))->delete();
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
