<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenderPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'sender_id','description', 'price',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function sender()
    {
        return $this->belongsTo('App\Sender');
    }

}
