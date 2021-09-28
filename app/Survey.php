<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'surveys';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

//FILLABLE

    public $fillable =[
        'client_id',
        'name',
        'description',
        'finish_message',
        'session_lifespan'
    ];

//TYPE CAST


protected $cast =[
'id' => 'integer',
'client_id'=> 'integer',
'name'=>'string',
'description'=> 'string',
'finish_message'=> 'string',
'session_lifespan'=>'integer',

];

//VALIDATION


public static $rules =[


// 'client_id'=>'required',

'name'=>'required|string|max:55',

'description'=>'required|max:255',

'finish_message'=>'required|string|max:255',

'session_lifespan'=>'required|max:255',

'deleted_at'=>'nullable',

'created_at'=> 'nullable',

'updated_at' => 'nullable',

];


// a survey belongs to a  client
public function client()
{
    return $this->belongsTo('App\Client');
}

//a surveys one or many questions
public function questions(){
   return $this->hasMany(App\Question::class);
}

//a survey has one to many responses
public function response(){
   return $this->hasMany(App\Response::class);
}

}
