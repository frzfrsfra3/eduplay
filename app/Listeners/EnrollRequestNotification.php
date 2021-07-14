<?php

namespace App\Listeners;

use App\Events\AssignCompleted;
use App\Events\EnrollRequested;
use App\Models\Usernotification;
use App\Models\Pendingtask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
use Exception;


class EnrollRequestNotification
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
    public function handle(EnrollRequested $event)
    {

        //send a notification to the teacher of that class "a new enroll request is waiting your approval"
        try {

            $event->Courseclass->title;
            $notification = new Usernotification;
            $notification->notification = " A new Enroll request is waiting your approval in Class  " . $event->Courseclass->title;
            $notification->receiver_userid = $event->Courseclass->teacher_userid;
            $notification->sender_userid = Auth::user ()->id;
            $notification->save ();

            // add to pending task asking teacher to accept request
            $task=new Pendingtask();

            $task->user_id= $event->Courseclass->teacher_userid;
            $task->sender_id=Auth::user ()->id;
            $task->pending_task_description="action needed for enroll request";
            $task->pending_task_description_ar="الإجراء المطلوب لطلب التسجيل";
            $task->pending_task_action="/courseclasses/show/".$event->Courseclass->id;
            $task->status="pending";
            $task->save();

        }
        catch (Exception $exception){
            Storage::disk ('local')->append ('handleEnrollRequestederor.txt', $exception);


        }

    }
}
