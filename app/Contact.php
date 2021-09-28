<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Contact extends Model
{
  public $fillable = [
    'client_id', 'user_id', 'phonenumber', 'name', 'field_1', 'field_2', 'field_3'
  ];

  public function client()
  {
      return $this->belongsTo('App\Client');
  }
    public function chats(){
        return $this->hasMany(Chat::class,'from');
    }
  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function groups()
  {
    return $this->belongsToMany('App\Group');
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
    public function received_messages()
    {
        return $this->hasMany('App\ReceivedMessage');
    }
}
