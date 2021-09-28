<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Balance extends Model
{
    protected $fillable = [
        'client_id',
        'bal_before',
        'amount',
        'bal_after',
        'type',
      ];

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

}
