<?php

namespace App\Http\Controllers;

use App\Allocation;
use Illuminate\Http\Request;
use DataTables;
use App\Client;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\User;
use Auth;
use App\Balance;


class AllocationController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:allocation-list|allocation-create|allocation-edit|allocation-delete', ['only' => ['index','show']]);
         $this->middleware('permission:allocation-create', ['only' => ['create','store']]);
         $this->middleware('permission:allocation-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:allocation-delete', ['only' => ['destroy']]);
         $this->middleware('permission:allocation-approve', ['only' => ['approve']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($request->ajax()) {
          $data = Allocation::latest()->with('client')->select('allocations.*');
          return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('user', function (Allocation $allocation) {
                      return $allocation->user_id ? Str::limit(User::find($allocation->user_id)->username, 30, '...') : '';
                  })
                  ->addColumn('admin', function (Allocation $allocation) {
                      return $allocation->user_app_id ? Str::limit(User::find($allocation->user_app_id)->username, 30, '...') : '';
                  })
                  ->addColumn('client', function (Allocation $allocation) {
                      return $allocation->client ? Str::limit($allocation->client->clientName, 30, '...') : '';
                  })
                  ->addColumn('flip', function($row){
                        if (Allocation::find($row->id)->approval == 1) {
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
                         $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';
                          return $btn;
                  })
                  ->rawColumns(['action','flip'])
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

      return view('allocations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $clients = Client::all();
      return view('allocations.create',compact('clients'));
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
      'accBalance' => ['required'],
        ]);
      $user = Auth::user();
      Allocation::updateOrCreate(['id' => $request->id],
      ['user_id' => $user->id, 'client_id' => $request->client_id, 'approval' => 0, 'accBalance' => $request->accBalance]);

    return redirect("/allocations");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $allocation = Allocation::find(id($id));
      return view('allocations.show',compact('allocation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $allocation = Allocation::find(id($id));
      $clients = Client::all();
      return view('allocations.edit',compact('allocation','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allocation $allocation)
    {
      $request->validate([
        'accBalance' => 'required',
      ]);

      $allocation->update($request->all());
      return view('allocations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if (Auth::user()->can('allocation-delete')) {
        Allocation::find(id($id))->delete();
        return response()->json(['success'=>'deleted successfully.']);
      } else {
        return response()->json(array(
                'success' => false,
                'errors' => 'You are not admin'
            ), 400);
      }
    }

    public function approve(Request $request)
    {
      $user = Auth::user();
      if ($user->can('allocation-approve')) {
        $id = Allocation::find($request->idee);
        $cli = Client::find($id->client_id);
        $newBal = $cli->accBalance += $id->accBalance;
  
        Balance::updateOrCreate(
        ['client_id' => $cli->id, 'bal_before' => $cli->accBalance, 'amount' => $id->accBalance, 'bal_after' => $newBal, 'type' => 'SMSCredit']);
    
        $cli->update(['accBalance' => $newBal]);
        $id->update(['approval' => 1 ]);
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

}
