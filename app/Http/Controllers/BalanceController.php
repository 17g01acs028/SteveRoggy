<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Balance;

use GuzzleHttp\Client as Cl;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Validator;

class BalanceController extends Controller
{
    public function index(Request $request)
    {
      $user = Auth::user();
      $startDate = date('Y-m-d H:i:s', strtotime ("-1 day"));
      $endDate = date('Y-m-d H:i:s');
  
      if ($user->hasRole('super-admin|admin|manager')) {
        $data = Balance::orderBy('created_at', 'DESC')->where('created_at','>=', $startDate);
      } else {
        $data = Balance::orderBy('created_at', 'DESC')->where('client_id', $user->client_id)->where('created_at','>=', $startDate);
      }
      
      // $messagez = $data->paginate(100);
      // $i = 1;
      // $cost = $data->sum('cost');
      // $allMess = $data->sum('parts');
      return view('balances.index', compact('messagez','i','cost','startDate','endDate','allMess'));

    }

    public function create(Request $request)
    {
      return view('balances.create');
    }

    public function store(Request $request)
    {
      global $res;
      $validator = Validator::make($request->all(),[
      'amount' => ['required'],
      'phonenumber' => ['required'],
        ]);
  
      $user = Auth::user();
    

      $requestContent = [
        'headers' => [
          'Accept' => 'application/json',
          'Content-Type' => 'application/json'
        ],
        'json' => [
          'Username' => $user->username,
          'Amount' => $request->amount,
          'PhoneNumber' => $request->phonenumber
        ]
      ];
      try {
        $client = new Cl();
        $apiRequest = $client->request('POST', config('app.go-stk-url'), $requestContent);
      }
      catch (RequestException $e) {
        if ($e->hasResponse()) {
          $response = $e->getResponse();
          var_dump($response->getStatusCode());
          var_dump($response->getReasonPhrase());
          $res = json_decode($response->getBody());
          // var_dump($response->getBody());
          // return response()->json($res->error);
          return back()->with('error',$res->error);
        }
      }
      catch (ConnectException $e) {
        if ($e) {
          return response()->json('Failed to connect to payment engine!');
        }
      }
      // return response()->json($res);
      // return back()->with('success','Payment made successfully!');

      return redirect("/balances/create")->with('success','Payment initiated successfully!');
    }



}
