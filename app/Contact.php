<?php

namespace App;

use App\Group;
use App\Structure;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
