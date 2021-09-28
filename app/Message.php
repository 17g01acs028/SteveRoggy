<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Message extends Model
{

  protected $fillable = [
    'client_id',
    'user_id',
    'source',
    'dest',
    'text',
    'parts',
    'status',
    'cost',
    'route',
    'msgid',
    'error_message'
  ];

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function client()
  {
      return $this->belongsTo('App\Client');
  }

  public function getCreatedAtAttribute($value)
   {
      $timezone = isset(Auth::user()->timezone) ? Auth::user()->timezone : config('app.timezone');
      return Carbon::parse($value)->timezone($timezone);
   }
  public function getUpdatedAtAttribute($value)
  {
      $timezone = isset(Auth::user()->timezone) ? Auth::user()->timezone : config('app.timezone');
      return Carbon::parse($value)->timezone($timezone);
  }

  // public function getStatusAttribute($value)
  // {
  //      $word = strtok($value, " ");
  //      if ($word == 'UNDELIV') {
  //       $value = 'UNDELIV'; 
  //      }
  //     return $value;
  // }

}
