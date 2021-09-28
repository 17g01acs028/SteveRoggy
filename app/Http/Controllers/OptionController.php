<?php

namespace App\Http\Controllers;
use App\Client;
use App\Question;
use App\Option;
use Auth;
use App\Repositories\OptionRepository;
use App\Http\Requests\CreateOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $optionRepository;

    public function __construct(OptionRepository $optionRepo){
       $this->optionRepository = $optionRepo;
    }
    public function index()
    {
        //
        $users = Auth::user();
        if ($users->hasRole('super-admin|admin|manager')) {
          $data = Option::all();
        } else {
          $data = Option::where('client_id', $users->client_id);
        }


        //joining clients and questions and options table

        $clients = Client::all();
        $questions = Question::all();

        $options = $this->optionRepository->all();
        $optionJoin = DB::table('responses')->select(
            'clients.*',
            'questions.*',
            'options.*'
        )->join('clients','clients.id', '=', 'options.client_id')
        ->join('questions','questions.id','=', 'options.question_id')->get();
    return view('option.index',compact('optionJoin','clients','questions','options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //I will create a modal for this function
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOptionRequest $request)
    {
        //
          //
          $input = Option::all();
          $options = $this->optionRepository->create($input);

          return redirect(route('option.index'))->with('status','option Created successfully');

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
        $question = Question::all();

        $options = $this->optionRepository->find($id);
        if(empty($options)){
            return redirect (route('option.index'))->with('statuserror','option not found');
        }
        return view('option.show',compact('clients','questions','options'));
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
        $question = Question::all();

        $options = $this->optionRepository->find($id);
        if(empty($options)){
            return redirect (route('option.index'))->with('statuserror','option not found');
        }
        return view('option.edit',compact('clients','questions','options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOptionRequest $request, $id)
    {
        //
         //
         $options = $this->optionRepository->find($id);
         if(empty($options)){
             return redirect(route('option.index'))->with('statuserror','option not found');

         }
     //updating the content of the update function call
         $options = $this->optionRepository->update($request->all(), $id);
         return redirect(route('option.index'))->with('status','option updated successfully');
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
        $options = $this->optionRepository->find($id);
        if(empty($option)){
            return redirect(route('option.index'))->with('statuserror','record not found');

        }
        //otherwise
        $options = $this->optionRepository->delete($id);
        return redirect(route('option.index'))->with('status','Record Deleted successfully');
    }
}
