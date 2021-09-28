<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Carbon\Carbon;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'client_id',
        'username',
        'timezone',
        'notify',
        'threshold',
        'time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
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

    public function notfis()
    {
        return $this->hasMany('App\Notfi');
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

    public function getTimeAttribute($value)
    {
        $timezone = isset(Auth::user()->timezone) ? Auth::user()->timezone : config('app.timezone');
        return Carbon::parse($value)->timezone($timezone)->format('H:i');
    }

    public function setTimeAttribute($value)
    {
        $this->attributes['time'] = Carbon::parse($value, Auth::user()->timezone)
                ->setTimezone(config('app.timezone'))->format('H:i');
    }

}
