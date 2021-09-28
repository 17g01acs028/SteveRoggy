<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use App\Schedule;
use DB;
use App\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as Cl;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use App\Template;
use Illuminate\Support\Facades\Validator;

use App\Jobs\PingJob1;
use Amqp;

class MessageController extends Controller
{
  // function __construct()
  // {
  //      $this->middleware('permission:message-list|message-create|message-edit|message-delete', ['only' => ['index','show']]);
  //      $this->middleware('permission:message-create', ['only' => ['create','store']]);
  //      $this->middleware('permission:message-createStep1', ['only' => ['createStep1']]);
  //      $this->middleware('permission:message-postCreateStep1', ['only' => ['postCreateStep1']]);
  //      $this->middleware('permission:message-postCreateStep2', ['only' => ['postCreateStep2']]);
  // }

  public function index(Request $request)
  {
    $user = Auth::user();
    $startDate = date('Y-m-d H:i:s', strtotime ("-1 day"));
    $endDate = date('Y-m-d H:i:s');

    if ($user->hasRole('super-admin|admin|manager')) {
      $data = Message::orderBy('created_at', 'DESC')->where('created_at','>=', $startDate);
    } else {
      $data = Message::orderBy('created_at', 'DESC')->where('client_id', $user->client_id)->where('created_at','>=', $startDate);
    }

    $messagez = $data->paginate(100);
    $i = 1;
    $cost = $data->sum('cost');
    $allMess = $data->sum('parts');
    return view('messages.index', compact('messagez','i','cost','startDate','endDate','allMess'));
    // return response()->json($messagez);

    // if ($request->ajax()) {
    //     $data = $data->with('user')->with('client')->select('messages.*');
    //     return Datatables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('client', function (Message $message) {
    //                 return $message->client ? Str::limit($message->client->clientName, 30, '...') : '';
    //             })
    //             ->addColumn('user', function (Message $message) {
    //                 return $message->user ? Str::limit($message->user->username, 30, '...') : '';
    //             })
    //             ->addColumn('action', function($row){
    //                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm showItem">Show</a>';
    //                     return $btn;
    //             })
    //             ->rawColumns(['action'])
    //             ->editColumn('created_at', function ($data) {
    //                return [
    //                   'display' => date('d/m/Y H:i:s A', strtotime($data->created_at)),
    //                   'timestamp' => $data->created_at->timestamp
    //                ];
    //             })
    //             ->editColumn('updated_at', function ($data) {
    //                return [
    //                   'display' => date('d/m/Y H:i:s A', strtotime($data->updated_at)),
    //                   'timestamp' => $data->updated_at->timestamp
    //                ];
    //             })
    //             ->filterColumn('created_at', function ($query, $keyword) {
    //                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
    //             })
    //             ->filterColumn('updated_at', function ($query, $keyword) {
    //                $query->whereRaw("DATE_FORMAT(updated_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
    //             })
    //             ->make(true);
    // }
    // if ($user->hasRole('super-admin|admin|manager')) {
    //   $data = DB::table('messages')
    //     ->select(
    //       DB::raw('status as status'),
    //       DB::raw('count(*) as number'))
    //     ->groupBy('status')
    //     ->get();
    // } else {
    //   $data = DB::table('messages')
    //     ->select(
    //       DB::raw('status as status'),
    //       DB::raw('count(*) as number'))
    //     ->where('client_id', $user->client_id)
    //     ->groupBy('status')
    //     ->get();
    // }
    //
    // $array[] = ['Status', 'Number'];
    // foreach ($data as $key => $value) {
    //   $array[++$key] = [$value->status, $value->number];
    // }
    // $status = json_encode($array);
    //
    // return view('messages.index', compact('status'));
  }

  public function createStepReport1(Request $request)
  {
      // $network = $request->session()->get('message');
      $user = Auth::user();
      $client = Client::find($user->client_id);
      $senders = $client->senders;
      $templates = Template::where('client_id', $user->client_id)->get();
      $messagez = Message::all();
      return view('messages.index', compact('templates','senders','messagez'));
  }


    public function postCreateStepReport1(Request $request)
    {
      // global $startDate, $endDate, $phonenumber;

      $user = Auth::user();

      $startDate = "none";
      $endDate = "none";

      if ($request->input('checkbox') != "on" ) {
        $validator = Validator::make($request->all(), [
          'startDate' => ['required'],
          'endDate' => ['required']
          ]);
        $startDate = strtotime($request->input('startDate'));
        $endDate = strtotime($request->input('endDate'));
        $startDate = date('Y-m-d H:i:s', $startDate);
        $endDate = date('Y-m-d H:i:s', $endDate);

        $validator->after(function ($validator) use ($request) {
          if ( strtotime($request->input('startDate')) > strtotime($request->input('endDate')) ) {
              $validator->errors()->add('endDate', 'Invalid EndDate!');
          }

      });

      if ($validator->fails()) {
        return redirect('/messages')
            ->withErrors($validator)
            ->withInput();
      }

        if ($user->hasRole('super-admin|admin|manager')) {
          $data = Message::orderBy('created_at', 'DESC')->where('created_at','>=', $startDate)->where('created_at','<=', $endDate);
        } else {
          $data = Message::orderBy('created_at', 'DESC')->where('client_id', $user->client_id)->where('created_at','>=', $startDate)->where('created_at','<=', $endDate);
        }

      } else {

        if ($user->hasRole('super-admin|admin|manager')) {
          $data = Message::orderBy('created_at', 'DESC');
        } else {
          $data = Message::orderBy('created_at', 'DESC')->where('client_id', $user->client_id);
        }

      }

    if ($request->input('filterBy') == "2") {
      $validator = Validator::make($request->all(), [
        'filterBy' => ['max:1']],
        ['filterBy.max' => 'Invalid phone number format']
        );
        if ($validator->fails()) {
          return redirect('/messages')
              ->withErrors($validator)
              ->withInput();
      }

      $phonenumber = $request->input('filterValue');
      // $data = $data->filter(function ($item) {
      //   return $item->dest == '254000000000';
      // });
      // $data = $data->all();
      $data = $data->where('dest', $phonenumber);
    }

    if ($request->input('filterBy') == "3") {
      $validator = Validator::make($request->all(), [
        'filterBy' => ['required', 'string', 'max:30']],
        ['filterBy.required' => 'Invalid status',
        'filterBy.string' => 'Invalid status',
        'filterBy.max' => 'Invalid status']
        );
        if ($validator->fails()) {
          return redirect('/messages')
              ->withErrors($validator)
              ->withInput();
      }
      $status = $request->input('filterValue');
      $data = $data->where('status', $status);
    }

    if ($request->input('filterBy') == "4") {
      $validator = Validator::make($request->all(), [
        'filterBy' => ['required', 'string', 'max:30']],
        ['filterBy.required' => 'Invalid Source Address',
        'filterBy.string' => 'Invalid Source Address',
        'filterBy.max' => 'Invalid Source Address']
        );
        if ($validator->fails()) {
          return redirect('/messages')
              ->withErrors($validator)
              ->withInput();
      }
      $senderId = $request->input('filterValue');
      $data = $data->where('source', $senderId );
    }

      $messagez = $data->paginate(100);
      $cost = $data->sum('cost');
      $allMess = $data->sum('parts');
      $i = 1;
      return view('messages.index', compact('messagez','i','cost','startDate','endDate','allMess'));
      return back()->with('success','Filter created successfully!');
    }

  public function create(Request $request)
  {
    return view('messages.create');
  }

  public function store(Request $request)
  {
    $validator = $request->validate([
    'source' => ['required'],
    'dest' => ['required'],
    'text' => ['required'],
      ]);

    $user = Auth::user();
    Message::updateOrCreate(['id' => $request->id],
    ['client_id' => $user->client_id, 'user_id' => $user->id, 'source' => $request->source, 'dest' => $request->dest, 'text' => $request->text]);

  return redirect("/messages");
  }

  public function show($id)
  {
    $id = id($id);
    $message = Message::find($id);
    return view('messages.show',compact('message'));
  }

  public function createStep1(Request $request)
  {
      // $network = $request->session()->get('message');
      $user = Auth::user();
      $client = Client::find($user->client_id);
      $senders = $client->senders;
      $templates = Template::where('client_id', $user->client_id)->get();
      return view('messages.create-step3', compact('templates','senders'));
  }

  public function postCreateStep1(Request $request)
  {
      $validator = $request->validate([
          'source' => ['required'],
          'dest' => ['required'],
          'text' => ['required'],
      ]);
      $user = Auth::user();
    //todo validate phone numbers
      //split the text at space position
      $phoneNumbersArray = explode(" ",$request->dest);
      //check the numbers and confirm their lengths
      foreach ($phoneNumbersArray as $phoneNumber) {
          //check if number is 254
          if (strlen($phoneNumber) == 12) {

              $arr = array(
                  'user' => $user,
                  'send' => array(
                      'user' => $user->username,
                      'source' => $request->source,
                      'dest' => $phoneNumber,
                      'message' => $request->text
                  )
              );

              $js = json_encode($arr);
              try {
                  Amqp::publish('RKey-LARAVEL', $js, [ 'queue' => 'SENDLARAVEL-Q','exchange_type' => 'direct','exchange' => 'SMS-EXCHANGE'] );
              } catch (RequestException $e) {
                  if ($e->hasResponse()) {
                      $response = $e->getResponse();
                      var_dump($response->getStatusCode());
                      var_dump($response->getReasonPhrase());
                      $res = json_decode($response->getBody());
                      var_dump($response->getBody());
                      return response()->json($res->error);
                  }
              }
              catch (ConnectException $e) {
                  if ($e) {
                      return response()->json('Failed to connect to rabbitMq!');
                  }
              }
          }
      }

    return back()->with('success','Message sent successfully!');
  }

  public function postCreateStep2(Request $request)
  {
//    $requestData = $request->all();
//    $requestData['phonenumber'] = str_replace("+", "", $requestData['phonenumber']);
//    $requestData['phonenumber'] = str_replace(" ", "", $requestData['phonenumber']);
//    $request->replace($requestData);

    $validatedData = $request->validate([
      'source' => ['required'],
      'text' => ['required'],
      'send_time' => ['required'],
      'phonenumber' => ['required'],
    ]);

     $timestamp = Carbon::createFromFormat('Y-m-d H:i:s', $request->send_time, Auth::user()->timezone);
      // $timestamp = Carbon::createFromFormat('Y-m-d H:ia', $request->send_time, Auth::user()->timezone);

      $timestamp->setTimezone(config('app.timezone'));

      $user = Auth::user();
      //todo validate phone numbers
      $phoneNumbersArray = explode(" ",$request->phonenumber);

      foreach ($phoneNumbersArray as $phoneNumber) {

          $con = Contact::where('phonenumber', $phoneNumber)->where('client_id', $user->client_id )->first();
          $id = isset($con) ? $con->id : "";
          $contact = Contact::updateOrCreate(['id' => $id],
              ['client_id' => $user->client_id, 'user_id' => $user->id, 'phonenumber' => $phoneNumber]);

          Schedule::updateOrCreate(['id' => $request->id],
              ['client_id' => $user->client_id, 'user_id' => $user->id, 'contact_id' => $contact->id, 'source' => $request->source, 'text' => $request->text, 'send_time' => $timestamp ]);
      }
    // return redirect("/tabM2");
    return back()->with('success','Schedule created successfully!');
  }


}

