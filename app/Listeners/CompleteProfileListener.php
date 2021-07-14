<?php

namespace App\Listeners;

use App\Events\CompleteProfile;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendingtask;
use Exception;

class CompleteProfileListener
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
    public function handle (CompleteProfile $event)
    {

        try {

            Storage::disk ('local')->append ('CompleteProfileListener.txt', $event->profilepercent);

            if($event->profilepercent > 75) {
            $task= Pendingtask::where('user_id','=',Auth::user ()->id)
                               ->where ('pending_task_description','=','Complete your profile')
                               ->first();

            if ($task)
            {
                $task->status='done';
                $task->save();
            }
            }
            return;




        } catch (Exception $exception) {
            Storage::disk ('local')->append ('CompleteProfileListener.txt', $exception);


        }
    }

}
