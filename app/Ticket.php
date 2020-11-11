<?php

namespace App;

use App\Structure;
use App\CategorieTicket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['id'];

    public function categorie_ticket()
    {
        return $this->belongsTo(CategorieTicket::class);
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }
}
