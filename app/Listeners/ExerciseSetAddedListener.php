<?php

namespace App\Listeners;

use App\Events\Actiontaken;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


use App\Events\ExerciseSetAdded;
use App\Models\Usernotification;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendingtask;
use Exception;

class ExerciseSetAddedListener
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
    public function handle (ExerciseSetAdded $event)
    {

        try {

            $task= Pendingtask::where('user_id','=',Auth::user ()->id)
                               ->where ('pending_task_description','=','Add an exercise set to your class')
                                ->where('pending_task_action','=','/courseclasses/show/'.$event->course->id)->first();

            if ($task)
            {
                $task->status='done';
                $task->save();
            }
            return;


            // ASK TO invite learners



        } catch (Exception $exception) {
            Storage::disk ('local')->append ('handleEnrollRequestederor.txt', $exception);


        }
    }

}
