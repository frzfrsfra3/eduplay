<?php

namespace App\Listeners;

use App\Events\ExamAdded;
use App\Models\Classexam;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendingtask;
use Exception;

class ExamAddedListener
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
    public function handle (ExamAdded $event)
    {

        try {
                Storage::disk ('local')->append ('handleEnrollRequestederor.txt','started--- >  handleEnrollRequestederor' );
                $learners=$event->course->learners()->get();
                $classexam=Classexam::where('class_id','=',$event->course->id)->where('exam_id','=',$event->exam->id)->first();
                Storage::disk ('local')->append ('handleEnrollRequestederor.txt',json_encode ($learners) );
                foreach ($learners as $learner) {

                    $task=new Pendingtask();
                    $task->user_id=$learner->id;
                    $task->sender_id=$event->course->teacher_userid;
                    $task->pending_task_description="Teacher added an Exam set to your class, it will start at ".$classexam->exam_start_date;
                    $task->pending_task_description_ar="اضاف الاستاذ امتحانا الى صفك في ".$classexam->exam_start_date;
                    $task->pending_task_action="/courseclasses/show/".$event->course->id;
                    $task->status="pending";
                    $task->save();
                }
                return;
        } catch (Exception $exception) {
            Storage::disk ('local')->append ('ExamAddedListenererror.txt', $exception);


        }
    }

}
