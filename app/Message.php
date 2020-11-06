<?php

namespace App;

use App\Structure;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }
}
