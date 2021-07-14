<?php

namespace App\Listeners;

use App\Events\Actiontaken;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\AssignCompleted;
use App\Events\EnrollRequested;
use App\Models\Usernotification;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendingtask;
use Exception;

class ActiontakenListener
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
    public function handle (Actiontaken $event)
    {

        try {

            if ($event->actionname == 'accepted') {
                $this->accept ($event->classlearner);
            } elseif ($event->actionname == 'rejected') {
                $this->reject ($event->classlearner);
            }
        } catch (Exception $exception) {
            Storage::disk ('local')->append ('handleEnrollRequestederor.txt', $exception);


        }
    }


    private function accept ($classlearner)
    {
        try {

            $notification = new Usernotification;
            $notification->notification = "your request has been accepted to class " . $classlearner->courseclass->class_name;
            $notification->receiver_userid = $classlearner->user_id;
            $notification->sender_userid = Auth::user ()->id;
            $notification->save ();

            $this->taskaction($classlearner);


        } catch (Exception $exception) {
            Storage::disk ('local')->append ('handleEnrollRequestederor.txt', $exception);
        }

    }

    private function reject ($classlearner)
    {

        try {

            $notification = new Usernotification;
            $notification->notification = "your request has been accepted to class " . $classlearner->courseclass->class_name;
            $notification->receiver_userid = $classlearner->user_id;
            $notification->sender_userid = Auth::user ()->id;
            $notification->save ();
            $this->taskaction($classlearner);
        } catch (Exception $exception) {
            Storage::disk ('local')->append ('handleEnrollRequestederor.txt', $exception);
        }

    }

    private function taskaction ($classlearner){

            $task=Pendingtask::where('user_id','=',Auth::user ()->id)
        ->where('sender_id','=',$classlearner->user_id)
            ->where('pending_task_action','=',"/courseclasses/show/".$classlearner->class_id)->first();
  
        if ($task) {
            $task->status="done";
            $task->save();

        }
        return;

    }


}
