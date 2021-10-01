<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\manage;
use App\Models\manageOptions;
use Illuminate\Support\Facades\Schema;
use DB;
use URL;

class saveQuestions extends Controller
{
   public function create(){
     return view("question.create?id=1");
   }
   
    public function index(Request $req){
      $req -> validate([
        'question' => 'required|string',
        'type' => 'required|in:number_range,Teaxt_area,Options'
      ],
      [
        'question.required' => 'Please Create Question',
        'type.required' => 'Please select Answer type',
  
      ]
        );
        if($req -> type ==="Options"){
  
          $req -> validate([
           
            'labelO1' => 'required',
            'labelO2' => 'required',
          ],
           [
            'labelO1.required' => 'Please make sure all Options Answer Type field are field before submit',
            'labelO2.required' => 'Please make sure all Options Answer Value field are field before submit',
           
            
          ]
            );
        }else if($req -> type ==="number_range"){
          $req -> validate([
            
            'label1' => 'required|numeric',
          
           ],
           [
            'label1.required' => 'Please make sure all Number Range field are field before submit',
            'label1.numeric' => 'Number Range Fields only allows Numerical Values',
            
          ]
            );
        }

      $current_date = date('Y-m-d H:i:s');
        $id=$_GET['id'];
        $client=$_GET['client'];
        $last=$_GET['last'];
      
        if(isset($_POST['saveE'])){
         if($req -> type ==="Options"){
           $data1=[
         
             'client_id' => $client,
             'survey_id' => $last, 
          
             'text' => $req -> question,
             'q_num' => $id,
             'expected_response_type' => "Option",
             'expected_response' => "Choice one Option",
             "created_at"=> $current_date,"updated_at"=> $current_date,
           ];
           
           DB::table('questions') -> insert($data1);
           $lastid=DB::getPdo()->lastInsertId();;
           foreach($req-> labelO1 as $key => $Insert){
             $data=[
               'key' => $req -> labelO1[$key],
               'value' => $req -> labelO2[$key],
               //****HAPA****//
               'client_id' =>1,
               'question_id' => $lastid ,
               "created_at"=> $current_date,"updated_at"=> $current_date,
             ];
             
             DB::table('options') -> insert($data);
           }
           
            
           return redirect('survey');
     }else if($req -> type ==="Teaxt_area"){
           $data1=[
             //****HAPA****//
             'client_id' =>  $client,
             'survey_id' => $last, 
             'text' => $req -> question,
             'q_num' => $id,
             'expected_response_type' => "Text",
             'expected_response' => "Type your Answer",
             "created_at"=> $current_date,"updated_at"=> $current_date,
           ];
           
           DB::table('questions') -> insert($data1);
           
           return redirect('survey');
     
     }else if($req -> type ==="number_range"){
       $data1=[
         //****HAPA****//
         'client_id' =>  $client,
         'survey_id' => $last, 
         'text' => $req -> question,
         'q_num' =>$id,
         'expected_response_type' => "Number_Range",
         'expected_response' => $req -> label1[0]."-".$req -> label1[1],
         "created_at"=> $current_date,"updated_at"=> $current_date,
       ];
       
       DB::table('questions') -> insert($data1);
       return redirect('survey');
     }
              
        }else{
         if($req -> type ==="Options"){
           $data1=[
           //****HAPA****//
             'client_id' =>  $client,
             'survey_id' => $last, 
          
             'text' => $req -> question,
             'q_num' => $id,
             'expected_response_type' => "Option",
             'expected_response' => "Choice one Option",
             "created_at"=> $current_date,"updated_at"=> $current_date,
           ];
           
           DB::table('questions') -> insert($data1);
           $lastid=DB::getPdo()->lastInsertId();;
           foreach($req-> labelO1 as $key => $Insert){
             $data=[
               'key' => $req -> labelO1[$key],
               'value' => $req -> labelO2[$key],
               //****HAPA****//
               'client_id' =>1,
               'question_id' => $lastid ,
               "created_at"=> $current_date,"updated_at"=> $current_date,
             ];
             
             DB::table('options') -> insert($data);
           }
         
            
           return redirect('question/create?id='.($req ->input('id')+1).'&client='.$client.'&last='.$last);
     }else if($req -> type ==="Teaxt_area"){
           $data1=[
             //****HAPA****//
             'client_id' =>  $client,
             'survey_id' => $last, 
             'text' => $req -> question,
             'q_num' => $id,
             'expected_response_type' => "Text",
             'expected_response' => "Type your Answer",
             "created_at"=> $current_date,"updated_at"=> $current_date,
           ];
           
           DB::table('questions') -> insert($data1);
           
           return redirect('question/create?id='.($req ->input('id')+1).'&client='.$client.'&last='.$last);
     
     }else if($req -> type ==="number_range"){
       $data1=[
         //****HAPA****//
         'client_id' =>  $client,
         'survey_id' => $last, 
         'text' => $req -> question,
         'q_num' => $id,
         'expected_response_type' => "Number_Range",
         'expected_response' => $req -> label1[0].",".$req -> label1[1],
         "created_at"=> $current_date,"updated_at"=> $current_date,
       ];
       
       DB::table('questions') -> insert($data1);
       return redirect('question/create?id='.($req ->input('id')+1).'&client='.$client.'&last='.$last);
     }
        }
       
       }
   
}
