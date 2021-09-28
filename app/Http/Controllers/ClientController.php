<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Gate;
use App\Network;
use App\Route;
use App\RouteMap;
use App\Invite;
use Illuminate\Support\Str;
use URL;
Use App\Notifications\InviteNotification;
use Illuminate\Support\Facades\Validator;
use Notification;
use Auth;
use App\User;

class ClientController extends Controller
{

  function __construct()
  {
       $this->middleware('permission:client-list|client-create|client-edit|client-delete', ['only' => ['index','show']]);
       $this->middleware('permission:client-create', ['only' => ['create','store']]);
       $this->middleware('permission:client-edit', ['only' => ['edit','update']]);
       $this->middleware('permission:client-delete', ['only' => ['destroy']]);
       $this->middleware('permission:client-credit', ['only' => ['clients_credits']]);
       $this->middleware('permission:client-createStep1', ['only' => ['createStep1']]);
       $this->middleware('permission:client-postCreateStep1', ['only' => ['postCreateStep1']]);
       $this->middleware('permission:client-postCreateStep2', ['only' => ['postCreateStep2']]);
       $this->middleware('permission:client-postCreateStep3', ['only' => ['postCreateStep3']]);
       $this->middleware('permission:client-approve', ['only' => ['approve']]);
       $this->middleware('permission:client-dissapprove', ['only' => ['dissapprove']]);
  }

  public function index(Request $request)
  {
    $data = Client::latest()->get();
      if ($request->ajax()) {
          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('user', function (Client $client) {
                      return $client->user_id ? Str::limit(User::find($client->user_id)->username, 30, '...') : '';
                  })
                  ->addColumn('admin', function (Client $client) {
                      return $client->user_app_id ? Str::limit(User::find($client->user_app_id)->username, 30, '...') : '';
                  })
                  ->addColumn('accType', function (Client $client) {
                      return $client->accType == 1 ? Str::limit("PrePaid", 30, '...') : 'PostPaid';
                  })
                  ->addColumn('accStatus', function (Client $client) {
                      return $client->accStatus == 1 ? Str::limit("Active", 30, '...') : 'Disabled';
                  })
                  ->addColumn('flip', function($row){
                        if (Client::find($row->id)->accStatus == 1) {
                          $btn = '
                          <div class="custom-control custom-switch">
                            <input checked type="checkbox" class="custom-control-input" id="'.$row->id.'">
                            <label class="custom-control-label" for="'.$row->id.'"></label>
                          </div>
                          ';
                        } else {
                          $btn = '
                          <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="'.$row->id.'">
                            <label class="custom-control-label" for="'.$row->id.'"></label>
                          </div>
                          ';
                        }
                          return $btn;
                  })
                  ->addColumn('action', function($row){
                         $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
                         $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem">Edit</a>';
                         $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';
                          return $btn;
                  })
                  ->rawColumns(['action','flip'])
                  ->make(true);
      }
      $clientz = $data;
      $i = 1;
      return view('clients.index',compact('i','clientz'));
  }

  public function clients_credits(Request $request)
  {
    // $this->authorize('isAdmin');
      if ($request->ajax()) {
          $data = Client::latest()->get();
          return Datatables::of($data)
                  ->addIndexColumn()

                  ->addColumn('accType', function (Client $client) {
                      return $client->accType == 1 ? Str::limit("PrePaid", 30, '...') : 'PostPaid';
                  })
                  ->addColumn('accStatus', function (Client $client) {
                      return $client->accStatus == 1 ? Str::limit("Active", 30, '...') : 'Disabled';
                  })
                  ->addColumn('action', function($row){
                         $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
                         $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem">Edit</a>';
                         $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';
                          return $btn;
                  })
                  ->rawColumns(['action'])
                  ->make(true);
      }

      return view('clients.clients_credits');
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
        $validator = $request->validate([
        'clientName' => ['required', 'unique:clients', 'max:255'],
        'clientAddress' => ['required'],
        'mobileNo' => ['required'],
        'accType' => ['required'],
        'accLimit' => ['required']
          ]);


        Client::updateOrCreate(['id' => $request->id],
        ['user_id' =>Auth::user()->id, 'accLimit' => $request->accLimit, 'clientName' => $request->clientName, 'clientAddress' => $request->clientAddress,'company_email' => $request->company_email, 'mobileNo' => $request->mobileNo, 'accType' => $request->accType, 'accBalance' => $request->accBalance, 'accStatus' => "0", 'httpDlrUrl' => $request->httpDlrUrl, 'dlrHttpMethod' => $request->dlrHttpMethod]);

      return redirect("/clients");

  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $id = id($id);
      $client = Client::find($id);
      $dlrMethods = [
        'GET',
        'POST'
      ];
  //    return response()->json($item);
      return view('clients.edit',compact('client','dlrMethods'));
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
        $id = id($id);
  //   $this->authorize('isUser');
        if (Auth::user()->can('client-delete')) {
          Client::find($id)->delete();
          // FLUSH REDIS data        
        shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");
          return response()->json(['success'=>'Client deleted successfully.']);
        } else {
          return response()->json(array(
                  'success' => false,
                  'errors' => 'You are not admin'
              ), 400);
        }

  }

    public function create(Request $request)
    {

        return view('clients.create');
    }

    public function update(Request $request, Client $client)
    {
      $request->validate([
        'clientName' => 'required',
      ]);
      // FLUSH REDIS data        
      shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");
      $client->update($request->all());
      return back()->with('success','Client updated successfully!');
    }

    public function show($id)
    {
      $id = id($id);
      $client = Client::find($id);
      return view('clients.show',compact('client'));
    }

    public function resetClient(Request $request)
    {
      $request->session()->flush();
      // $request->session()->forget('client');
      return redirect('/tab1');
    }

    public function createStep1(Request $request)
    {
        $client = $request->session()->get('client');
        $clients = Client::all();
        $networks = Network::all();
        $routes = Route::all();
        $dlrMethods = [
          'GET',
          'POST'
        ];
        return view('clients.create-step3',compact('client','clients','networks','routes','dlrMethods'));
    }

    public function postCreateStep1(Request $request)
    {

        $validatedData = $request->validate([
          'clientName' => ['required', 'max:255'],
          'clientAddress' => ['required'],
          'mobileNo' => ['required'],
          'accType' => ['required'],
          'accLimit' => ['required']
        ]);

        if(empty($request->session()->get('client'))){
            $client = new Client();
            $client->fill($validatedData);
            $request->session()->put('client', $client);
        }else{
            $client = $request->session()->get('client');
            $client->fill($validatedData);
            $request->session()->put('client', $client);
        }
        $client = $request->session()->get('client');
        $client = $request;


        $clien = Client::where('clientName', $client->clientName)->first();
        // FLUSH REDIS data        
        shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");
        $id = isset($clien) ? $clien->id : "";
        Client::updateOrCreate(['id' => $id],
        ['user_id' =>Auth::user()->id, 'accLimit' => $client->accLimit, 'clientName' => $client->clientName, 'clientAddress' => $client->clientAddress, 'mobileNo' => $client->mobileNo, 'accType' => $client->accType, 'accBalance' => "0",
        'accStatus' => $client->accStatus, 'company_email' => $request->company_email, 'httpDlrUrl' => $client->httpDlrUrl, 'dlrHttpMethod' => $client->dlrHttpMethod]);

        return redirect('/tab2');
        // return view('tab_2',compact('client','clients','networks','routes'));
        // return  response()->json(compact('client','clients','networks','routes'), 200);
    }

    public function postCreateStep2(Request $request)
    {
        $client = $request->session()->get('client');
        $validator = $request->validate([
        'client_id' => ['required'],
        'network_id' => ['required'],
        'route_id' => ['required'],
        'price' => ['required'],
          ]);
          // FLUSH REDIS data        
        shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");
        RouteMap::updateOrCreate(['id' => $request->id],
        ['network_id' => $request->network_id, 'client_id' => $request->client_id, 'route_id' => $request->route_id, 'price' => $request->price]);
        return redirect('/tab3');
    }

    public function postCreateStep3(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username|unique:invites,username',
            'client_id' => 'required'
        ]);
        $validator->after(function ($validator) use ($request) {
            if (Invite::where('email', $request->input('email'))->exists()) {
                $validator->errors()->add('email', 'There exists an invite with this email!');
            }

        });
        if ($validator->fails()) {
            return redirect('/tab3')
                ->withErrors($validator)
                ->withInput();
        }
        do {
            $token = Str::random(20);
        } while (Invite::where('token', $token)->first());
        Invite::create([
            'token' => $token,
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'client_id' => $request->input('client_id')
        ]);
        $url = URL::temporarySignedRoute(

            'registration', now()->addMinutes(300), ['token' => $token]
        );
        Notification::route('mail', $request->input('email'))->notify(new InviteNotification($url));
        // $clients = Client::all();
        // return view('invites.index',compact('clients'));
        return redirect("/clients");
    }

    public function approve(Request $request)
    {
      $user = Auth::user();
      if ($user->can('client-approve')) {
        $id = Client::find($request->idee);
        $id->update(['accStatus' => 1 ]);
        $id->update(['user_app_id' => $user->id ]);

        // FLUSH REDIS data        
        shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");

        return response()->json(['success'=>'approved successfully.']);
      } else {
        return response()->json(array(
                'success' => false,
                'errors' => 'You are not admin'
            ), 400);
      }

    }

    public function dissapprove(Request $request)
    {
      $user = Auth::user();
      if ($user->can('client-approve')) {
        $id = Client::find($request->idee);
        $id->update(['accStatus' => 0 ]);
        $id->update(['user_app_id' => $user->id ]);
        
        // FLUSH REDIS data        
        shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");
        
        return response()->json(['success'=>'deactivation successfull.']);
      } else {
        return response()->json(array(
                'success' => false,
                'errors' => 'You do not have rights'
            ), 400);
      }

    }


}
