<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use App\Group;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Template;

class ScheduleController extends Controller
{
  function __construct()
  {
       $this->middleware('permission:schedule-list|schedule-create|schedule-edit|schedule-delete', ['only' => ['index','show']]);
       $this->middleware('permission:schedule-create', ['only' => ['create','store']]);
       $this->middleware('permission:schedule-edit', ['only' => ['edit','update']]);
       $this->middleware('permission:schedule-delete', ['only' => ['destroy']]);
  }

  public function index(Request $request)
  {
    $user = Auth::user();
    if ($user->hasRole('super-admin|admin|manager')) {
      $data = Schedule::latest();
    } else {
      $data = Schedule::where('client_id', $user->client_id);
    }

    if ($request->ajax()) {
        $data = $data->with('client')->with('user')->with('contact')->with('group')->select('schedules.*');
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function (Schedule $schedule) {
                    return $schedule->client ? Str::limit($schedule->client->clientName, 30, '...') : '';
                })
                ->addColumn('user', function (Schedule $schedule) {
                    return $schedule->user ? Str::limit($schedule->user->username, 30, '...') : '';
                })
                ->addColumn('contact', function (Schedule $schedule) {
                    return $schedule->contact ? Str::limit($schedule->contact->phonenumber, 30, '...') : '';
                })
                ->addColumn('group', function (Schedule $schedule) {
                    return $schedule->group ? Str::limit($schedule->group->name, 30, '...') : '';
                })
                ->addColumn('action', function($row){
                  $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem">Edit</a>';
                  $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Delete</a>';
                 return $btn;
                })
                ->rawColumns(['action'])
                ->editColumn('send_time', function ($data) {
                   return [
                      'display' => date('d/m/Y H:i:s A', strtotime($data->send_time)),
                      'timestamp' => $data->send_time->timestamp
                   ];
                })
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

    return view('schedules.index');
  }

  public function create(Request $request)
  {
    return view('schedules.create');
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(),[
    'source' => ['required'],
    'text' => ['required'],
    'send_time' => ['required'],
      ]);

    $user = Auth::user();

    Schedule::updateOrCreate(['id' => $request->id],
    ['client_id' => $user->client_id, 'user_id' => $user->id, 'group_id' => $request->group_id, 'contact_id' => $request->contact_id, 'source' => $request->source, 'text' => $request->text, 'send_time' => $request->send_time, 'status' => $request->status ]);

  return redirect("/schedules");
  }

  public function show(Schedule $schedule)
  {
    return view('schedules.show',compact('schedule'));
  }

  public function edit($id)
  {
    $id = id($id);
    $user = Auth::user();
    if ($user->hasRole('super-admin|admin|manager')) {
      $templates = Template::all();
    } else {
      $templates = Template::where('client_id', $user->client_id)->get();
    }
    $schedule = Schedule::find($id);

    return view('schedules.edit',compact('schedule','templates'));
  }

  public function update(Request $request, Schedule $schedule)
  {
    $validator = Validator::make($request->all(),[
    'source' => ['required'],
    'text' => ['required'],
    'send_time' => ['required'],
      ]);

    $schedule->update($request->all());
    return back()->with('success','Schedule updated successfully!');
  }

  public function destroy($id)
  {
    $id = id($id);
      Schedule::find($id)->delete();
  }



}
