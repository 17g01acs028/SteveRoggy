<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Network extends Model
{
  protected $fillable = [
    'name'
  ];

  public function prefixes()
  {
      return $this->hasMany('App\Prefix');
  }

  public function route_maps()
  {
      return $this->hasMany('App\RouteMap');
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
