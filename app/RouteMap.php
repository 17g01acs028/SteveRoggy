<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class RouteMap extends Model
{
  protected $fillable = [
    'client_id',
    'network_id',
    'route_id',
    'price',
    'user_id',
  ];

  public function client()
  {
      return $this->belongsTo('App\Client');
  }


  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function network()
  {
      return $this->belongsTo('App\Network');
  }

  public function route()
  {
      return $this->belongsTo('App\Route');
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
