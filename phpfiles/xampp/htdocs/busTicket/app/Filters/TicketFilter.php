<?php


namespace App\Filters;


class TicketFilter extends AbstractFilter
{
    protected $filters = [
        'price' => PriceFilter::class,
        'number' => NumberFilter::class,
        'time' => TimeFilter::class,
    ];
}
