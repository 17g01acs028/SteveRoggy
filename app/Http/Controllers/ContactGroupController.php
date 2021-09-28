<?php

namespace App\Http\Controllers;

use App\ContactGroup;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Group;

class ContactGroupController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:contactGroup-show', ['only' => ['show']]);
         $this->middleware('permission:contactGroup-detach', ['only' => ['detach']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\ContactGroup  $contactGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Group $contactGroup, Request $request)
    {
      $user = Auth::user();
      if ($user->hasRole('super-admin|admin|manager')) {
        $group = Group::find($contactGroup->id);
      } else {
        $group = Group::where('id',$contactGroup->id)->where('client_id',$user->client_id)->first();
      }
      // return response()->json($contactGroup);
      $data = $group->contacts;
      if ($request->ajax()) {
          return Datatables::of($data)
                  ->addIndexColumn()

                  ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem">Remove</a>';
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
                  ->make(true);
      }
      return view('contact_groups.show',compact('contactGroup','group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContactGroup  $contactGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactGroup $contactGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContactGroup  $contactGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactGroup $contactGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContactGroup  $contactGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactGroup $contactGroup)
    {

    }

    public function detach(Request $request)
    {
      $group = Group::find(id($request->group));
      $group->contacts()->detach(id($request->row));
      return response()->json($request);
    }

}
