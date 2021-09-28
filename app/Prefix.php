<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Prefix extends Model
{
  protected $fillable = [
    'network_id',
    'prefix',
    'prefix_length',
    'number_length'
  ];
  public function network()
  {
      return $this->belongsTo('App\Network');
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
