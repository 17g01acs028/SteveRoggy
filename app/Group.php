<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Group extends Model
{
  protected $fillable = [
      'client_id', 'user_id', 'name'
  ];

  public function client()
  {
      return $this->belongsTo('App\Client');
  }

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function contacts()
  {
    return $this->belongsToMany('App\Contact');
  }

  public function schedules()
  {
      return $this->hasMany('App\Schedule');
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
