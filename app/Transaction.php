<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Transaction extends Model
{
  protected $fillable = [
      'client_id', 'mpesa_code_id', 'TransactionType', 'TransID', 'TransTime', 'TransAmount', 'BusinessShortCode',
      'BillRefNumber', 'OrgAccountBalance', 'MSISDN', 'FirstName', 'MiddleName', 'LastName', 'status', 'error_message'
  ];


  public function client()
  {
      return $this->belongsTo('App\Client');
  }

  public function mpesa_code()
  {
      return $this->belongsTo('App\MpesaCode');
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
