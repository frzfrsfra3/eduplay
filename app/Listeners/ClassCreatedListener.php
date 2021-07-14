<?php

namespace App\Listeners;

use App\Events\ClassCreated;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendingtask;
use Exception;

class ClassCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct ()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle (ClassCreated $event)
    {

        try {

            $task= Pendingtask::where('user_id','=',Auth::user ()->id)
                ->where ('pending_task_description','=','Create a Class')
                ->first();

            if ($task)
            {
                $task->status='done';
                $task->save();
            }

            $task=new Pendingtask();

            $task->user_id=Auth::user ()->id;
            $task->sender_id="0";
            $task->pending_task_description="Add an exercise set to your class";
            $task->pending_task_description_ar="أضف تمرينًا تم تعيينه على الفصل";
            $task->pending_task_action="/courseclasses/show/".$event->course->id;
            $task->status="pending";
            $task->save();

            // ASK TO invite learners

            $task=new Pendingtask();

            $task->user_id=Auth::user ()->id;
            $task->sender_id="0";
            $task->pending_task_description="invite learners";
            $task->pending_task_description_ar="دعوة المتعلمين";
            $task->pending_task_action="/courseclasses/show/".$event->course->id;
            $task->status="pending";
            $task->save();




        } catch (Exception $exception) {
            Storage::disk ('local')->append ('handleEnrollRequestederor.txt', $exception);


        }
    }

}
