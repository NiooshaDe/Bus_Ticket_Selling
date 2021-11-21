<?php

namespace App\Models;

use App\Filters\TicketFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

//    protected $fillable = ['number', 'starting_date_time', 'beginning'];

    protected $guarded = [];
    public function users()
    {
        return $this->belongsToMany
        (User::class, 'ticket_user', 'ticket_id', 'user_id');
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id', 'id');
    }

    public function scopeFilter(Builder $builder, $request)
    {
        return (new TicketFilter($request))->filter($builder);
    }
}
