<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;
use App\Contact;

use App\User;
use DB;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:home-list', ['only' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $success = Message::where('client_id', $user->client_id)->where('status', 'Successful')->get();
        $total = Message::where('client_id', $user->client_id)->get();
        $successCount = $success->count();
        $totalCount = $total->count();

        $contacts = Contact::where('client_id', $user->client_id);
        $contactsCount = $contacts->count();

        return view('home', compact('successCount','totalCount','contactsCount',));
    }

    public function postCreateStep(Request $request)
    {
      $user = Auth::user();

     if ($request->startDate != '' && $request->endDate != '') {
        $startDate = strtotime($request->startDate);
        $endDate = strtotime($request->endDate);
        $startDate = date('Y-m-d H:i:s', $startDate);
        $endDate = date('Y-m-d H:i:s', $endDate);
        if ($user->hasRole('super-admin|admin|manager')) {
          $data = Message::select('status', DB::raw("count(*) as number"))
          ->where('created_at','>=', $startDate)->where('created_at','<=', $endDate)
          ->groupBy('status')
          ->get();
        } else {
          $data = Message::select('status', DB::raw("count(*) as number"))
          ->where('created_at','>=', $startDate)->where('created_at','<=', $endDate)
          ->where('client_id', $user->client_id)
          ->groupBy('status')
          ->get();
        }

     } else {
        $startDate = date('Y-m-d H:i:s', strtotime ("-1 day"));
        $endDate = date('Y-m-d H:i:s');
        if ($user->hasRole('super-admin|admin|manager')) {
          $data = Message::select('status', DB::raw("count(*) as number"))
          ->where('created_at','>=', $startDate)->where('created_at','<=', $endDate)
          ->groupBy('status')
          ->get();
        } else {
          $data = Message::select('status', DB::raw("count(*) as number"))
          ->where('created_at','>=', $startDate)->where('created_at','<=', $endDate)
          ->where('client_id', $user->client_id)
          ->groupBy('status')
          ->get();
        }

      }

    $array = [];
    foreach($data as $key => $value) {
       $array['label'][] = $value->status;
       $array['data'][] = (int) $value->number;
     }

   $array['chart_data'] = json_encode($array);
    echo json_encode($array);

    }


}
