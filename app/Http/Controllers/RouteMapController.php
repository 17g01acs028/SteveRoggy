<?php

namespace App\Http\Controllers;

use App\RouteMap;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use App\Network;
use App\Client;
use App\Route;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Auth;

class RouteMapController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:routeMap-list|routeMap-create|routeMap-edit|routeMap-delete', ['only' => ['index','show']]);
         $this->middleware('permission:routeMap-create', ['only' => ['create','store']]);
         $this->middleware('permission:routeMap-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:routeMap-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        $data = RouteMap::latest();
      } else {
        $data = RouteMap::latest()->where('client_id', $user->client_id);
      }
      // return response()->json($data->get);
      if ($request->ajax()) {
          $data = $data->with('network')->with('user')->with('client')->with('route')->select('route_maps.*');
          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('network', function (RouteMap $routeMap) {
                      return $routeMap->network ? Str::limit($routeMap->network->name, 30, '...') : '';
                  })
                  ->addColumn('client', function (RouteMap $routeMap) {
                      return $routeMap->client ? Str::limit($routeMap->client->clientName, 30, '...') : '';
                  })
                  ->addColumn('route', function (RouteMap $routeMap) {
                      return $routeMap->route ? Str::limit($routeMap->route->name, 30, '...') : '';
                  })
                  ->addColumn('user', function (RouteMap $routeMap) {
                    return $routeMap->user ? Str::limit($routeMap->user->username, 30, '...') : '';
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
                        //e($data->created_at->format('m/d/Y H:I:s')),
                        'timestamp' => $data->created_at->timestamp
                     ];
                  })
                  ->filterColumn('created_at', function ($query, $keyword) {
                     $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                  })
                  ->make(true);
      }

      return view('route_maps.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $networks = Network::all();
      $clients = Client::all();
      $routes = Route::all();
      $users = User::all();
      return view('route_maps.create',compact('networks','clients','routes','users'));
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
      'network_id' => ['required'],
      'route_id' => ['required'],
      'price' => ['required'],
        ]);

        $validator->after(function ($validator) use ($request) {
            if (RouteMap::where('client_id', $request->input('client_id'))->where('network_id', $request->input('network_id'))->where('route_id', $request->input('route_id'))->where('user_id', $request->input('user_id'))->first()) {
                $validator->errors()->add('client_id', 'There already exists an entry with combination of this clinet name, network name, route name and traffic user!!');
            }

        });
        if ($validator->fails()) {
            return redirect(route('route_maps.create'))
                ->withErrors($validator)
                ->withInput();
        }

      RouteMap::updateOrCreate(['id' => $request->id],
      ['network_id' => $request->network_id, 'client_id' => $request->client_id, 'route_id' => $request->route_id, 'user_id' => $request->user_id, 'price' => $request->price]);

    return redirect("/route_maps");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RouteMap  $routeMap
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $routeMap = RouteMap::find(id($id));
      return view('route_maps.show',compact('routeMap'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RouteMap  $routeMap
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $routeMap = RouteMap::find(id($id));
      $networks = Network::all();
      $clients = Client::all();
      $routes = Route::all();
      $users = User::all();
      return view('route_maps.edit',compact('routeMap','networks','clients','routes','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RouteMap  $routeMap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RouteMap $routeMap)
    {

        $validator = Validator::make($request->all(),[
        'client_id' => ['required'],
        'network_id' => ['required'],
        'route_id' => ['required'],
        'price' => ['required'],
          ]);

          $validator->after(function ($validator) use ($request) {
              if (RouteMap::where('client_id', $request->input('client_id'))->where('network_id', $request->input('network_id'))->where('route_id', $request->input('route_id'))->where('user_id', $request->input('user_id'))->first()) {
                  $validator->errors()->add('client_id', 'There already exists an entry with combination of this clinet name, network name, route name and traffic user!!');
              }

          });
          $id = $request->segment(2);
          $id = id($id);
          if ($validator->fails()) {
              return redirect("/route_maps/$id/edit")
                  ->withErrors($validator)
                  ->withInput();
          }
    // FLUSH REDIS data        
      shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");

      $routeMap->update($request->all());
      return redirect("/route_maps");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RouteMap  $routeMap
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        RouteMap::find(id($id))->delete();
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
