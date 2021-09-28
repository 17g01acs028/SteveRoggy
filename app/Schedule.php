<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Schedule extends Model
{
  protected $fillable = [
      'client_id', 'user_id', 'group_id', 'contact_id', 'source', 'text', 'send_time', 'status'
  ];

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function client()
  {
      return $this->belongsTo('App\Client');
  }

  public function group()
  {
      return $this->belongsTo('App\Group');
  }

  public function contact()
  {
      return $this->belongsTo('App\Contact');
  }

  public function getSendTimeAttribute($value)
   {
      $timezone = isset(Auth::user()->timezone) ? Auth::user()->timezone : config('app.timezone');
      return Carbon::parse($value)->timezone($timezone);
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

}
