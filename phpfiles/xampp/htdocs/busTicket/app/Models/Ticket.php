<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany
        (Users::class, 'ticket_user', 'ticket_id', 'user_id');
    }
}
