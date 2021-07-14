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
use App\Models\Question;
use App\Models\Answeroption;
use App\Models\Exercisesetbuyer;
use App\Models\Userinterest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\ExerciseSetCreated;
use Log;
use App\Models\Skill;
use App\Models\Skillcategory;
use App\Models\Topic;
use Illuminate\Support\Facades\Session;

class GuestPracticeController extends Controller
{


//nextquestion
    public function nextquestion ($questionid, $questionindex)
    {
        $questions = session ('listofquestions');
        $countofquestions = $questions->count ();
        $nextquestionindex = $questionindex + 1;
        $question = Question::where ('id', '=', $questionid)->first ();
        $exerciseset = Exerciseset::where ('id', '=', $question->exercise_id)->first ();
        if ($nextquestionindex < $countofquestions) {
            $questionindex = $nextquestionindex;
            $nextquestions = $questions[$questionindex];
            $nextquestionid = $nextquestions->id;
        } else {
            $nextquestionid = 0;
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

        return view ('guestpractice.question', compact ('question', 'exerciseset', 'nextquestionid', 'countcorrectanswer', 'countbadanswer', 'questionindex'));
    }


    /**
     * 
     * Development by Webclues
     * 
     */
    public function guestpractice()
    {
        
        if(!empty(request('exercisets_ids'))){
            $exerciseid = request('exercisets_ids');
        }else{
            //Take from session
            $exerciseid = Session::get('pratice_session_data.exercisets_ids');
        }
        if(!empty(request('skill_with_skill_category'))){
            $skill_with_skill_category = request('skill_with_skill_category');
        }else{
            //Take from session
            $skill_with_skill_category = Session::get('pratice_session_data.skill_with_skill_category');
        }
        // $exercisets_ids = explode(",", request('exercisets_ids'));
        // $skill_with_skill_category = explode(",", request('skill_with_skill_category'));
        //Save in sessions 
        Session::put('pratice_session_data',[
            'exercisets_ids'=>$exerciseid,
            'skill_with_skill_category'=>$skill_with_skill_category
        ]);
        if(empty($exerciseid) || empty($skill_with_skill_category))
        {
            
        }
        $exercisets_ids = explode(",", $exerciseid);
        $skill_with_skill_category = explode(",", $skill_with_skill_category);

        $exerciseset = Exerciseset::whereIn('id',$exercisets_ids)->get()->all();
        $skill = Skill::where('id','=',$skill_with_skill_category[1])->first();

        $nextquestionid = 0;

        $questions = new Collection();
        $skill_questions = [];
        foreach ($exerciseset as $exercise) {
            foreach($exercise->question as $question){

                if($question->skillcategory_id == $skill_with_skill_category[0]){
                    if($question->skill_id == $skill_with_skill_category[1]){
                        array_push($skill_questions, $question);
                    }
                }

            }   
            $questions = $questions->merge($skill_questions);
        }

        $questions = $questions->shuffle ();
        $questions = $questions->take (6);
        
        // if (session ()->has ('listofquestions')) {
        //     session ()->forget ('listofquestions');
            
        // }
        // session (['listofquestions' => $questions]);
        
        // $question = null;
        // if ($exerciseset) {
            
        //     $exerciseset = $exerciseset[0];
        //     $this->clearsessiondata ($exerciseset);

        //     $question = $questions->first();
           
            
        //     if ($questions->count () > 1) {
        //         if (session ()->has ('useranswer' . $question->id)) {
        //             session ()->forget ('useranswer' . $question->id);
        //         }
    
    
        //         if (session ()->has ('correctanswer' . $question->id)) {
        //             session ()->forget ('correctanswer' . $question->id);
    
        //         }
    
    
        //         if (session ()->has ('questionischecked' . $question->id)) {
        //             session ()->forget ('questionischecked' . $question->id);
    
        //         }

        //         $nextquestions = $questions[1];
        //         $nextquestionid = $nextquestions->id;
        //     } else {

        //         $nextquestionid = 0;
        //     }
        //     $questionindex = 1;
        // }


        $nextquestionid = 0;

        if (count($questions) > 0) {
          // Create final JSON Object
          $jsonArr = array();
          foreach ($questions as $question) {
            $jsonArr[] = json_decode($question->paramRenderQuestion(),TRUE);
          }
  
          
          // Shuffle Answers
          foreach ($jsonArr as $key =>  $val) {
            $shuffleAns = $val['Questions'][0]['Answers']['Choices'];
            shuffle($shuffleAns);
            $jsonArr[$key]['Questions'][0]['Answers']['Choices'] = $shuffleAns;

            foreach($val['Questions'][0]['Hints']['HintList'] as $hkey => $hintlist){
                $jsonArr[$key]['Questions'][0]['Hints']['HintList'][$hkey]['index'] = ($hkey+1);
            }
          }
          
          // Store JSON Array in session
          Session (['jsonQuesions' => $jsonArr]);
          
          // JSON Encode array
          $jsonDetail = json_encode($jsonArr);
        } else {
          Session (['jsonQuesions' => array()]);
          $jsonDetail = array();
        }
        
        // Get questions count;
        $questionCount = count($questions);

        $discpline_url = route('topics.topic.index');
        $skill = Skill::where('id','=',$skill_with_skill_category[1])->first(); 
        $skill_categories = Skillcategory::where('id','=',$skill_with_skill_category[0])->first(); 
        $practice_type = 'disciplines';
        $exerciseset_url = '';

        // For signup
        $topics = Topic::where('approve_status', '=', 'approved')->paginate(25);

        return view('practice.index',compact('jsonDetail','nextquestionid','questionCount','exerciseid','skill','skill_categories','discpline_url','practice_type','exerciseset_url','topics'));

        // return view ('guestpractice.index', compact ('question', 'exerciseset', 'nextquestionid', 'questionindex','skill'));

    }



    public function guestpracticeOld ()
    {


        if (session ()->has ('discipline_id')) {
            $discpline_id = session ('discipline_id');
            $exerciseset = Exerciseset::where ('discipline_id', '=', $discpline_id);
        } else {
            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'You did not select any discipline !']);
        }


        if (session ()->has ('language_id')) {
            $language_id = session ('language_id');
            $exerciseset = $exerciseset->where ('language_id', '=', $language_id);


        }

        if (session ()->has ('grade_id')) {
            $grade_id = session ('grade_id');
            $exerciseset = $exerciseset->where ('grade_id', '=', $grade_id);

        }

        if (session ()->has ('exercise_type')) {
            $exercise_type = session ('exercise_type');
        } else {
            $exercise_type = 0;
        }


        $nextquestionid = 0;


        if ($exercise_type == 1) {
            $exerciseset = $exerciseset->where ('price', '=', 0);
        }


        $exerciseset = $exerciseset->get ()->all ();


        $questions = new Collection();
        foreach ($exerciseset as $exercise) {
            $question = $exercise->question;
            $questions = $questions->merge ($question);

        }
        $questions = $questions->shuffle ();
        $questions = $questions->take (6);

        if (session ()->has ('listofquestions')) {
            session ()->forget ('listofquestions');

        }
        session (['listofquestions' => $questions]);

        $question = null;
        if ($exerciseset) {

            $exerciseset = $exerciseset[0];
            $this->clearsessiondata ($exerciseset);
            $question = $questions->first ();
            if (session ()->has ('useranswer' . $question->id)) {
                session ()->forget ('useranswer' . $question->id);
            }


            if (session ()->has ('correctanswer' . $question->id)) {
                session ()->forget ('correctanswer' . $question->id);

            }


            if (session ()->has ('questionischecked' . $question->id)) {
                session ()->forget ('questionischecked' . $question->id);

            }
            if ($questions->count () > 1) {
                $nextquestions = $questions[1];
                $nextquestionid = $nextquestions->id;
            } else {

                $nextquestionid = 0;
            }
            $questionindex = 1;
        }
        return view ('guestpractice.index', compact ('question', 'exerciseset', 'nextquestionid', 'questionindex'));

    }


    public function clickedanswer ($answerid)
    {

        $answer = Answeroption::findorfail ($answerid);
        $question = Question::findorfail ($answer->question_id);
        $excelques = $question->renderQuestion ($question->id);

        session ()->forget ('useranswer' . $question->id);
        session (['useranswer' . $answer->question_id => $answerid]);
        session (['qisanswered' . $answer->question_id => $answer->question_id]);
        return view ('guestpractice.oneanswer', compact ('answer', 'question', 'excelques'));

    }


    public function correctanswer ($questionid)
    {
        $question = Question::findorfail ($questionid);
        $theuseranswer = session ('useranswer' . $questionid);


        $answer = Answeroption::where ('iscorrect', '=', 1)->where ('question_id', '=', $questionid)->first ();
        if ($theuseranswer == $answer->id) {


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
            return $answer->id;
        }

        return 0;

    }

    public function result ($exerciseid)
    {

        $exerciseset = Exerciseset::findorfail ($exerciseid);
        $countofcorrectanswer = Session ('countofcorrectanswers');
        $countofbadanswer = Session ('countofbadanswers');
        if ($countofcorrectanswer == null) $countofcorrectanswer = 0;
        if ($countofbadanswer == null) $countofbadanswer = 0;


        return view ('guestpractice.practiceresult', compact ('exerciseset', 'countofcorrectanswer', 'countofbadanswer'));


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


}