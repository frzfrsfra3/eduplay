<?php

namespace App\Listeners;

use App\Events\Actiontaken;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


use App\Events\ExerciseSetCreated;
use App\Models\Usernotification;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendingtask;
use Exception;

class ExerciseSetCreatedListener
{
    /**
     * Create the event listener.
     *
     * return void
     */
    public function __construct ()
    {
        //
    }

    /**
     * Handle the event.
     *
     * param  Actiontaken $event
     * return void
     */
    public function handle (ExerciseSetCreated $event)
    {

        try {

            $task= Pendingtask::where('user_id','=',Auth::user ()->id)
                               ->where ('pending_task_description','=','Create or buy an exercise set')
                               ->first();

            if ($task)
            {
                $task->status='done';
                $task->save();
            }
            return;




        } catch (Exception $exception) {
            Storage::disk ('local')->append ('ExerciseSetCreatedListener.txt', $exception);


        }
    }

}
