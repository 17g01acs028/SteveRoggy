<?php

namespace App\Http\Controllers;

use App\Notfi;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\User;
use App\Client;
use App\Sender;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NotfiController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:notification-list|notification-create|notification-edit|notification-delete', ['only' => ['index','show']]);
         $this->middleware('permission:notification-create', ['only' => ['create','store']]);
         $this->middleware('permission:notification-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:notification-delete', ['only' => ['destroy']]);
    }

     public function index(Request $request)
     {
       $user = Auth::user();
       if ($user->hasRole('super-admin|admin|manager')) {
         $data = Notfi::latest();
       } else {
         $data = Notfi::latest()->where('client_id', $user->client_id);
       }
       if ($request->ajax()) {
           $data = $data->with('client')->with('user')->select('notfis.*');
           return Datatables::of($data)
                   ->addIndexColumn()
                   ->addColumn('client', function (Notfi $notfi) {
                       return $notfi->client ? Str::limit($notfi->client->clientName, 30, '...') : '';
                   })
                   ->addColumn('user', function (Notfi $notfi) {
                       return $notfi->user ? Str::limit($notfi->user->username, 30, '...') : '';
                   })
                   ->addColumn('action', function($row){
                    if ( Auth::user()->can('notification-delete')) {
                      $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
                      $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem">Edit</a>';
                      $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';
                    } else {
                      $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
                      $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem">Edit</a>';
                    }
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

       return view('notfis.index');
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request)
     {
       $users = User::all();
       $clients = Client::all();
       $senders = Sender::all();
       $type = [
        'Default',
        'Auto Credit TopUp',
        'Low Balance Notification'
        ];
       return view('notfis.create',compact('users','clients','senders','type'));
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
         'client' => ['required'],
         'user' => ['required'],
         'sender' => ['required'],
         'type' => ['required'],
         'message' => ['required'],
           ]);

         $user = Auth::user();

         $clint = Client::whereHas('users', function ($q) use ($request) {
           $q->where('id',$request->input('user'));
         })->first()->id;


         $validator->after(function ($validator) use ($request,$clint) {
           if ($clint != $request->input('client')) {
               $validator->errors()->add('user', 'Selected user does not belong to the client selected!!');
           }
         });
         $validator->after(function ($validator) use ($request) {
           if (Notfi::where('client_id', $request->input('client'))->where('type', $request->input('type'))->first()) {
               $validator->errors()->add('client', 'A notification message already exists for this client!!');
           }
         });

         if ($validator->fails()) {
             return redirect(route('notfis.create'))
                 ->withErrors($validator)
                 ->withInput();
         }

         Notfi::updateOrCreate(['id' => $request->id],
         ['client_id' => $request->client, 'type' => $request->type, 'user_id' => $request->user, 'sender' => $request->sender, 'message' => $request->message]);

         return redirect()->route('notfis.index')
                         ->with('success','Message created successfully');
       }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notfi  $notfi
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
       $notfi = Notfi::find(id($id));
       return view('notfis.show',compact('notfi'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notfi  $notfi
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
      $usr = Auth::user();
      $clint = Client::find($usr->client_id);
      $senders = $clint->senders;
       $users = User::all();
       $clients = Client::all();
      //  $senders = Sender::all();
       $notfi = Notfi::find(id($id));
       $type = [
        'Default',
        'Auto Credit TopUp',
        'Low Balance Notification'
        ];
       return view('notfis.edit',compact('users','clients','senders','notfi','type'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notfi  $notfi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notfi $notfi)
    {

      $validator = Validator::make($request->all(),[
      'sender' => ['required'],
        ]);

      if ( Auth::user()->can('notification-create')) {
        $clint = Client::whereHas('users', function ($q) use ($request) {
          $q->where('id',$request->input('user'));
        })->first()->id;

        $validator->after(function ($validator) use ($request,$clint) {
          if ($clint != $request->input('client')) {
              $validator->errors()->add('user', 'Selected user does not belong to the client selected!!');
          }
        });
      }

      $id = $request->segment(2);
      $id = id($id);
      if ($validator->fails()) {
          return redirect("/notfis/$id/edit")
              ->withErrors($validator)
              ->withInput();
      }

      $notfi->update($request->all());

      return back()->with('success','Message updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notfi  $notfi
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
         $id = id($id);
         Notfi::find($id)->delete();
     }

}
