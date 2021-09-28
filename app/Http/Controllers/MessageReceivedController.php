<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Contact;
use App\Conversation;
use App\Message;
use App\ReceivedMessage;
use App\ShortCode;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Amqp;

class MessageReceivedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function messagesReceived(Request $request){
        $input = $request->only(
            'contact_id', 'short_code_id', 'MESSAGE',
        );
        ReceivedMessage::create([
                'contact_id' => $input['contact_id'],
                'short_code_id' => $input['short_code_id'],
                'message' => $input['MESSAGE'],
            ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $startDate = date('Y-m-d H:i:s', strtotime ("-1 day"));
        $endDate = date('Y-m-d H:i:s');
//    $data = ReceivedMessage::orderBy('created_at', 'DESC')->where('created_at','>=', $startDate);
        if ($user->hasRole('super-admin|admin|manager')) {
            $data = ReceivedMessage::orderBy('created_at', 'DESC');
          } else {
            $data = ReceivedMessage::orderBy('created_at', 'DESC')->where('client_id', $user->client_id);
          }
        $messagez = $data->paginate(100);
        $i = 1;
        $allMess = $data->sum('id');
        return view('messages_received.index', compact('messagez','i','startDate','endDate','allMess'));

    }
    public function getShortCodes(Request $request){
        $user = Auth::user();
        if ($user->hasRole('super-admin|admin|manager')) {
            $data = DB::table('short_codes')->orderBy('created_at', 'asc')->get();
        } else {
            $data = DB::table('short_codes')->where('client_id', $user->client_id)->orderBy('created_at', 'asc')->get();
        }
        return response()->json($data);
    }
         public function user_list($ids = null){
             $user = Auth::user();
             if (!$ids) {
                 if ($user->hasRole('super-admin|admin|manager')) {
                     $data = DB::table('short_codes')->orderBy('created_at', 'asc')->find(1);
                     $id =$data->id;
                 }
                 else {
                     $data = DB::table('short_codes')->where('client_id', $user->client_id)->first();
                     $id =$data->id;
                 }
             }
             if ($ids) {
                 $id =$ids;
             }
             $code = ShortCode::findOrFail($id);
             $users = DB::table('conversations')
                 ->leftJoin('contacts', function ($join) use ($id){
                     $join->on('conversations.contact_id', '=', 'contacts.id')
                         ->where('conversations.short_code_id', '=', $id);
                 })
                 ->groupBy('conversations.contact_id')
                 ->get();
             if(\Request::ajax()){
                 return response()->json([
                     'users'=>$users,
                     'short_code'=>$code,
                 ]);
             }
             return abort(404);
     }
    public function user_message($id=null,$short_code_id=null){
        $user = Auth::user();
        $contact = Contact::findOrFail($id);
        $conversations = DB::table('conversations')
            ->join('contacts', function ($join) use ($contact){
                $join->on('conversations.contact_id', '=', 'contacts.id')
                    ->where('contacts.id', '=', $contact->id);
            })
            ->leftJoin('messages', 'conversations.message_id', '=', 'messages.id')
            ->leftJoin('received_messages', 'conversations.received_message_id', '=', 'received_messages.id')
            ->select('contacts.phonenumber','contacts.name','messages.text as outgoing','received_messages.message as incoming','conversations.created_at')
            //  ->where('conversations.client_id', '=', $user->client_id)
            ->where('conversations.short_code_id', '=', $short_code_id)
            ->get();
        return response()->json([
            'messages'=>$conversations,
            'user'=>$contact,
        ]);
    }
    public function send_message(Request $request){
        if(!$request->ajax()){
            abort(404);
        }
        $user = Auth::user();
        $contact = Contact::findOrFail($request->user_id);
        $shortCode = ShortCode::findOrFail($request->short_code_id);
        $arr = array(
            'user' => $user,
            'send' => array(
                'user' => $user->username,
                'source' => $shortCode->short_code,
                'dest' => $contact->phoneNumber,
                'message' => $request->message
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
        return response()->json($messages,201);
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
    public function inbox()
    {
       return view('messages_received.inbox');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
