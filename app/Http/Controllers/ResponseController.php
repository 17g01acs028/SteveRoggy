<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Contact;
use App\Question;
use App\Response;
use Auth;
use App\Repositories\ResponseRepository;
use App\Http\Requests\CreateResponseRequest;
use App\Http\Requests\UpdateResponseRequest;
use Illuminate\Support\Facades\DB;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $responseRepository;

    public function __construct(ResponseRepository $responseRepo){
       $this->responseRepository = $responseRepo;
    }
    public function index(Request $request)
    {
        //'
        $users = Auth::user();
        if ($users->hasRole('super-admin|admin|manager')) {
          $data = Response::all();
        } else {
          $data = Response::where('client_id', $users->client_id);
        }


        //joining client contact and questions and response table

        $clients = Client::all();
        $questions = Question::all();
        $contacts = Contact::all();

        $responses = $this->responsesRepository->all();
        $responseJoin = DB::table('responses')->select(
            'clients.*',
            'contacts.*',
            'questions.*',
            'responses.*'
        )->join('clients','clients.id', '=', 'responses.client_id')
        ->join('contacts', 'contacts.id', '=', 'responses.contact_id')
        ->join('questions','questions.id','=', 'responses.question_id')->get();
    return view('response.index',compact('responseJoin','clients','contacts','questions','responses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //I will create a modal for this function create
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateResponseRequest $request)
    {
        //
        $input = Question::all();
        $response = $this->responseRepository->create($input);

        return redirect(route('response.index'))->with('status','response Created successfully');
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
        $clients = Client::all();
        $contacts = Contact::all();

        $responses = $this->responsesRepository->find($id);
        if(empty($responses)){
            return redirect (route('responses.index'))->with('statuserror','response not found');
        }
        return view('question.show',compact('contacts','clients','questions','responses'));
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
        $clients = Client::all();
        $contacts = Contact::all();

        $responses = $this->responsesRepository->find($id);
        if(empty($responses)){
            return redirect (route('responses.index'))->with('statuserror','response not found');
        }
        return view('question.edit',compact('contacts','clients','questions','responses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResponseRequest $request, $id)
    {
        //
        $responses = $this->responseRepository->find($id);
        if(empty($response)){
            return redirect(route('response.index'))->with('statuserror','response not found');

        }
    //updating the content of the update function call
        $response = $this->responseRepository->update($request->all(), $id);
        return redirect(route('response.index'))->with('status','response updated successfully');
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
        $response = $this->responseRepository->find($id);
        if(empty($response)){
            return redirect(route('response.index'))->with('statuserror','record not found');

        }
        //otherwise
        $response = $this->responseRepository->delete($id);
        return redirect(route('response.index'))->with('status','Record Deleted successfully');
    }
}
