<?php

namespace App\Http\Controllers;

use App\Network;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use App\Prefix;
use Auth;

class NetworkController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:network-list|network-create|network-edit|network-delete', ['only' => ['index','show']]);
         $this->middleware('permission:network-create', ['only' => ['create','store']]);
         $this->middleware('permission:network-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:network-delete', ['only' => ['destroy']]);
         $this->middleware('permission:network-createStep1', ['only' => ['createStep1']]);
         $this->middleware('permission:network-postCreateStep1', ['only' => ['postCreateStep1']]);
         $this->middleware('permission:network-postCreateStep2', ['only' => ['postCreateStep2']]);
    }

    public function index(Request $request)
    {
      if ($request->ajax()) {
          $data = Network::latest()->get();
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

      return view('networks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      return view('networks.create');
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
      'name' => ['required'],
        ]);
      Network::updateOrCreate(['id' => $request->id],
      ['name' => $request->name]);

    return redirect("/networks");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $network = Network::find(id($id));
      return view('networks.show',compact('network'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $network = Network::find(id($id));
      return view('networks.edit',compact('network'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Network $network)
    {
      $request->validate([
        'name' => 'required',
      ]);

      $network->update($request->all());
      return view('networks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Network  $network
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        Network::find(id($id))->delete();
        return response()->json(['success'=>'deleted successfully.']);
      } else {
        return response()->json(array(
                'success' => false,
                'errors' => 'You are not admin'
            ), 400);
      }
    }

    public function resetNetwork(Request $request)
    {
      $request->session()->forget('network');
      return redirect('/tabN1');
    }

    public function createStep1(Request $request)
    {
        $network = $request->session()->get('network');
        $networks = Network::all();
        return view('networks.create-step3',compact('network','networks'));
    }

    public function postCreateStep1(Request $request)
    {

        $validatedData = $request->validate([
          'name' => ['required', 'max:255'],
        ]);


        if(empty($request->session()->get('network'))){
            $network = new Network();
            $network->fill($validatedData);
            $request->session()->put('network', $network);
        }else{
            $network = $request->session()->get('network');
            $network->fill($validatedData);
            $request->session()->put('network', $network);
        }
        $network = $request->session()->get('network');

        $net = Network::where('name', $network->name)->first();
        $id = isset($net) ? $net->id : "";
        Network::updateOrCreate(['id' => $id],
        ['name' => $network->name]);

        return redirect('/tabN2');
    }

    public function postCreateStep2(Request $request)
    {

        $validatedData = $request->validate([
          'prefix' => ['required'],
          'network_id' => ['required'],
          'prefix_length' => ['required'],
          'number_length' => ['required'],
        ]);

        Prefix::updateOrCreate(['id' => $request->id],
        ['network_id' => $request->network_id, 'prefix' => $request->prefix, 'prefix_length' => $request->prefix_length, 'number_length' => $request->number_length]);

      return redirect("/prefixes");
    }


}
