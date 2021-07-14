<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/19/2018
 * Time: 1:21 PM
 */

namespace App\React\Exams;


use App\Http\Controllers\Controller;
use App\Models\Classexam;
use App\Models\Classlearner;
use App\Models\Exam;
use App\Models\Examquestion;
use App\Models\Exerciseset;
use App\Models\Passage;
use App\Models\Question;
use App\Models\Answeroption;
use App\Models\Userexamanswer;
use App\Models\Userexamscore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Traits\Setskillmasterylevels;
use App\Http\Traits\AddXppoint;

use Log;

class TakeexamController extends Controller
{
    use Setskillmasterylevels;
    use AddXppoint;
    public function __construct ()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        //   $this->middleware('auth');

        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware ('auth');
    }

    public function index ($examid, $classid , $isexam ="0")
    {


        $classexam = Classexam::where ('class_id', '=', $classid)->where ('exam_id', '=', $examid)->first ();
        if ($classexam) {
            if (Auth::user ()->can ('takeexam', $classexam)) {

                $exam = Exam::findorfail ($examid);

                $questions = $exam->examquestions ()->orderBy ('examquestions.sort_order', 'asc')->paginate (1);
                $this->add_xp_point(Auth::user ()->id ,'takeexam');
                return view ('takeexam.index', compact ('questions', 'classexam', 'exam' ,'isexam'));
            } else {
                $userexamscore=Userexamscore::where('user_id' ,  '=' ,Auth::user ()->id ) ->where('classexam_id' ,'=' ,$classexam->id)->first();

                if ($userexamscore) {

                    $correctanswers= $this->totalcorrectanswers($classexam);
                    $badanswers =$this->totalbadtanswers($classexam);
                    $userexamscore=Userexamscore::where('user_id' ,'=',Auth::user ()->id)->where('classexam_id' , '=' ,$classexam->id)->first();
                    return view ('takeexam.result' , compact ('userexamscore','classexam' ,'correctanswers','badanswers' ,'isexam' ));

                }

                $classlearner=Classlearner::where('user_id','=',Auth::user ()->id)->where('class_id' ,'=' ,$classid)->where('status' , '=' ,'Accepted')->first();

                if ($classlearner) {
                    $this->finishexam($classexam->id);
                    $correctanswers= $this->totalcorrectanswers($classexam);
                    $badanswers =$this->totalbadtanswers($classexam);
                    $userexamscore=Userexamscore::where('user_id' ,'=',Auth::user ()->id)->where('classexam_id' , '=' ,$classexam->id)->first();
                    return view ('takeexam.result' , compact ('userexamscore','classexam' ,'correctanswers','badanswers' ,'isexam' ));
                }


                return view ('takeexam.unauthorized' , compact ('classexam'));
            }
        } else  return view ('takeexam.unauthorized' ,compact ('classexam'));
    }


    public function listofquestion ($classexamid)
    {

        $classexam = Classexam::where ('id', '=', $classexamid)->first ();
        if ($classexam) {
            if (Auth::user ()->can ('takeexam', $classexam)) {
                $exam = Exam::where ('id', '=', $classexam->exam_id)->first ();
                $questions = $exam->examquestions ()->orderBy ('examquestions.sort_order', 'asc')->paginate (1);
                return view ('takeexam.question', compact ('questions', 'classexam'));
            } else {
                return "can't take exam";
                return view ('takeexam.unauthorized');
            }
        } else {

            return "class exam not exist";
            return "takeexam.unauthorized";}

    }

    public function clickedanswer ($answerid, $classexamid, Request $request)
    {

        $timespent = 0;
        if ($request->has ('timespent')) {
            $timespent = $request['timespent'];
        }


        Storage::disk ('local')->append ("examanswer.txt", $classexamid);

        $answer = Answeroption::findorfail ($answerid);
        $question = Question::findorfail ($answer->question_id);
        $classexam = Classexam::where ('id', '=', $classexamid)->first ();
        $user_id = Auth::user ()->id;
        $examquestion = Examquestion::where ('exam_id', '=', $classexam->exam_id)->where ('question_id', '=', $question->id)->first ();
        $userexamanswer = Userexamanswer::where ('user_id', '=', $user_id)->where ('exam_id', '=', $classexam->exam_id)
            ->where ('class_id', '=', $classexam->class_id)->where ('classexam_id', '=', $classexam->id)->where ('question_id', '=', $question->id)->first ();
        if (!$userexamanswer) $userexamanswer = New Userexamanswer();
        $userexamanswer->user_id = $user_id;
        $userexamanswer->exam_id = $classexam->exam_id;
        $userexamanswer->class_id = $classexam->class_id;
        $userexamanswer->classexam_id = $classexam->id;
        $userexamanswer->question_id = $question->id;
        $userexamanswer->answer_id = $answerid;
        if (empty($answer->iscorrect)) { $iscorrect='0';  }
        else
        { $iscorrect='1';}
        $userexamanswer->iscorrect = $iscorrect;
        $userexamanswer->teachermark = $examquestion->points;
        $userexamanswer->attempt_number = $userexamanswer->attempt_number + 1;
        $userexamanswer->timespent = $userexamanswer->timespent + $timespent;
        $userexamanswer->user_agent = $request->server ('HTTP_USER_AGENT');
        $userexamanswer->save ();
        $val=$this->setskillmasterylevels_for_exam ( $user_id ,$classexamid , $question->id);
        return "Done";

    }
    public function finishexam($classexamid , $isexam="0"){
        $user_id=Auth::user ()->id;
        $classexam=Classexam::where('id','=',$classexamid)->first();
        $userexamanswers = Userexamanswer::selectRaw('sum(timespent) as sumoftimespent  , sum( teachermark *  iscorrect) as score ' )
            ->where ('user_id', '=', $user_id)->where ('classexam_id', '=', $classexamid)->first();
        $userexamscore=Userexamscore::where('user_id' ,'=',$user_id)->where('classexam_id' , '=' ,$classexamid)->first();
        if (!$userexamscore) $userexamscore = New Userexamscore();
        $userexamscore->user_id=$user_id;
        $userexamscore->classexam_id=$classexamid;
        if (!$userexamanswers->sumoftimespent ) {$timespent=0;}
        else
        {$timespent=$userexamanswers->score;}

        $userexamscore->totaltimespent=$timespent;
        if (!$userexamanswers->score ) {$score=0;}
        else
        {$score=$userexamanswers->score;}
        $userexamscore->score=$score;
        $userexamscore->save();
       $correctanswers= $this->totalcorrectanswers($classexam);
       $badanswers =$this->totalbadtanswers($classexam);
        return view ('takeexam.result' , compact ('userexamscore', 'classexam' ,'correctanswers','badanswers' ,'isexam'));

    }

public function getpassage ($passageid){

        $passage=Passage::where('id' ,'=' , $passageid )->first();

        return view ('takeexam.passage' ,compact ('passage'));


}




    private function totalcorrectanswers  ($classexam)
    {

        $userexamanswers = Userexamanswer::selectRaw('count(id) as countcorrect  ' )
            ->where ('user_id', '=', Auth::user ()->id)->where ('classexam_id', '=', $classexam->id)->where ('iscorrect', '=', 1)->first();
        return $userexamanswers->countcorrect;

    }

    private function totalbadtanswers  ($classexam)
    {
        $userexamanswers = Userexamanswer::selectRaw('count(id) as countcorrect  ' )
            ->where ('user_id', '=', Auth::user ()->id)->where ('classexam_id', '=', $classexam->id)->where ('iscorrect', '=', 0)->first();
        return $userexamanswers->countcorrect;

    }





}