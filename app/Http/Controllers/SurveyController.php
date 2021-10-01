<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\Client;
use Auth;
use App\Repositories\SurveyRepository;
use App\Http\Requests\CreateSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $surveyRepository;
    public function __construct(SurveyRepository $surveyRepo){
        $this->surveyRepository = $surveyRepo;
    }
    public function index(Request $request)
    {
        //
        $users = Auth::user();
        if ($users->hasRole('super-admin|admin|manager')) {
          $data = Survey::all();
        } else {
          $data = Survey::where('client_id', $users->client_id);
        }

        //joiningg tables clients users surveys
        $clients = Client::all();
        $survey = $this->surveyRepository->all();
        $surveyJoin = DB::table('surveys')->select(
            'clients.*',
            'surveys.*',
        )->join('clients','clients.id', '=', 'surveys.client_id')->get();
    return view('survey.index',compact('surveyJoin','clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // will be using a modal for the functionality



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSurveyRequest $request)
    {

        $input = new Survey;
        $client=Auth::user()->client_id;
        $input->client_id = Auth::user()->client_id;
        $input->name = $request->input('name');

        $input->description = $request->input('description');
        $input->finish_message = $request->input('finish_message');
        $input->session_lifespan = $request->input('session_lifespan');
        
        $input->save();
        // $input = Survey::all();
        // $survey = $this->surveyRepository->create($input);
        //?id=1&client ='.$client.'&last='.$lastid
        $lastid=DB::getPdo()->lastInsertId();
        return redirect('question/create?id=1&client='.$client.'&last='.$lastid)->with('status','Survey Created Successfully');
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
        $survey = $this->surveyRepository->find($id);
        if(empty($survey)){
            return redirect (route('survey.index'))->with('statuserror','survey not found');
        }
        return view('survey.show',compact('survey','clients'));
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
        $survey = $this->surveyRepository->find($id);
        if(empty($survey)){

            return redirect(route('survey.index'))->with('statuserror','survey not found');
        }
        return view('survey.edit',compact('survey','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurveyRequest $request, $id)
    {
        //
        $survey = $this->surveyRepository->find($id);
        if(empty($survey)){
            return redirect(route('survey.index'))->with('statuserror','Survey not found');

        }
    //updating the content of the update function call
        $survey = $this->surveyRepository->update($request->all(), $id);
        return redirect(route('survey.index'))->with('status','survey updated successfully');
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
        $survey = $this->surveyRepository->find($id);
        if(empty($survey)){
            return redirect(route('survey.index'))->with('statuserror','record not found');

        }
        //otherwise
        $survey = $this->surveyRepository->delete($id);
        return redirect(route('survey.index'))->with('status','Record Deleted successfully');
    }
}
