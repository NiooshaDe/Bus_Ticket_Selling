<?php

namespace App\Listeners;

use App\Events\GroupOne;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GroupOneListener
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
     * @param  GroupOne  $event
     * @return void
     */
    public function handle(GroupOne $event)
    {
        //
    }
}
