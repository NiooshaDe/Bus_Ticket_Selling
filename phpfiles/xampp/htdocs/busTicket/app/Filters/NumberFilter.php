<?php


namespace App\Filters;


class NumberFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('number', $value);
    }
}
