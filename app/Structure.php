<?php

namespace App;

use App\Ticket;
use App\Contact;
use App\Message;
use App\DefaultMessage;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $guarded = ['id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function defaultmessages()
    {
        return $this->hasMany(DefaultMessage::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
