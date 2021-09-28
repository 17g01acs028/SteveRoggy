<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedMessage extends Model
{
    use HasFactory;

    protected $table = 'received_messages';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id', 'short_code_id','message', 'cost',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
    public function shortCode()
    {
        return $this->belongsTo('App\ShortCode');
    }
}
