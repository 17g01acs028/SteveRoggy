<?php

namespace App\Http\Controllers;

use App\User;
use App\Invite;
use App\Client;
Use App\Notifications\InviteNotification;
use Illuminate\Http\Request;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use URL;
use Auth;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('registration_view');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-invite_view', ['only' => ['invite_view']]);
        $this->middleware('permission:user-process_invites', ['only' => ['process_invites']]);
        $this->middleware('permission:user-edit_user', ['only' => ['edit_user']]);
        $this->middleware('permission:user-update_user', ['only' => ['update_user']]);
        $this->middleware('permission:user-show_user', ['only' => ['show_user']]);
        $this->middleware('permission:user-show_client', ['only' => ['show_client']]);
    }

    public function index(Request $request)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        $data = User::latest();
      } else {
        $data = User::latest()->where('client_id', $user->client_id);
      }
      if ($request->ajax()) {
          $data = $data->get();
          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('client', function (User $user) {
                      return $user->client ? Str::limit($user->client->clientName, 30, '...') : '';
                  })
                  ->addColumn('role', function (User $user) {
                      return $user->getRoleNames() ? Str::limit($user->getRoleNames()->first(), 30, '...') : '';
                  })
                  ->addColumn('flip', function($row){
                    if (User::find($row->id)->notify == 1) {
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
      $userRoles = [
        'user',
        'manager',
        'admin'
      ];

      $clients = Client::all();

      return view('users.index',compact('userRoles','clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      Auth::user()->hasRole('super-admin|admin|manager');
      $roles = Role::where('name', '==', 'super-admin')->pluck('name','name')->all();
      return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      Auth::user()->hasRole('super-admin|admin|manager');
      $validator = $request->validate([
      'name' => ['required', 'unique:users', 'max:255'],
      'email' => ['required'],
        ]);

      $user = User::updateOrCreate(['id' => $request->id],
      ['name' => $request->name, 'email' => $request->email, 'notify' => $request->notify, 'timezone' => $request->timezone]);
      $user->assignRole('user');

      return redirect()->route('users.index')
                  ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      Auth::user()->hasRole('super-admin|admin|manager');
      // Input
      $id = id($id);
      // //Output
      // $user = id($id);
      $user = User::find($id);
      // return response()->json($id);
      return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      Auth::user()->hasRole('super-admin|admin|manager');
      $userRoles = [
        'user',
        'manager',
        'admin'
      ];
      $id = id($id);
      $user = User::find($id);
      $clients = Client::all();
      if (Auth::user()->hasRole('super-admin')) {
        $roles = Role::pluck('name','name')->all();
      } else {
        $roles = Role::where('name', '!=', 'super-admin')->pluck('name','name')->all();
      }

      $userRole = $user->roles->pluck('name','name')->all();
      return view('users.edit',compact('user','userRoles','clients','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
      Auth::user()->hasRole('super-admin|admin|manager');
      $userRoles = [
        'user',
        'manager',
        'admin'
      ];

      $request->validate([
        'name' => 'required',
      ]);
      $user->removeRole($user->roles->first());
      $user->assignRole($request->input('roles'));
      $user->update($request->all());
      // return response()->json($user);
      return back()->with('success','User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $id = id($id);
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        User::find($id)->delete();
        return response()->json(['success'=>'User deleted successfully.']);
      } else {
        return response()->json(array(
                'success' => false,
                'errors' => 'You are not admin'
            ), 400);
      }
    }

    public function invite_view()
    {
      Auth::user()->hasRole('super-admin|admin|manager');
      $clients = Client::all();
      return view('users.invite',compact('clients'));
    }

    public function process_invites(Request $request)
    {

      Auth::user()->hasRole('super-admin|admin|manager');
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
            return redirect(route('invite_view'))
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
        $clients = Client::all();
        return redirect()->route('invites.index');
    }

    public function registration_view($token)
    {
      if ($invite = Invite::where('token', $token)->first()) {
        return view('auth.register',['invite' => $invite]);
      } else {
        return response()->json(['error'=>'this link is invalid']);
      }

    }

    public function pass_id(Request $request)
    {
      $id = id($request->idee);
      return response()->json($id);
    }

    public function edit_user($id)
    {
      $id = id($id);
      $user = User::find($id);
      return view('users.edit_user',compact('user'));
    }

    public function update_user(Request $request, User $user)
    {
      $user->update($request->all());
      // return response()->json($user);
      return back()->with('success','Profile updated successfully!');
    }

    public function show_user($id)
    {
      $id = id($id);
      $user = User::find($id);
      // return response()->json($id);
      return view('users.show_user',compact('user'));
    }

    public function show_client($id)
    {
      $id = id($id);
      $client = Client::find($id);
      // return response()->json($id);
      return view('users.show_client',compact('client'));
    }


    public function enable(Request $request)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        $id = User::find($request->idee);
        $id->update(['notify' => 1 ]);

        return response()->json(['success'=>'notification enabled.']);
      } else {
        return response()->json(array(
                'success' => false,
                'errors' => 'You are not admin'
            ), 400);
      }

    }

    public function disable(Request $request)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        $id = User::find($request->idee);
        $id->update(['notify' => 0 ]);
        
        return response()->json(['success'=>'notification has been disabled.']);
      } else {
        return response()->json(array(
                'success' => false,
                'errors' => 'You do not have rights'
            ), 400);
      }

    }


}
