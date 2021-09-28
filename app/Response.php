<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'responses';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

//FILLABLE

    public $fillable =[
        'client_id',
        'contact_id',
        'question_id',
        'response'
    ];

//TYPE CAST


protected $cast =[
'id' => 'integer',
'client_id'=> 'integer',
'contact_id'=> 'integer',
'question_id'=> 'integer',
'response'=>'string'
];

//VALIDATION


public static $rules =[


'client_id'=>'required',

'contact_id'=>'required',

'question_id'=>'required',

'response'=>'required|string|max:255',

'deleted_at'=>'nullable',

'created_at'=> 'nullable',

'updated_at' => 'nullable',

];



public function question()
{
    return $this->belongsTo('App\Question');
}

public function survey(){
    $this->hasMany(App\Survey::class);
}

public function contact(){
    $this->belongsTo('App\Contact');
}
}
