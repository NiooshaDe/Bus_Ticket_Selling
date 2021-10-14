<?php

namespace App\Listeners;

use App\Events\SecondTest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SecondTestListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SecondTest  $event
     * @return void
     */
    public function handle(SecondTest $event)
    {
        var_dump('The event and listener is done');
    }
}
