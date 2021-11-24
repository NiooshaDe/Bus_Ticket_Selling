<?php


namespace App\Filters;


use Illuminate\Support\Carbon;

class TimeFilter
{
    public function filter($builder, $value)
    {
        $value = Carbon::parse($value)->format('Y-m-d');

        return $builder->whereDate('starting_date_time', $value);
    }
}
