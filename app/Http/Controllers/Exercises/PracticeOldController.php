<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/19/2018
 * Time: 1:21 PM
 */

namespace App\Http\Controllers\Exercises;


use App\Http\Controllers\Controller;
use App\Models\Discipline;
use App\Models\Exerciseset;
use App\Models\Practiceresult;
use App\Models\Question;
use App\Models\Answeroption;
use App\Models\Exercisesetbuyer;
use App\Models\Skillmasterylevel;
use App\Models\Userinterest;
use App\Models\UserSkillmasterylevel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\ExerciseSetCreated;
use Carbon\Carbon;
use DB;

use App\Http\Traits\Setskillmasterylevels;
use App\Http\Traits\AddXppoint;

use Log;

class PracticeOldController extends Controller
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

    public function index ($exerciseid)
    {
        $nextquestionid = 0;
        $userinterest_id = 0;
        $exerciseset = Exerciseset::findorfail ($exerciseid);
        $question = Question::where ('exercise_id', '=', $exerciseid)->first ();

        if ($question) {
            $nextquestions = Question::where ('exercise_id', '=', $exerciseid)->where ('id', '>', $question->id)->first ();

            $this->clearsessiondata ($exerciseset);
            if ($nextquestions) {
                $nextquestionid = $nextquestions->id;
            } else {
                $nextquestionid = 0;

            }
         

            $this->add_xp_point (Auth::user ()->id, 'takepractice');
            return view ('practice.old.index', compact ('question', 'exerciseset', 'nextquestionid', 'userinterest_id'));
        } else {
            return view ('practice.old.index', compact ('question', 'exerciseset', 'nextquestionid', 'userinterest_id'));
        }
    }

//nextquestion
    public function nextquestion ($questionid)
    {

        $nextquestionid = 0;
        $userinterest_id = 0;
        $question = Question::where ('id', '=', $questionid)->first ();
        $exerciseset = Exerciseset::where ('id', '=', $question->exercise_id)->first ();

        $nextquestions = Question::where ('exercise_id', '=', $question->exercise_id)->where ('id', '>', $question->id)->first ();

        if ($nextquestions) {
            $nextquestionid = $nextquestions->id;
        } else {
            $nextquestionid = 0;

        }
        $countcorrectanswer = $_GET['correctanswer'];
        $countbadanswer = $_GET['badanswer'];

        return view ('practice.old.question', compact ('question', 'exerciseset', 'nextquestionid', 'countcorrectanswer', 'countbadanswer', 'userinterest_id'));
    }


    public function disciplinepractice ($userinterest_id)
    {
        $this->add_xp_point (Auth::user ()->id, 'takepractice');
        $nextquestionid = 0;

        $userinterest = Userinterest::where ('id', '=', $userinterest_id)->first ();
        $discpline_id = $userinterest->discipline_id;

        $exercise_type = $userinterest->exercise_type;

        if ($exercise_type == 1) {
            // free exercise set
            $exerciseset = Exerciseset::where ('discipline_id', '=', $discpline_id)->where ('grade_id', '=', $userinterest->grade_id)
                ->where ('language_id', '=', $userinterest->language_id)->where ('price', '=', 0)->get ()->all ();
        } else {
            // purchased exercise set
            $user = Auth::user ();
            $exerciseset = $user->exercises;
            $exerciseset = $exerciseset->where ('grade_id', '=', $userinterest->grade_id);
            $exerciseset = $exerciseset->where ('language_id', '=', $userinterest->language_id);

            // list of user exercises
        }

        $questions = new Collection();

        foreach ($exerciseset as $exercise) {
            $question = $exercise->question;
            $questions = $questions->merge ($question);

        }


        $questions = $questions->sortby ('id');
        $question = $questions->first ();
        if ($question) {

            $nextquestions = $questions->where ('id', '>', $question->id)->first ();
            $exerciseset = $exerciseset[0];
            $this->clearsessiondata ($exerciseset);
            if ($nextquestions) {
                $nextquestionid = $nextquestions->id;
            } else {
                $nextquestionid = 0;

            }


            return view ('practice.old.index', compact ('question', 'exerciseset', 'nextquestionid', 'userinterest_id'));
        } else {
            return view ('practice.old.index', compact ('question', 'exerciseset', 'nextquestionid', 'userinterest_id'));
        }
    }


    public function nextquestion_interset ($questionid, $userinterest_id)
    {
        $userinterest = Userinterest::where ('id', '=', $userinterest_id)->first ();
        $discpline_id = $userinterest->discipline_id;
        $nextquestionid = 0;
        $exercise_type = $userinterest->exercise_type;
        if ($exercise_type == 1) {
            // free exercise set
            $exerciseset = Exerciseset::where ('discipline_id', '=', $discpline_id)->where ('grade_id', '=', $userinterest->grade_id)
                ->where ('language_id', '=', $userinterest->language_id)->where ('price', '=', 0)->get ()->all ();
        } else {
            // purchased exercise set
            $user = Auth::user ();
            $exerciseset = $user->exercises;
            $exerciseset = $exerciseset->where ('grade_id', '=', $userinterest->grade_id);
            $exerciseset = $exerciseset->where ('language_id', '=', $userinterest->language_id);
            // list of user exercises
        }

        $questions = new Collection();

        foreach ($exerciseset as $exercise) {
            $question = $exercise->question;
            $questions = $questions->merge ($question);

        }


        $questions = $questions->sortby ('id');
        $question = $questions->where ('id', '=', $questionid)->first ();

        if ($question) {

            $nextquestions = $questions->where ('id', '>', $question->id)->first ();

            $exerciseset = $exerciseset[0];

            if ($nextquestions) {
                $nextquestionid = $nextquestions->id;
            } else {
                $nextquestionid = 0;

            }
        }

        if (session ()->has ('useranswer' . $question->id)) {
            session ()->forget ('useranswer' . $question->id);
        }


        if (session ()->has ('correctanswer' . $question->id)) {
            session ()->forget ('correctanswer' . $question->id);

        }


        if (session ()->has ('questionischecked' . $question->id)) {
            session ()->forget ('questionischecked' . $question->id);

        }


        $countcorrectanswer = $_GET['correctanswer'];
        $countbadanswer = $_GET['badanswer'];
        return view ('practice.old.question', compact ('question', 'exerciseset', 'nextquestionid', 'countcorrectanswer', 'countbadanswer', 'userinterest_id'));
    }

    public function clickedanswer ($answerid)
    {

        $answer = Answeroption::findorfail ($answerid);
        $question = Question::findorfail ($answer->question_id);
        $excelques = $question->renderQuestion ($question->id);

        session ()->forget ('useranswer' . $question->id);
        session (['useranswer' . $answer->question_id => $answerid]);
        session (['qisanswered' . $answer->question_id => $answer->question_id]);

        return view ('practice.old.oneanswer', compact ('answer', 'question', 'excelques'));

    }


    public function correctanswer ($questionid)
    {
        $question = Question::findorfail ($questionid);
        $theuseranswer_id = session ('useranswer' . $questionid);
        $theuseranswer = Answeroption::where ('id', '=', $theuseranswer_id)->first ();
        $answer = Answeroption::where ('iscorrect', '=', 1)->where ('question_id', '=', $questionid)->first ();
        if ($theuseranswer_id == $answer->id) {


            if (session ()->has ('countofcorrectanswers')) {
                $countofcorrectanswers = Session ('countofcorrectanswers') + 1;
            } else {
                $countofcorrectanswers = 1;
            }

            Session (['countofcorrectanswers' => $countofcorrectanswers]);

        } else {

            if (session ()->has ('countofbadanswers')) {
                $countofbadanswers = Session ('countofbadanswers') + 1;
            } else {
                $countofbadanswers = 1;
            }
            Session (['countofbadanswers' => $countofbadanswers]);
        }
        if ($answer) {
            session (['correctanswer' . $questionid => $answer->id]);
            session (['questionischecked' . $answer->question_id => $answer->question_id]);


            $praticeresult = Practiceresult::where ('user_id', '=', Auth::user ()->id)->where ('question_id', '=', $questionid)->whereDate ('created_at', '=', Carbon::today ()->toDateString ())->first ();
            if (!$praticeresult) $praticeresult = new Practiceresult;
            $praticeresult->question_id = $questionid;
            $praticeresult->user_id = Auth::user ()->id;
            $praticeresult->answer_id = $theuseranswer->id;
            $praticeresult->iscorrect = $theuseranswer->iscorrect;
            $praticeresult->save ();
            $val = $this->setskillmasterylevels_for_practice (Auth::user ()->id, $questionid);
            return $answer->id;
        }


        return 0;

    }

    public function result ($exerciseid, $userinterest_id = null)
    {


        echo $userinterest_id;
        $exerciseset = Exerciseset::findorfail ($exerciseid);


        $countofcorrectanswer = Session ('countofcorrectanswers');
        $countofbadanswer = Session ('countofbadanswers');
        if ($countofcorrectanswer == null) $countofcorrectanswer = 0;
        if ($countofbadanswer == null) $countofbadanswer = 0;

        
        if ($userinterest_id == null || $userinterest_id == 0) ;
        else {
            $userinterest = Userinterest::where ('id', '=', $userinterest_id)->get ();
            if ($userinterest) {
                $userinterest = Userinterest::where ('id', '=', $userinterest_id)->first ();
                $discpline_id = $userinterest->discipline_id;

                $exercise_type = $userinterest->exercise_type;

                if ($exercise_type == 1) {
                    // free exercise set

                } else {
                    // purchased exercise set
                    $user = Auth::user ();
                    $exerciseset = $user->exercises ();
                    $exerciseset = $exerciseset->where ('grade_id', '=', $userinterest->grade_id);
                    $exerciseset = $exerciseset->where ('language_id', '=', $userinterest->language_id);

                    // list of user exercises
                }

                $listofskills = Exerciseset::join ('questions', 'exercisesets.id', '=', 'exercise_id')->where ('grade_id', '=', $userinterest->grade_id)
                    ->where ('language_id', '=', $userinterest->language_id)->where ('price', '=', 0)->whereNotNull ('skill_id')
                    ->where ('discipline_id', '=', $userinterest->discipline_id)->select ('skill_id')->groupBy ('skill_id')->get ();

                if ($listofskills->count () <> 0) {


                    $sub = UserSkillmasterylevel::select ('user_id', 'skill_id', DB::raw ('max( created_at )  as max_date'))->groupBy ('user_id')
                        ->groupBy ('skill_id');
                    Storage::disk ('local')->append ('testtitititiit', $sub->toSql ());
                    $mastrylevel = UserSkillmasterylevel::join (DB::raw ("( {$sub->toSql() }  )  max_table "), function ($join) {
                        $join->on ('max_table.max_date', '=', 'userskillmasterylevels.created_at')
                            ->on ('max_table.user_id', '=', 'userskillmasterylevels.user_id')
                            ->on ('max_table.skill_id', '=', 'userskillmasterylevels.skill_id');

                    })->wherein ('userskillmasterylevels.skill_id', $listofskills)->where ('userskillmasterylevels.user_id', '=', Auth::user ()->id)->get ();
                }



            }

        }


        return view ('practice.practiceresult', compact ('exerciseset', 'countofcorrectanswer', 'countofbadanswer', 'mastrylevel'));


    }

    private function clearsessiondata ($exercise)
    {

        session ()->forget ('countofcorrectanswer' . $exercise->id);
        session ()->forget ('countofbadanswer' . $exercise->id);

        session ()->forget ('countofcorrectanswers');
        session ()->forget ('countofbadanswers');

        $questions = $exercise->question ()->get ();
        foreach ($questions as $question) {
            session ()->forget ('useranswer' . $question->id);
            session ()->forget ('qisanswered' . $question->id);
            session ()->forget ('questionischecked' . $question->id);
            session ()->forget ('correctanswer' . $question->id);


        }
        return;
    }

    public function buyexercise ($id)
    {

        try {

            $exerciseset = Exerciseset::with ('discipline', 'grade', 'language')->findOrFail ($id);

            return view ('exercisesets.buyexercise', compact ('exerciseset'));

        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function buy ($id)
    {

        try {

            $exercisesetbuyers = Exercisesetbuyer::where ('user_id', '=', Auth::user ()->id)->where ('exerciseset_id', '=', $id)->first ();
            if (!$exercisesetbuyers) {
                $exercisesetbuyers = New Exercisesetbuyer;
                $exercisesetbuyers->user_id = Auth::user ()->id;
                $exercisesetbuyers->exerciseset_id = $id;
                $exercisesetbuyers->save ();
                $exerciseset = Exerciseset::where ('id', '=', $id)->first ();
                event (new ExerciseSetCreated($exerciseset));
            }
            Storage::disk ('local')->append ('addddddd.txt', 'done');
            return "done";

        } catch (Exception $exception) {
            Storage::disk ('local')->append ('addddddd.txt', $exception);
            return $exception;
        }
    }


}