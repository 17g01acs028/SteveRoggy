<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  protected $fillable = [
    'clientName',
    'clientAddress',
    'mobileNo',
    'accType',
    'accBalance',
    'accStatus',
    'httpDlrUrl',
    'dlrHttpMethod',
    'accLimit',
    'user_app_id',
    'user_id',
    'company_email'
  ];

  public function users()
  {
      return $this->hasMany('App\User');
  }

  public function invites()
  {
      return $this->hasMany('App\Invite');
  }

  public function allocations()
  {
      return $this->hasMany('App\Allocation');
  }

  public function route_maps()
  {
      return $this->hasMany('App\RouteMap');
  }

  public function messages()
  {
      return $this->hasMany('App\Message');
  }

  public function groups()
  {
      return $this->hasMany('App\Group');
  }

  public function contacts()
  {
      return $this->hasMany('App\Contact');
  }

  public function schedules()
  {
      return $this->hasMany('App\Schedule');
  }

  public function templates()
  {
      return $this->hasMany('App\Template');
  }

  public function senders()
  {
    return $this->belongsToMany('App\Sender');
  }

  public function mpesa_codes()
  {
      return $this->hasMany('App\MpesaCode');
  }

  public function transactions()
  {
      return $this->hasMany('App\Transaction');
  }

  public function notfis()
  {
      return $this->hasMany('App\Notfi');
  }

  public function received_messages()
  {
      return $this->hasMany('App\ReceivedMessage');
  }
    public function shortcode()
    {
        return $this->hasMany('App\ShortCode');
    }
    public function sender_prices()
    {
        return $this->hasMany('App\SenderPrice');
    }
    public function short_code_prices()
    {
        return $this->hasMany('App\ShortcodePrice');
    }

    public function survey(){
        return $this->hasMany('App\Survey');
    }
}
