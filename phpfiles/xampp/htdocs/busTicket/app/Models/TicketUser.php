<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketUser extends Model
{
    use HasFactory;
    protected $table = 'ticket_user';
    protected $fillable = ['user_id', 'ticket_id', 'seat_number', 'reserved', 'expired'];
    protected $dates = ['created_at', 'updated_at'];
}
