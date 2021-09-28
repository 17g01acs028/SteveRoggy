<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
  function __construct()
  {
       $this->middleware('permission:template-list|template-create|template-edit|template-delete', ['only' => ['index','show']]);
       $this->middleware('permission:template-create', ['only' => ['create','store']]);
       $this->middleware('permission:template-edit', ['only' => ['edit','update']]);
       $this->middleware('permission:template-delete', ['only' => ['destroy']]);
  }

  public function index(Request $request)
  {
    $user = Auth::user();
    if ($user->hasRole('super-admin|admin|manager')) {
      $data = Template::latest();
    } else {
      $data = Template::latest()->where('client_id', $user->client_id);
    }
    if ($request->ajax()) {
        $data = $data->with('user')->with('client')->select('templates.*');
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function (Template $template) {
                    return $template->client ? Str::limit($template->client->clientName, 30, '...') : '';
                })
                ->addColumn('user', function (Template $template) {
                    return $template->user ? Str::limit($template->user->username, 30, '...') : '';
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

                ->filterColumn('created_at', function ($query, $keyword) {
                   $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                })
                ->make(true);
    }

    return view('templates.index');
  }

  public function create(Request $request)
  {
    return view('templates.create');
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(),[
    'name' => ['required'],
    'message' => ['required'],
      ]);

    $user = Auth::user();

    $validator->after(function ($validator) use ($request) {
      if (Template::where('client_id', Auth::user()->client_id)->where('name', $request->input('name'))->first()) {
          $validator->errors()->add('name', 'A template with this name already exists!!');
      }
    });
    if ($validator->fails()) {
        return redirect(route('templates.create'))
            ->withErrors($validator)
            ->withInput();
    }
    $contact = Template::updateOrCreate(['id' => $request->id],
    ['client_id' => $user->client_id, 'user_id' => $user->id, 'name' => $request->name,'message' => $request->message]);

  return redirect("/templates");
  }

  public function show($id)
  {
    $id = id($id);
    $template = Template::find($id);
    return view('templates.show',compact('template'));
  }


  public function edit($id)
  {
    $id = id($id);
    $template = Template::find($id);
    return view('templates.edit',compact('template'));
  }

  public function update(Request $request, Template $template)
  {
    $validator = Validator::make($request->all(),[
    'name' => ['required'],
    'message' => ['required'],
      ]);

    $template->update($request->all());

    return back()->with('success','Template updated successfully!');
  }

  public function destroy($id)
  {
      $id = id($id);
      Template::find($id)->delete();
  }
}
