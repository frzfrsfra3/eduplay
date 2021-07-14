<?php

namespace App\Listeners;

use App\Events\Publish;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewVersionPublished
{
    /**
     * Create the event listener.
     *
     * return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * param  Publish  $event
     * return void
     */
    public function handle(Publish $event)
    {
        // access the Discipline from $event->discipline;
        // notify all teachers who have exercise sets in this discipline that a new version is available
    }
}
