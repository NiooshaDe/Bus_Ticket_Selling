<?php


namespace App\Filters;


class BusNameFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('name', $value);
    }
}
