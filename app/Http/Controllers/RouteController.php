<?php

namespace App\Http\Controllers;

use App\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;

class RouteController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:route-list|route-create|route-edit|route-delete', ['only' => ['index','show']]);
         $this->middleware('permission:route-create', ['only' => ['create','store']]);
         $this->middleware('permission:route-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:route-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
      if ($request->ajax()) {
          $data = Route::latest()->get();
          return Datatables::of($data)
                  ->addIndexColumn()
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
                  ->make(true);
      }

      return view('routes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      return view('routes.create');
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
      'name' => ['required', 'unique:routes', 'max:255'],
        ]);
      Route::updateOrCreate(['id' => $request->id],
      ['name' => $request->name, 'price' => $request->price]);

    return redirect("/routes");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $route = Route::find(id($id));
      return view('routes.show',compact('route'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $route = Route::find(id($id));
      return view('routes.edit',compact('route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
      $request->validate([
        'name' => 'required',
      ]);
// FLUSH REDIS data        
      shell_exec("redis-cli -h 172.16.0.93 -p 6379 flushall");
      $route->update($request->all());
      return view('routes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        Route::find(id($id))->delete();
        
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
