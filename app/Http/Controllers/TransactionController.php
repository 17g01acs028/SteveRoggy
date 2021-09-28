<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:transaction-list', ['only' => ['index','show']]);
    }

     public function index(Request $request)
     {
       $user = Auth::user();
       if ($user->hasRole('super-admin|admin|manager')) {
         $data = Transaction::latest();
       } else {
         $data = Transaction::latest()->where('client_id', $user->client_id);
       }
       if ($request->ajax()) {
           $data = $data->with('client')->with('mpesa_code')->select('transactions.*');
           return Datatables::of($data)
                   ->addIndexColumn()
                   ->addColumn('client', function (Transaction $transaction) {
                       return $transaction->client ? Str::limit($transaction->client->clientName, 30, '...') : '';
                   })
                   ->addColumn('mpesa_code', function (Transaction $transaction) {
                       return $transaction->mpesa_code ? Str::limit($transaction->mpesa_code->code, 30, '...') : '';
                   })
                   ->addColumn('action', function($row){
                     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
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

       return view('transactions.index');
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
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
      $id = id($id);
      $transaction = Transaction::find($id);
      return view('transactions.show',compact('transaction'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
