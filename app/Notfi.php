<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Notfi extends Model
{

  protected $fillable = [
    'client_id',
    'user_id',
    'type',
    'sender',
    'message'
  ];

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function client()
  {
      return $this->belongsTo('App\Client');
  }


}
