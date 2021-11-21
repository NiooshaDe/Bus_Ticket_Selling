<?php


namespace App\Filters;


class BusFilter extends AbstractFilter
{
    protected $filters = [
        'name' => BusNameFilter::class,
    ];
}
