<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Usernotification;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendingtask;
use Exception;
use File;

class UserRegisteredListener
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
    public function handle (UserRegistered $event)
    {
        try {
            // based on the user role this list of tasks should be changed

            // Get to Know EduPlayCloud
            $task4 = new Pendingtask();
            $task4->user_id = $event->user->id;
            $task4->sender_id = "0";
            $task4->pending_task_description = "Get to know EduPlayCloud";
            $task4->pending_task_description_ar = "تعرف على EduPlayCloud";
            $task4->pending_task_action = "/get/to/know";
            $task4->status = "pending";
            $task4->task_type = 1;
            $task4->sort = 1;
            $task4->save();

            //Complete your profile
            $task = new Pendingtask();
            $task->user_id = $event->user->id;
            $task->sender_id = "0";
            $task->pending_task_description = "Complete your profile";
            $task->pending_task_description_ar = "اكمل الملف";
            $task->pending_task_action = "/users/profile/".$event->user->id;
            $task->status = "pending";
            $task->task_type = 1;
            $task->sort = 2;
            $task->save();

            // Create or buy an exercise set
            $task2 = new Pendingtask();
            $task2->user_id = $event->user->id;
            $task2->sender_id = "0";
            $task2->pending_task_description = "Create or buy an exercise set";
            $task2->pending_task_description_ar = "أضف تمرين";
            $task2->pending_task_action = "/exercisesets/private";
            $task2->status = "pending";
            $task2->task_type = 1;
            $task2->sort = 3;
            $task2->save();

            if ($event->user->hasRole ('Teacher')) {
                // Create Class for teacher role
                $task3 = new Pendingtask();
                $task3->user_id = $event->user->id;
                $task3->sender_id = "0";
                $task3->pending_task_description = "Create a class";
                $task3->pending_task_description_ar = "أضف صف";
                $task3->pending_task_action = "/courseclasses/myclasses";
                $task3->status = "pending";
                $task3->task_type = 1;
                $task3->sort = 4;
                $task3->save();
            }
            // Join class
            if ($event->user->hasRole ('Learner')) {
                // Create Class for Learner role
                $task6 = new Pendingtask();
                $task6->user_id = $event->user->id;
                $task6->sender_id = "0";
                $task6->pending_task_description = "Join a class";
                $task6->pending_task_description_ar = "انضمام فئة";
                $task6->pending_task_action = "/explore/classes";
                $task6->status = "pending";
                $task6->task_type = 1;
                $task6->sort = 4;
                $task6->save();
            }

            // Invite Learner
            $task5 = new Pendingtask();
            $task5->user_id = $event->user->id;
            $task5->sender_id = "0";
            $task5->pending_task_description = "Invite your friend to use Eduplaycloud";
            $task5->pending_task_description_ar = "دعوة صديقك لاستخدام Eduplaycloud";
            $task5->pending_task_action = "/invitefriend/eduplaycloud";
            $task5->status = "pending";
            $task5->task_type = 1;
            $task5->sort = 5;
            $task5->save();


            $path = public_path('assets/eduplaycloud/upload/exercisesset/user-'.$event->user->id);
            if(!is_dir($path)) {
                File::makeDirectory($path, 0777, true, true);
                File::makeDirectory($path.'/image', $mode = 0777, true, true);
                File::makeDirectory($path.'/audio', $mode = 0777, true, true);
                File::makeDirectory($path.'/csv', $mode = 0777, true, true);
            }

        } catch (Exception $exception) {
            Storage::disk('local')->append('handleUserRegistered.txt', $exception);
        }
    }
}
