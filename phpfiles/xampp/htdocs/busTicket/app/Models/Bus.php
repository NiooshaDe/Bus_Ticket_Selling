<?php

namespace App\Models;

use App\Filters\BusFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bus extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'sites', 'air_conditioning', 'grade', 'company_id'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'bus_id', 'id');
    }

    public function scopeFilter(Builder $builder, $request)
    {
        return (new BusFilter($request))->filter($builder);
    }
}
