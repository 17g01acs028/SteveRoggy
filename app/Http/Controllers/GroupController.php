<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Message;
use App\Schedule;
use Carbon\Carbon;
use GuzzleHttp\Client as Cl;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use App\Template;
use App\Jobs\SendMessageJob;

use Amqp;

class GroupController extends Controller
{
  function __construct()
  {
       $this->middleware('permission:group-list|group-create|group-edit|group-delete', ['only' => ['index','show']]);
       $this->middleware('permission:group-create', ['only' => ['create','store']]);
       $this->middleware('permission:group-edit', ['only' => ['edit','update']]);
       $this->middleware('permission:group-delete', ['only' => ['destroy']]);
       $this->middleware('permission:group-createStep1', ['only' => ['createStep1']]);
       $this->middleware('permission:group-postCreateStep1', ['only' => ['postCreateStep1']]);
       $this->middleware('permission:group-postCreateStep2', ['only' => ['postCreateStep2']]);
  }

  public function index(Request $request)
  {
    $user = Auth::user();
    if ($user->hasRole('super-admin|admin|manager')) {
      $data = Group::latest();
    } else {
      $data = Group::latest()->where('client_id', $user->client_id);
    }
    if ($request->ajax()) {
        $data = $data->with('user')->with('client')->select('groups.*');
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function (Group $group) {
                    return $group->client ? Str::limit($group->client->clientName, 30, '...') : '';
                })
                ->addColumn('user', function (Group $group) {
                    return $group->user ? Str::limit($group->user->username, 30, '...') : '';
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

    return view('groups.index');
  }

  public function create(Request $request)
  {
    return view('groups.create');
  }


  public function store(Request $request)
  {
    $validator = Validator::make($request->all(),[
    'name' => ['required'],
      ]);

    $user = Auth::user();

    $validator->after(function ($validator) use ($request) {
      if (Group::where('client_id', Auth::user()->client_id)->where('name', $request->input('name'))->first()) {
          $validator->errors()->add('name', 'A group with this name already exists!!');
      }
    });
    if ($validator->fails()) {
        return redirect(route('groups.create'))
            ->withErrors($validator)
            ->withInput();
    }

    Group::updateOrCreate(['id' => $request->id],
    ['client_id' => $user->client_id, 'user_id' => $user->id, 'name' => $request->name]);

  return redirect("/groups");
  }

  public function show($id)
  {
    $id = id($id);
    $group = Group::find($id);
    return view('groups.show',compact('group'));
  }

  public function edit($id)
  {
    $id = id($id);
    $group = Group::find($id);
    return view('groups.edit',compact('group'));
  }


  public function update(Request $request, Group $group)
  {
      $validator = Validator::make($request->all(),[
      'name' => ['required'],
        ]);
      $validator->after(function ($validator) use ($request) {
        if (Group::where('client_id', Auth::user()->client_id)->where('name', $request->input('name'))->first()) {
            $validator->errors()->add('name', 'A group with this name already exists!!');
        }
      });
      $id = $request->segment(2);
      $id = id($id);
      if ($validator->fails()) {
          return redirect("/groups/$id/edit")
              ->withErrors($validator)
              ->withInput();
      }

    $group->update($request->all());
    return back()->with('success','Group updated successfully!');
  }

  public function destroy($id)
  {
      $id = id($id);
      Group::find($id)->delete();
  }

  public function createStep1(Request $request)
  {
    $user = Auth::user();
    $client = Client::find($user->client_id);
    $senders = $client->senders;
    if ($user->hasRole('super-admin|admin|manager')) {
      $groups = Group::all();
    } else {
      $groups = Group::where('client_id', $user->client_id)->get();
    }
      $templates = Template::where('client_id', $user->client_id)->get();
      return view('groups.create-step3', compact('groups','templates','senders'));
  }

  public function postCreateStep1(Request $request)
  {

    $validator = $request->validate([
    'source' => ['required'],
    'group_id' => ['required'],
    'text' => ['required'],
      ]);

    $user = Auth::user();
    $group = Group::find($request->group_id);
    $data = $group->contacts;
    $res = "";


    foreach ($data as $row) {
      // SendMessageJob::dispatch($row,$request->all(),$user)->onQueue('messages');
      $phonenumber = $row->phonenumber;
      $name = $row->name;
      $field_1 = $row->field_1;
      $field_2 = $row->field_2;
      $field_3 = $row->field_3;
      $requestText = $request->text;
      $requestText = str_replace("<name>", $name, $requestText);
      $requestText = str_replace("<field_1>", $field_1, $requestText);
      $requestText = str_replace("<field_2>", $field_2, $requestText);
      $requestText = str_replace("<field_3>", $field_3, $requestText);
      

        $arr = array(
          'user' => $user,
          'send' => array(
            'user' => $user->username,
            'source' => $request->source,
            'dest' => $phonenumber,
            'message' => $requestText,
            'msgID' => Str::random(12)
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
            // return response()->json($res->error);
          }
        }
        catch (ConnectException $e) {
          if ($e) {
            return response()->json('Failed to connect to rabbitMq!');
          }
        }
      // $phonenumber = $row->phonenumber;
      // $name = $row->name;
      // $field_1 = $row->field_1;
      // $field_2 = $row->field_2;
      // $field_3 = $row->field_3;
      // $requestText = $request->text;
      // $requestText = str_replace("<name>", $name, $requestText);
      // $requestText = str_replace("<field_1>", $field_1, $requestText);
      // $requestText = str_replace("<field_2>", $field_2, $requestText);
      // $requestText = str_replace("<field_3>", $field_3, $requestText);
      //
      // $requestContent = [
      //     'headers' => [
      // 'Accept' => 'application/json',
      // 'Content-Type' => 'application/json',
      // 'Authorization' => 'Bearer '.config('app.go-tok')
      //     ],
      //     'json' => [
      //       'user' => $user->username,
      //       'source' => $request->source,
      //       'dest' => $phonenumber,
      //       'message' => $requestText
      //     ]
      // ];
      // try {
      //   $client = new Cl();
      //
      //   $apiRequest = $client->request('POST', config('app.go-endpont'), $requestContent);
      // }
      // catch (RequestException $e) {
      //   if ($e->hasResponse()) {
      //     $response = $e->getResponse();
      //     // var_dump($response->getStatusCode())
      //     // var_dump($response->getReasonPhrase());
      //     $res = json_decode($response->getBody());
      //     // return response()->json($res->error);
      //     // return back()->with('error',$res->error)->with('success', 'For Prefix error: Message is delivered for contacts in the group list occuring before the contact with unavailable route');
      //   }
      // }
      // catch (ConnectException $e) {
      //   if ($e) {
      //     return response()->json('Failed to connect to routing engine!');
      //   }
      // }

    }
    if ($res) {
      return back()->with('error',$res->error);
    }
    return back()->with('success','Message sent to group successfully!');
  }

  public function postCreateStep2(Request $request)
  {

    $validatedData = $request->validate([
      'source' => ['required'],
      'group_id' => ['required'],
      'text' => ['required'],
      'send_time' => ['required'],
    ]);
    $timestamp = Carbon::createFromFormat('Y-m-d H:i:s', $request->send_time, Auth::user()->timezone);
    $timestamp->setTimezone(config('app.timezone'));

    $user = Auth::user();

    Schedule::updateOrCreate(['id' => $request->id],
    ['client_id' => $user->client_id, 'user_id' => $user->id, 'group_id' => $request->group_id, 'source' => $request->source, 'text' => $request->text, 'send_time' => $timestamp ]);

    // return redirect("/tabG2");
    return back()->with('success','Schedule created successfully!');
  }

}
