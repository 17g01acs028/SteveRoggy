<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
  protected $fillable = [
    'email',
    'token',
    'client_id',
    'username'
  ];

  public function client()
  {
      return $this->belongsTo('App\Client');
  }

}
