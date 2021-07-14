<?php

namespace App\Policies;

use App\Models\Classexam;
use App\Models\User;
use App\Models\Exam;
use App\Models\Classlearner;
use App\Models\Userexamscore;
use Carbon;

use App\Models\GoogleClassroom;
use App\Models\GoogleclassExercises;
use App\Models\GoogleclassLearners;
use App\Models\GoogleclassExams;

use Illuminate\Auth\Access\HandlesAuthorization;


use Log;
use Illuminate\Support\Facades\Storage;


class ExamPolicy
{
    // Policies for Exam   , edit , remove Exam , take exam
    use HandlesAuthorization;


    public function editexam (User $user, Exam $exam)
    {
        //
        try {
            $now = Carbon\Carbon::now ();
            $classexams = Classexam::where ('exam_id', '=', $exam->id)->whereDate ('exam_start_date', '<=', $now)->first ();
            if ($classexams) return false;
            return true;
        } catch (Exception $exception) {
            Storage::disk ('local')->append ('ExamPolicyError1.txt', $exception);
        }
    }

    public function removeexamfromclass (User $user, Exam $exam)
    {
        try {
            $now = Carbon\Carbon::now ();
            Storage::disk ('local')->append ('ExamPolicy.txt', 'now=' . $now);
            Storage::disk ('local')->append ('ExamPolicy.txt', 'test date=' . $exam->pivot->exam_start_date);
            $classexam = Classexam::where ('id', '=', $exam->pivot->id)->where ('exam_start_date', '>', $now)->first ();
            if ($classexam) return true;
            return false;

        } catch (Exception $exception) {
            Storage::disk ('local')->append ('ExamPolicyError.txt', $exception);
        }

    }

    public function takeexam (User $user, Classexam $classexam)
    {
        try {
            $now = Carbon\Carbon::now (3);

            $classlearner = Classlearner::where ('class_id', '=', $classexam->class_id)->where ('user_id', '=', $user->id)->first ();
            if (!$classlearner) {

                return false;
            }
            if ($classexam->exam_start_date <= $now  && $classexam->exam_end_date >=$now ) {
                $userexamscore = Userexamscore::where ('user_id', '=', $user->id)->where ('classexam_id', '=', $classexam->id)->first ();
                if ($userexamscore) return false;

                return true;
            }

            return false;

        } catch (Exception $exception) {
            Storage::disk ('local')->append ('ExamPolicyError.txt', $exception);
        }

    }

    public function tackExamGoogle (User $user, GoogleclassExams $gclassexam)
    {

        try {
            $now = Carbon\Carbon::now (3);

            $classlearner = GoogleclassLearners::where ('class_id', '=', $gclassexam->class_id)->where ('user_id', '=', $user->id)->first ();

            if (!$classlearner) {

                return false;
            }
            if ($gclassexam->exam_start_date <= $now  && $gclassexam->exam_end_date >=$now ) {
                $userexamscore = Userexamscore::where ('user_id', '=', $user->id)->where ('classexam_id', '=', $gclassexam->id)->first ();
                if ($userexamscore) return false;

                return true;
            }

            return true;

        } catch (Exception $exception) {
            Storage::disk ('local')->append ('ExamPolicyError.txt', $exception);
        }

    }


    public function getresultGoogle (User $user, GoogleclassExams $gclassexam)
    {

      try {
        Storage::disk ('local')->append ('ExamPolicy123.txt', json_encode($gclassexam));
            $now = Carbon\Carbon::now (3);
            $classlearner = GoogleclassLearners::where ('class_id', '=', $gclassexam->class_id)->where ('user_id', '=', $user->id)->first ();
            if (!$classlearner) {
                return false;
            }
             if ($gclassexam->exam_start_date > $now ) return false;
            if ($gclassexam->exam_end_date <=$now ) return true;

            if ($gclassexam->exam_start_date <= $now  && $gclassexam->exam_end_date >=$now ) {
                $userexamscore = Userexamscore::where ('user_id', '=', $user->id)->where ('classexam_id', '=', $gclassexam->id)->first ();
                if ($userexamscore) return true;

            }
            return false;
      } catch (Exception $exception) {
          Storage::disk ('local')->append ('ExamPolicyError.txt', $exception);
      }

    }

    public function getresult (User $user, Classexam $classexam)
    {
        try {
            Storage::disk ('local')->append ('ExamPolicy123.txt', json_encode($classexam));
                $now = Carbon\Carbon::now (3);
                $classlearner = Classlearner::where ('class_id', '=', $classexam->class_id)->where ('user_id', '=', $user->id)->first ();
                if (!$classlearner) {
                    return false;
                }
                 if ($classexam->exam_start_date > $now ) return false;
                if ($classexam->exam_end_date <=$now ) return true;

                if ($classexam->exam_start_date <= $now  && $classexam->exam_end_date >=$now ) {
                    $userexamscore = Userexamscore::where ('user_id', '=', $user->id)->where ('classexam_id', '=', $classexam->id)->first ();
                    if ($userexamscore) return true;

                }
                return false;





        } catch (Exception $exception) {
            Storage::disk ('local')->append ('ExamPolicyError.txt', $exception);
        }
    }



}
