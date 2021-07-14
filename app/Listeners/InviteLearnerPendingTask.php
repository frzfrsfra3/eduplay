<?php

namespace App\Listeners;

use App\Events\InviteLearner;
use App\Models\Pendingtask;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
use Exception;


class InviteLearnerPendingTask
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
     * param  InviteLearner  $event
     * return void
     */
    public function handle(InviteLearner $event)
    {

        //send a notification to the teacher of that class "a new enroll request is waiting your approval"
        try {



            // add to pending task asking to learner  to accept request join to class
            $task=new Pendingtask();

            $task->user_id= $event->learner_id;
            $task->sender_id=Auth::user ()->id;

            $task->pending_task_description="Teacher ". Auth::user ()->name . " has invited you to class : " . $event->Courseclass->class_name ;
            $task->pending_task_description_ar="الاستاذ ". Auth::user ()->name . " يدعوك للانضمام الى الصف " . $event->Courseclass->class_name ;
            $task->pending_task_action="/courseclasses/show/".$event->Courseclass->id;
            $task->status="pending";
            $task->save();

            $task=Pendingtask::where('user_id' ,'=' ,Auth::user ()->id)->where('pending_task_description' ,'=','invite learners ')
                ->where('pending_task_action' ,'=','/courseclasses/show/'.$event->Courseclass->id)->first();
            if ($task) {
                $task->status="done";
                $task->save();
            }

        }
        catch (Exception $exception){
            Storage::disk ('local')->append ('InviteLearnerPendingTask.txt', $exception);


    }



    }
}
