<?php

namespace App\Listeners;

use App\Events\AssignCompleted;
use Log;
use Illuminate\Support\Facades\Storage;

class EmailNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AssignCompleted $event)
    {
        //notify the teacher of the class that someone has finished his assignment
        $event->assignment->title;
    }

    public function onActionTaken(){

        Storage::disk ('local')->append ('mailsent.txt', 'send mail');
}

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Actiontaken',
            'App\Listeners\EmailNotification@onActionTaken'
        );

        $events->listen(
            'App\Events\EnrollRequested',
            'App\Listeners\EmailNotification@onActionTaken'
        );
    }
}
