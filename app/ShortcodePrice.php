<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortcodePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'short_code_id','description', 'price',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function short_code()
    {
        return $this->belongsTo('App\ShortCode');
    }
}
