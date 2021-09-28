<?php

namespace App\Http\Controllers;

use App\MpesaCode;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use GuzzleHttp\Client as Cl;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use App\Client;
use Illuminate\Support\Str;

class MpesaCodeController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:mpesaCode-list|mpesaCode-create|mpesaCode-delete', ['only' => ['index','show']]);
         $this->middleware('permission:mpesaCode-create', ['only' => ['create','store']]);
         $this->middleware('permission:mpesaCode-delete', ['only' => ['destroy']]);
    }

     public function index(Request $request)
     {
       $user = Auth::user();
       if ($user->hasRole('super-admin|admin|manager')) {
         $data = MpesaCode::latest();
       } else {
         $data = MpesaCode::latest()->where('client_id', $user->client_id);
       }
       if ($request->ajax()) {
           $data = $data->with('client')->select('mpesa_codes.*');
           return Datatables::of($data)
                   ->addIndexColumn()
                   ->addColumn('client', function (MpesaCode $mpesaCode) {
                       return $mpesaCode->client ? Str::limit($mpesaCode->client->clientName, 30, '...') : '';
                   })
                   ->addColumn('action', function($row){
                     if ( Auth::user()->can('mpesaCode-delete')) {
                       $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
                       $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';
                     }else {
                       $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
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

       return view('mpesa_codes.index');
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request)
     {
       $clients = Client::all();
       $responseType = [
         'Completed'
       ];
       $confirmationURL = [
         config('app.go-conf-url')
       ];
       $validationURL = [
         config('app.go-valid-url')
       ];
       return view('mpesa_codes.create',compact('clients','responseType','confirmationURL','validationURL'));
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
      'client' => ['required'],
      'code' => ['required', 'unique:mpesa_codes', 'max:255'],
      'responseType' => ['required'],
      'confirmationURL' => ['required'],
      'validationURL' => ['required'],
      'consumerKey' => ['required'],
      'consumerSecret' => ['required'],
        ]);

      $user = Auth::user();


      $requestContent = [
          'headers' => [
              'Content-Type' => 'application/json'
          ],
          'json' => [
            'clientId' => $request->client,
            'ShortCode' => $request->code,
            'ResponseType' => $request->responseType,
            'ConfirmationURL' => $request->confirmationURL,
            'ValidationURL' => $request->validationURL,
            'ConsumerKey' => $request->consumerKey,
            'ConsumerSecret' => $request->consumerSecret
          ]
      ];

      try {
        $client = new Cl();

        $apiRequest = $client->request('POST', config('app.go-mpesa-reg'), $requestContent);
      }

      catch (RequestException $e) {
        if ($e->hasResponse()) {
          $response = $e->getResponse();
          // var_dump($response->getStatusCode())
          // var_dump($response->getReasonPhrase());
          $res = json_decode($response->getBody());
          // return response()->json($res->error);
          return back()->with('error',$res->error);
        }
      }
      catch (ConnectException $e) {
        if ($e) {
          return response()->json('Failed to connect to server!');
        }
      }
      return back()->with('success','Mpesa Code Registered Successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MpesaCode  $mpesaCode
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $mpesaCode = MpesaCode::find(id($id));
      return view('mpesa_codes.show',compact('mpesaCode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MpesaCode  $mpesaCode
     * @return \Illuminate\Http\Response
     */
    public function edit(MpesaCode $mpesaCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MpesaCode  $mpesaCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MpesaCode $mpesaCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MpesaCode  $mpesaCode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = id($id);
        MpesaCode::find($id)->delete();
    }
}
