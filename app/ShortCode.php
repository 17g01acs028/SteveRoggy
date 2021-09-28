<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortCode extends Model
{
    use HasFactory;

    protected $table = 'short_codes';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'short_code','description',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function received_messages()
    {
        return $this->hasMany('App\ReceivedMessage');
    }
    public function short_code_prices()
    {
        return $this->hasMany('App\ShortcodePrice');
    }
}
