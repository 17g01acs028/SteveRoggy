<?php

namespace App\Http\Controllers;

use App\Prefix;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use App\Network;
use Illuminate\Support\Facades\Validator;
use Auth;

class PrefixController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:prefix-list|prefix-create|prefix-edit|prefix-delete', ['only' => ['index','show']]);
         $this->middleware('permission:prefix-create', ['only' => ['create','store']]);
         $this->middleware('permission:prefix-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:prefix-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
      if ($request->ajax()) {
          $data = Prefix::latest()->with('network')->select('prefixes.*');
          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('network', function (Prefix $prefix) {
                      return $prefix->network ? Str::limit($prefix->network->name, 30, '...') : '';
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

      return view('prefixes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $networks = Network::all();
      return view('prefixes.create',compact('networks'));
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
      'prefix' => ['required'],
      'network_id' => ['required'],
      'prefix_length' => ['required'],
      'number_length' => ['required'],
        ]);


      $validator = Validator::make($request->all(),[
        'prefix' => ['required'],
        'network_id' => ['required'],
        'prefix_length' => ['required'],
        'number_length' => ['required'],
        ]);

        $validator->after(function ($validator) use ($request) {
            if (Prefix::where('prefix', $request->input('prefix'))->where('network_id', $request->input('network_id'))->first()) {
                $validator->errors()->add('prefix', 'There already exists an entry with combination of this prefix and network name!!');
            }

        });
        if ($validator->fails()) {
            return redirect(route('route_maps.create'))
                ->withErrors($validator)
                ->withInput();
        }



      Prefix::updateOrCreate(['id' => $request->id],
      ['network_id' => $request->network_id, 'prefix' => $request->prefix, 'prefix_length' => $request->prefix_length, 'number_length' => $request->number_length]);

    return redirect("/prefixes");
   }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prefix  $prefix
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $prefix = Prefix::find(id($id));
      return view('prefixes.show',compact('prefix'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prefix  $prefix
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $prefix = Prefix::find(id($id));
      $networks = Network::all();
      return view('prefixes.edit',compact('prefix','networks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prefix  $prefix
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prefix $prefix)
    {
      $validator = $request->validate([
      'prefix' => ['required'],
      'network_id' => ['required'],
      'prefix_length' => ['required'],
      'number_length' => ['required'],
        ]);

      $prefix->update($request->all());
      return view('prefixes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prefix  $prefix
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        Prefix::find(id($id))->delete();
        return response()->json(['success'=>'deleted successfully.']);
      } else {
        return response()->json(array(
                'success' => false,
                'errors' => 'You are not admin'
            ), 400);
      }
    }
}
