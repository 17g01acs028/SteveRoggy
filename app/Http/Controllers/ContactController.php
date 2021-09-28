<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\CsvImportRequest;
use App\CsvData;
use App\Client;
use App\User;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Group;
use App\ContactGroup;
use GuzzleHttp\Client as Cl;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Log;
use App\Jobs\UploadContactsJob;

use Amqp;


class ContactController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:contact-list|contact-create|contact-edit|contact-delete', ['only' => ['index','show']]);
    $this->middleware('permission:contact-create', ['only' => ['create','store']]);
    $this->middleware('permission:contact-edit', ['only' => ['edit','update']]);
    $this->middleware('permission:contact-delete', ['only' => ['destroy']]);
    $this->middleware('permission:contact-getImport', ['only' => ['getImport']]);
    $this->middleware('permission:contact-parseImport', ['only' => ['parseImport']]);
    $this->middleware('permission:contact-processImport', ['only' => ['processImport']]);
  }


  public function index(Request $request)
  {

    $user = Auth::user();
    if ($user->hasRole('super-admin|admin|manager')) {
      $data = Contact::latest();
    } else {
      $data = Contact::latest()->where('client_id', $user->client_id);
    }
    if ($request->ajax()) {
        $data = $data->with('user')->with('client')->select('contacts.*');
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function (Contact $contact) {
                    return $contact->client ? Str::limit($contact->client->clientName, 30, '...') : '';
                })
                ->addColumn('user', function (Contact $contact) {
                    return $contact->user ? Str::limit($contact->user->username, 30, '...') : '';
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

    return view('contacts.index');
  }


  public function create(Request $request)
  {
    $user = Auth::user();
    if ($user->hasRole('super-admin|admin|manager')) {
      $groups = Group::all();
    } else {
      $groups = Group::where('client_id', $user->client_id)->get();
    }
    return view('contacts.create', compact('groups'));
  }


  public function store(Request $request)
  {
    $requestData = $request->all();
    $requestData['phonenumber'] = str_replace("+", "", $requestData['phonenumber']);
    $requestData['phonenumber'] = str_replace(" ", "", $requestData['phonenumber']);
    $request->replace($requestData);
    $validator = Validator::make($request->all(),[
    'phonenumber' => ['required'],
      ]);

    $user = Auth::user();

    $validator->after(function ($validator) use ($request) {
      if (Contact::where('client_id', Auth::user()->client_id)->where('phonenumber', $request->input('phonenumber'))->first()) {
          $validator->errors()->add('phonenumber', 'This phone number already exists!!');
      }
    });
    if ($validator->fails()) {
        return redirect(route('contacts.create'))
            ->withErrors($validator)
            ->withInput();
    }
    $contact = Contact::updateOrCreate(['id' => $request->id],
    ['client_id' => $user->client_id, 'user_id' => $user->id, 'phonenumber' => $request->phonenumber,'name' => $request->name, 'field_1' => $request->field_1, 'field_2' => $request->field_2, 'field_3' => $request->field_3]);

    if ($request->group_id) {
      if (!(ContactGroup::where('contact_id',$contact->id)->where('group_id',$request->group_id)->first())) {
        $group = Group::find($request->group_id);
        $group->contacts()->attach($contact->id);
      }
    }

  return redirect("/contacts");
  }


  public function show($id)
  {
    $id = id($id);
    $contact = Contact::find($id);
    return view('contacts.show',compact('contact'));
  }


  public function edit($id)
  {
    $id = id($id);
    $contact = Contact::find($id);
    return view('contacts.edit',compact('contact'));
  }


  public function update(Request $request, Contact $contact)
  {
    $requestData = $request->all();
    $requestData['phonenumber'] = str_replace("+", "", $requestData['phonenumber']);
    $requestData['phonenumber'] = str_replace(" ", "", $requestData['phonenumber']);
    $request->replace($requestData);

    $validator = Validator::make($request->all(),[
    'phonenumber' => ['required'],
      ]);

      $validator->after(function ($validator) use ($request) {
        if (Contact::where('client_id', Auth::user()->client_id)->where('phonenumber', $request->input('phonenumber'))->first()) {
            $validator->errors()->add('phonenumber', 'This phone number already exists!!');
        }
      });
      $id = $request->segment(2);
      $id = id($id);
      if ($validator->fails()) {
          return redirect("/contacts/$id/edit")
              ->withErrors($validator)
              ->withInput();
      }

    $request->phonenumber = str_replace("+", "", $request->phonenumber);
    $contact->update($request->all());

    return back()->with('success','Contact updated successfully!');
  }


  public function destroy($id)
  {
      $id = id($id);
      Contact::find($id)->delete();
  }



    public function getImport()
    {
        return view('contacts.import');
    }

    public function parseImport(Request $request)
    {
      $validator = Validator::make($request->all(),[
          'csv_file' => 'required|file|max:10240'
        ]);
      $user = Auth::user();
      $validator->after(function ($validator) use ($request) {
        if (Group::where('client_id', Auth::user()->client_id)->where('name', $request->name)->first()) {
            $validator->errors()->add('name', 'A group with this name already exists!!');
        }
      });
        if ($validator->fails()) {
            return redirect(route('import'))
                ->withErrors($validator)
                ->withInput();
        }

        $path = $request->file('csv_file');
        $data = array_map('str_getcsv', file($path));

        $csv_data_file = CsvData::create([
          'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
          'csv_header' => $request->has('header'),
          'csv_data' => json_encode($data)
        ]);

        $csv_data = array_slice($data, 0, 2);

        //get filename with the get_loaded_extensions
        $filenameWithExt = $request->file('csv_file')->getClientOriginalName();
        //get just file name
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //GET JUST ext
        $extension = $request->file('csv_file')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        $path = $request->file('csv_file')->storeAs('uploads',$fileNameToStore);
        $path = storage_path('app/public/'.$path);

        if ($request->name) {
          Group::updateOrCreate(['id' => $request->id],
          ['client_id' => $user->client_id, 'user_id' => $user->id, 'name' => $request->name]);
        }


        $user = Auth::user();
        if ($user->hasRole('super-admin|admin|manager')) {
          $groups = Group::all();
        } else {
          $groups = Group::where('client_id', $user->client_id)->get();
        }
        // return response()->json($csv_file_path);
        return view('contacts.import_fields', compact('csv_data', 'csv_data_file', 'groups', 'path'));
    }

    public function processImport(Request $request)
    {
        $user = Auth::user();

        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);

        foreach ($csv_data as $row) {
          // UploadContactsJob::dispatch($request->all(),$row,$user)->onQueue('uploads');

          $phonenumber = "";
          if (!empty($row[0])) {
          $phonenumber = $row[0];
          $phonenumber = str_replace("+", "", $phonenumber);
          $phonenumber = str_replace(" ", "", $phonenumber);
          }
          $name = "";
          if (!empty($row[1])) {
            $name = $row[1];
          }
          $field_1 = "";
          if (!empty($row[2])) {
            $field_1 = $row[2];
          }
          $field_2 = "";
          if (!empty($row[3])) {
            $field_2 = $row[3];
          }
          $field_3 = "";
          if (!empty($row[4])) {
            $field_3 = $row[4];
          }


          $arr = array(
            'phonenumber' => $phonenumber,
            'client_id' => $user->client_id,
            'user_id' => $user->id,
            'name' => $name,
            'field_1' => $field_1,
            'field_2' => $field_2,
            'field_3' => $field_3,
            'group_id' => $request->group_id
          );

          $js = json_encode($arr);
          try {
              Amqp::publish('RKey-ContUpload', $js, [ 'queue' => 'CONTACTSUPLD-Q','exchange_type' => 'direct','exchange' => 'SMS-EXCHANGE'] );
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
        CsvData::find($request->csv_data_file_id)->delete();
        return redirect("/groups")->with('success','Contacts are uploading!');

    }

}
