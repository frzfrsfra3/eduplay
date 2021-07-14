<?php

namespace App\Http\Traits;


use App\Models\Classexam;
use App\Models\Exam;
use App\Models\Examquestion;
use App\Models\Practiceresult;
use App\Models\Question;
use App\Models\Skillmasterylevel;
use App\Models\Userexamanswer;
use App\Models\UserSkillmasterylevel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Badge;
use App\Models\Userbadge;
use App\Models\Discipline;
use App\Models\Skillcategory;
use App\Models\Skill;

trait Setskillmasterylevels
{
    //setskillmasterylevels_for_exam, setskillmasterylevels_for_practice,

    /**
     *
     */
    public function setskillmasterylevels_for_exam ($user_id, $classexam_id, $question_id)
    {
        // $min_skill_count is the min skill allowed to take mastery on it on same exam
        $min_skill_count = 3;
        $classexam = Classexam::where ('id', '=', $classexam_id)->first ();
        if ($classexam) {
            $exam = Exam::where ('id', '=', $classexam->exam_id)->first ();
            $question = Question::where ('id', '=', $question_id)->first ();
            $skill_id = $question->skill_id;
            if (strlen ($skill_id) <> 0) {

                $questions = $exam->examquestions ()->get ();
                $questions = $questions->where ('skill_id', '=', $skill_id);
                //$count_skills count of skill in this exam
                $count_skills = ($questions->count ());
                if ($count_skills >= $min_skill_count) {
                    // if the count of skill in this exam is less of $min_skill_count , no mastery level applied
                    $question_correct = $exam->questionanswers ()->wherePivot ('iscorrect', '=', 1)->wherePivot ('classexam_id', '=', $classexam_id)->distinct('id')->get ();
                    $question_correct = $question_correct->where ('skill_id', '=', $skill_id);
                    $count_correct = ($question_correct->count ());
                    $percent = $count_correct / $count_skills * 100;
                    $percent = intval ($percent);

                    $level_id = $this->get_level_id ($percent, 1);

                    $usermasterylevel = $this->savemasterylevel ($user_id, $level_id, $skill_id, $percent, $classexam_id,$question->id);
                    return 1;


                } else // if the count of skill in this exam is less of $min_skill_count , no mastery level applied
                    return -1;

            } else
                return -1;

        } else return -1;


    }

    /**
     *
     */
    public function setskillmasterylevels_for_practice ($user_id, $question_id)
    {
        $classexam_id =null;
        // mastery level in practice is calculated based on consecutive correct answers
        $count_sequence = 0;
        $stop_counting = 1;
        $question = Question::where ('id', '=', $question_id)->first ();
        if ($question) {
            // fetch the answer from Practice result of today's practice ordered by id for the current skill
            $praticeresults = Practiceresult::with ('question')->join ('questions', 'questions.id', '=', 'question_id')
            ->whereDate ('practiceresults.created_at', '=', Carbon::today ()->toDateString ())
            ->where ('questions.skill_id', '=', $question->skill_id)
            ->orderBy ('practiceresults.id', 'DESC')->select ('practiceresults.id', 'practiceresults.iscorrect', 'skill_id')->get ();

            // calculating how many consecutive correct answers there are for this skill
            foreach ($praticeresults as $praticeresult) {
                if ($stop_counting == 1) {
                    if ($praticeresult->iscorrect) {
                        $count_sequence = $count_sequence + 1;
                    } else {
                        $stop_counting = 0;
                    }
                }
            }

        if ($count_sequence >= 0) {
            $level_id = $this->get_level_id ($count_sequence, 0);
                if ($level_id >= 0) {
                    $usermasterylevel = $this->savemasterylevel ($user_id, $level_id, $question->skill_id, $count_sequence,$classexam_id,$question->id);
                    return 1;
                }

                return -1;
                } else return -1;
            } else {
                return -1;
        }
    }

    /**
     *
     */
    public function setskillmasterylevels_for_game ($user_id, $question_id)
    {
        $count_sequence = 0;
        $stop_counting = 1;
        $question = Question::where ('id', '=', $question_id)->first ();
        if ($question) {
            $praticeresults = Userexamanswer::with ('question')->join ('questions', 'questions.id', '=', 'question_id')
                ->whereDate ('userexamanswers.answerdate', '=', Carbon::today ()->toDateString ())
                ->where ('questions.skill_id', '=', $question->skill_id)
                ->where('class_id','=','0')
                ->where('exam_id','=','0')
                ->orderBy ('userexamanswers.id', 'DESC')->select ('userexamanswers.id', 'userexamanswers.iscorrect', 'skill_id')->get ();

            foreach ($praticeresults as $praticeresult) {
                if ($stop_counting == 1) {
                    if ($praticeresult->iscorrect) {
                        $count_sequence = $count_sequence + 1;
                    } else {
                        $stop_counting = 0;
                    }
                }

            }
        }
          // dd($count_sequence);
    }
            

    /**
     *
     */
    private function get_level_id ($value, $isexam)
    {

        if ($isexam == 1) {
            $mastrylevel = Skillmasterylevel::where ('min_score', '<=', $value)->where ('max_score', '>=', $value)->first ();
            if ($mastrylevel) return $mastrylevel->id;

            return 0;
        }

        if ($isexam == 0) {
            $mastrylevel = Skillmasterylevel::where ('min_consecutive_value', '<=', $value)->where ('max_consecutive_value', '>=', $value)->first ();

            if ($mastrylevel) return $mastrylevel->id;

            return 0;
        }

        return -1;

    }

    private function savemasterylevel ($user_id, $level_id, $skill_id, $percent, $classexam_id = null,$question_id)
    {
        //dd($user_id, $level_id, $skill_id, $percent, $classexam_id ,$question_id);
        if (strlen ($skill_id) <> 0) {
            if ($classexam_id <> null) {
                $usermastrylevel = UserSkillmasterylevel::where ('user_id', '=', $user_id)->where ('skill_id', '=', $skill_id)->where ('classexam_id', '=', $classexam_id)
                    ->first ();
                if (!$usermastrylevel) $usermastrylevel = new UserSkillmasterylevel;
                $usermastrylevel->user_id = $user_id;
                $usermastrylevel->skill_id = $skill_id;
                $usermastrylevel->classexam_id = $classexam_id;
                $usermastrylevel->score = $percent;
                $usermastrylevel->masteryLevel = $level_id;
                $usermastrylevel->save ();

                // Question Data
                $question = Question::where ('id', '=', $question_id)
                ->with(['exercise' => function ($query) {
                    $query->select('discipline_id','grade_id','id');
                }])->first();

                if(!empty($question->exercise->discipline_id) && !empty($question->exercise->grade_id)){
                    // if($question->skill_id == $usermastrylevel->skill_id){
                        $this->setskillbadge($user_id,$question,$usermastrylevel->classexam_id);
                    // }
                }
                return $usermastrylevel;
            } else {
                if ($level_id <> 0) {
                    $usermastrylevel = UserSkillmasterylevel::where ('user_id', '=', $user_id)
                    ->where ('skill_id', '=', $skill_id)
                    ->where('classexam_id','=','')
                    ->whereDate ('created_at', '=', Carbon::today ()->toDateString ())
                    ->first ();

                    if (!$usermastrylevel) $usermastrylevel = new UserSkillmasterylevel;
                    $usermastrylevel->user_id = $user_id;
                    $usermastrylevel->skill_id = $skill_id;
                    $usermastrylevel->score = $percent;
                    $usermastrylevel->masteryLevel = $level_id;
                    $usermastrylevel->save ();

                    // Question Data
                    $question = Question::where ('id', '=', $question_id)
                    ->with(['exercise' => function ($query) {
                        $query->select('discipline_id','grade_id','id');
                    }])->first();

                    if(!empty($question->exercise->discipline_id) && !empty($question->exercise->grade_id)){
                        // if($question->skill_id == $usermastrylevel->skill_id){
                            $this->setskillbadge($user_id,$question);
                        // }
                    }
                    return $usermastrylevel;
                }
            }
        }
    }



    /**
     * Undocumented function
     *
     * param [type] $user_id
     * param [type] $points
     * return void
     */
    private function setskillbadge($user_id,$question,$classexam_id = null)
    {
        // Check discipline & gread process
        $skills = Skill::whereHas('skillcategory',function($q) use ($question){
            $q->where('discipline_id','=',$question->exercise->discipline_id);
        })
        ->where('id',$question->skill_id)   // After debugging add this condition for single question skill
        ->where('grade_id','=',$question->exercise->grade_id)
        ->where('publish_status','=','published')
        ->where('approve_status','=','approved')
        ->first();

        $discipline_grade_master_id = null;
        // foreach($skills as $skill){
            $userSkill = $this->getUserSkillMasteryLevel($user_id, $skills->id,$classexam_id);
            if($userSkill != null){
                $discipline_grade_master_id=$userSkill['masteryLevel'];
                //dd($discipline_grade_master_id.'here');
            } else {
                $discipline_grade_master_id=1;
                //dd($discipline_grade_master_id.'here else');
            }
        // }

        $discipline_name = $question->exercise->discipline->discipline_name;
        $grade_name = $question->exercise->grade->grade_name;

        if(!empty($question->exercise->discipline_id) && !empty($question->exercise->grade_id)){
            // Get Badges data
            $badges = Badge::where('points', '=', 0)->where('id',$discipline_grade_master_id)->first();
            if (!empty($badges)) {
                // For user badges

                if($classexam_id == Null){
                    $userbadge = Userbadge::where('user_id','=', $user_id)
                    ->where('discipline_id', '=', $question->exercise->discipline_id)
                    ->where('grade_id', '=', $question->exercise->grade_id)
                    ->where('skill_type','=','practices')
                    ->first();
                } else {
                    $userbadge = Userbadge::where('user_id','=', $user_id)
                    ->where('discipline_id', '=', $question->exercise->discipline_id)
                    ->where('grade_id', '=', $question->exercise->grade_id)
                    ->where('skill_type','=','exam')
                    ->first();
                }

                if (!$userbadge) {
                    // Create
                    $userbadge = new Userbadge;
                    $userbadge->user_id = $user_id;
                    $userbadge->badge_id = $badges->id;
                    $userbadge->badgetitle = $badges->badgetitle;
                    $userbadge->badgedescription = 'For "Discipline" '.$discipline_name.' & "Grade" '.$grade_name;
                    $userbadge->type = 'skill';
                    if($classexam_id == null){
                        $userbadge->skill_type = 'practices';
                    } else{
                        $userbadge->skill_type = 'exam';
                    }
                    $userbadge->discipline_id = $question->exercise->discipline_id;
                    $userbadge->grade_id = $question->exercise->grade_id;
                    $userbadge->save();
                } else {
                    // Update
                    $userbadge = Userbadge::find($userbadge->id);
                    $userbadge->user_id = $user_id;
                    $userbadge->badge_id = $badges->id;
                    $userbadge->badgetitle = $badges->badgetitle;
                    $userbadge->badgedescription = 'For "Discipline" '.$discipline_name.' & "Grade" '.$grade_name;
                    $userbadge->type = 'skill';
                    if($classexam_id == null){
                        $userbadge->skill_type = 'practices';
                    } else{
                        $userbadge->skill_type = 'exam';
                    }
                    $userbadge->discipline_id = $question->exercise->discipline_id;
                    $userbadge->grade_id = $question->exercise->grade_id;
                    $userbadge->save();
                }
            }
        }
        return;
    }

    public function getUserSkillMasteryLevel($user_id, $skill_Id,$classexam_id){
        $userSkill=UserSkillmasterylevel::where ('user_id', '=', $user_id)
                    ->where ('skill_id', '=', $skill_Id);
                    if($classexam_id == null){
                        $userSkill->where('classexam_id','=',0);
                    } else {
                        $userSkill->where('classexam_id','=',$classexam_id);
                    }
                    $userSkill->latest()->select('masteryLevel');
                    return $userSkill->first();
    }
}