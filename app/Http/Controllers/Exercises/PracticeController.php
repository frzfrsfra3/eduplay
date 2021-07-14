<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/19/2018
 * Time: 1:21 PM
 */

namespace App\Http\Controllers\Exercises;

use App\Events\ExerciseSetCreated;
use App\Http\Controllers\Controller;
use App\Http\Traits\AddXppoint;
use App\Http\Traits\Setskillmasterylevels;
use App\Mail\ReportProblem;
use App\Models\Answeroption;
use App\Models\Discipline;
use App\Models\Exerciseset;
use App\Models\Exercisesetbuyer;
use App\Models\Practiceresult;
use App\Models\Question;
use App\Models\Skill;
use App\Models\Skillcategory;
use App\Models\Userinterest;
use App\Models\UserSkillmasterylevel;
use Carbon\Carbon;
use DB;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use JonnyW\PhantomJs\Http\Request;
use Lang;
use Mockery\Exception;
use Illuminate\Support\Facades\Cache;

class PracticeController extends Controller
{
    use Setskillmasterylevels;
    use AddXppoint;

    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        //   $this->middleware('auth');

        //if trying to access this controller without being authenticated, it will ask him for authentication
        // $this->middleware ('auth');
    }

    /**
     * Show questions page
     * @param int $exerciseid
     * @return View
     */
    public function index($exerciseid)
    {
        if ( !Auth::check() )
            if (!(isset($_GET['share_id']) && Cache::get($_GET['share_id']) == true)) 
                return view('unauthorized');        

                
        $nextquestionid = 0;
        $exerciseset = Exerciseset::findorfail($exerciseid);
        $questions = Question::with('answeroptions')->where('exercise_id', '=', $exerciseid)->get();

        if (count($questions) > 0) {
            // Create final JSON Object
            $jsonArr = array();
            foreach ($questions as $question) {
                $jsonArr[] = json_decode($question->paramRenderQuestion(), true);
            }

            // Shuffle Answers
            foreach ($jsonArr as $key => $val) {
                $shuffleAns = $val['Questions'][0]['Answers']['Choices'];
                shuffle($shuffleAns);
                $jsonArr[$key]['Questions'][0]['Answers']['Choices'] = $shuffleAns;

                foreach ($val['Questions'][0]['Hints']['HintList'] as $hkey => $hintlist) {
                    $jsonArr[$key]['Questions'][0]['Hints']['HintList'][$hkey]['index'] = ($hkey + 1);
                }
            }

            // Store JSON Array in session
            Session(['jsonQuesions' => $jsonArr]);

            // JSON Encode array
            $jsonDetail = json_encode($jsonArr);
        } else {
            Session(['jsonQuesions' => array()]);
            $jsonDetail = array();
        }

        // Get questions count;
        $questionCount = count($questions);
        $discpline_url = route('explore.exerciseset');
        $exerciseset_url = route('exercisesets.exerciseset.summary', [$exerciseset->id, 1]);
        $practice_type = 'exerciseset';
        return view('practice.index', compact('jsonDetail', 'nextquestionid', 'questionCount', 'exerciseid', 'discpline_url', 'exerciseset', 'exerciseset_url', 'practice_type'))->with(['HideNavBars' => true]);

    }

    /**
     * Show disciplinepractice
     * @param int $userinterest_id
     * @return View
     */
    public function disciplinepractice($userinterest_id)
    {
        $this->add_xp_point(Auth::user()->id, 'takepractice');
        $nextquestionid = 0;
        $userinterest = Userinterest::where('id', '=', $userinterest_id)->first();
        $discpline_id = $userinterest->discipline_id;
        $exercise_type = $userinterest->exercise_type;
        if ($exercise_type == 1) {
            // free exercise set
            $exerciseset = Exerciseset::where('discipline_id', '=', $discpline_id)->where('grade_id', '=', $userinterest->grade_id)
                ->where('language_id', '=', $userinterest->language_id)->where('price', '=', 0)->get()->all();
        } else {
            // purchased exercise set
            $user = Auth::user();
            $exerciseset = $user->exercises;
            $exerciseset = $exerciseset->where('grade_id', '=', $userinterest->grade_id);
            $exerciseset = $exerciseset->where('language_id', '=', $userinterest->language_id);
            // list of user exercises
        }
        $questions = new Collection();
        foreach ($exerciseset as $exercise) {
            $question = $exercise->question;
            $questions = $questions->merge($question);
        }
        $questions = $questions->sortby('id');
        $question = $questions->first();
        $exerciseset_url = route('topics.topic.index');
        if ($question) {
            $nextquestions = $questions->where('id', '>', $question->id)->first();
            $exerciseset = $exerciseset[0];
            $this->clearsessiondata($exerciseset);
            if ($nextquestions) {
                $nextquestionid = $nextquestions->id;
            } else {
                $nextquestionid = 0;
            }
            return view('practice.index', compact('question', 'exerciseset', 'nextquestionid', 'userinterest_id', 'exerciseset_url'));
        } else {
            return view('practice.index', compact('question', 'exerciseset', 'nextquestionid', 'userinterest_id', 'exerciseset_url'));
        }
    }

    /**
     * Develop by WC.
     *
     * User practice.
     * @param Request
     * @return View
     */
    public function userPractice()
    {
        if (!empty(request('exercisets_ids'))) {
            $exerciseid = request('exercisets_ids');
        } else {
            //Take from session
            $exerciseid = Session::get('pratice_session_data.exercisets_ids');
        }
        if (!empty(request('skill_with_skill_category'))) {
            $skill_with_skill_category = request('skill_with_skill_category');
        } else {
            //Take from session
            $skill_with_skill_category = Session::get('pratice_session_data.skill_with_skill_category');
        }
        //Save in sessions
        Session::put('pratice_session_data', [
            'exercisets_ids' => $exerciseid,
            'skill_with_skill_category' => $skill_with_skill_category,
        ]);
        if (empty($exerciseid) || empty($skill_with_skill_category)) {

        }
        $exercisets_ids = explode(",", $exerciseid);
        $skill_with_skill_category_split = explode(",", $skill_with_skill_category);
        $exerciseset = Exerciseset::whereIn('id', $exercisets_ids)->get()->all();
        $skill = Skill::where('id', '=', $skill_with_skill_category_split[1])->first();
        $nextquestionid = 0;
        $questions = new Collection();
        $skill_questions = [];
        foreach ($exerciseset as $exercise) {
            foreach ($exercise->question as $question) {
                if ($question->skillcategory_id == $skill_with_skill_category_split[0]) {
                    if ($question->skill_id == $skill_with_skill_category_split[1]) {
                        array_push($skill_questions, $question);
                    }
                }
            }
            $questions = $questions->merge($skill_questions);
        }
        $questions = $questions->shuffle();
        $questions = $questions->take(6);
        $nextquestionid = 0;
        if (count($questions) > 0) {
            // Create final JSON Object
            $jsonArr = array();
            foreach ($questions as $question) {
                $jsonArr[] = json_decode($question->json_details, true);
            }
            // Shuffle Answers
            foreach ($jsonArr as $key => $val) {
                $shuffleAns = $val['Questions'][0]['Answers']['Choices'];
                shuffle($shuffleAns);
                $jsonArr[$key]['Questions'][0]['Answers']['Choices'] = $shuffleAns;
            }

            // Store JSON Array in session
            Session(['jsonQuesions' => $jsonArr]);

            // JSON Encode array
            $jsonDetail = json_encode($jsonArr);
        } else {
            Session(['jsonQuesions' => array()]);
            $jsonDetail = array();
        }

        // Get questions count;
        $questionCount = count($questions);
        $discpline_url = route('topics.topic.index');
        $skill = Skill::where('id', '=', $skill_with_skill_category_split[1])->first();
        $skill_categories = Skillcategory::where('id', '=', $skill_with_skill_category_split[0])->first();
        $practice_type = 'disciplines';
        $exerciseset_url = route('topics.topic.index');
        return view('practice.index', compact('jsonDetail', 'nextquestionid', 'questionCount', 'exerciseid', 'discpline_url', 'skill_url', 'practice_type', 'skill_categories', 'skill', 'exerciseset_url'));
    }

    public function nextquestion_interset($questionid, $userinterest_id)
    {
        $userinterest = Userinterest::where('id', '=', $userinterest_id)->first();
        $discpline_id = $userinterest->discipline_id;
        $nextquestionid = 0;
        $exercise_type = $userinterest->exercise_type;
        if ($exercise_type == 1) {
            // free exercise set
            $exerciseset = Exerciseset::where('discipline_id', '=', $discpline_id)->where('grade_id', '=', $userinterest->grade_id)
                ->where('language_id', '=', $userinterest->language_id)->where('price', '=', 0)->get()->all();
        } else {
            // purchased exercise set
            $user = Auth::user();
            $exerciseset = $user->exercises;
            $exerciseset = $exerciseset->where('grade_id', '=', $userinterest->grade_id);
            $exerciseset = $exerciseset->where('language_id', '=', $userinterest->language_id);
            // list of user exercises
        }

        $questions = new Collection();

        foreach ($exerciseset as $exercise) {
            $question = $exercise->question;
            $questions = $questions->merge($question);

        }

        $questions = $questions->sortby('id');
        $question = $questions->where('id', '=', $questionid)->first();

        if ($question) {

            $nextquestions = $questions->where('id', '>', $question->id)->first();

            $exerciseset = $exerciseset[0];

            if ($nextquestions) {
                $nextquestionid = $nextquestions->id;
            } else {
                $nextquestionid = 0;

            }
        }

        if (session()->has('useranswer' . $question->id)) {
            session()->forget('useranswer' . $question->id);
        }

        if (session()->has('correctanswer' . $question->id)) {
            session()->forget('correctanswer' . $question->id);

        }

        if (session()->has('questionischecked' . $question->id)) {
            session()->forget('questionischecked' . $question->id);

        }

        $countcorrectanswer = $_GET['correctanswer'];
        $countbadanswer = $_GET['badanswer'];
        return view('practice.question', compact('question', 'exerciseset', 'nextquestionid', 'countcorrectanswer', 'countbadanswer', 'userinterest_id'));
    }

    public function clickedanswer($answerid)
    {

        $answer = Answeroption::findorfail($answerid);
        $question = Question::findorfail($answer->question_id);
        $excelques = $question->renderQuestion($question->id);

        session()->forget('useranswer' . $question->id);
        session(['useranswer' . $answer->question_id => $answerid]);
        session(['qisanswered' . $answer->question_id => $answer->question_id]);

        return view('practice.oneanswer', compact('answer', 'question', 'excelques'));

    }

    public function correctanswer($questionid)
    {
        $question = Question::findorfail($questionid);
        $theuseranswer_id = session('useranswer' . $questionid);
        $theuseranswer = Answeroption::where('id', '=', $theuseranswer_id)->first();
        $answer = Answeroption::where('iscorrect', '=', 1)->where('question_id', '=', $questionid)->first();
        if ($theuseranswer_id == $answer->id) {

            if (session()->has('countofcorrectanswers')) {
                $countofcorrectanswers = Session('countofcorrectanswers') + 1;
            } else {
                $countofcorrectanswers = 1;
            }

            Session(['countofcorrectanswers' => $countofcorrectanswers]);

        } else {

            if (session()->has('countofbadanswers')) {
                $countofbadanswers = Session('countofbadanswers') + 1;
            } else {
                $countofbadanswers = 1;
            }
            Session(['countofbadanswers' => $countofbadanswers]);
        }
        if ($answer) {
            session(['correctanswer' . $questionid => $answer->id]);
            session(['questionischecked' . $answer->question_id => $answer->question_id]);

            $praticeresult = Practiceresult::where('user_id', '=', Auth::user()->id)->where('question_id', '=', $questionid)->whereDate('created_at', '=', Carbon::today()->toDateString())->first();
            if (!$praticeresult) {
                $praticeresult = new Practiceresult;
            }

            $praticeresult->question_id = $questionid;
            $praticeresult->user_id = Auth::user()->id;
            $praticeresult->answer_id = $theuseranswer->id;
            $praticeresult->iscorrect = $theuseranswer->iscorrect;
            $praticeresult->save();
            $val = $this->setskillmasterylevels_for_practice(Auth::user()->id, $questionid);
            return $answer->id;
        }

        return 0;

    }

    public function result($exerciseid, $userinterest_id = null)
    {

        echo $userinterest_id;
        $exerciseset = Exerciseset::findorfail($exerciseid);

        $countofcorrectanswer = Session('countofcorrectanswers');
        $countofbadanswer = Session('countofbadanswers');
        if ($countofcorrectanswer == null) {
            $countofcorrectanswer = 0;
        }

        if ($countofbadanswer == null) {
            $countofbadanswer = 0;
        }

        if ($userinterest_id == null || $userinterest_id == 0);
        else{
            $userinterest = Userinterest::where('id', '=', $userinterest_id)->get();
            if ($userinterest) {
                $userinterest = Userinterest::where('id', '=', $userinterest_id)->first();
                $discpline_id = $userinterest->discipline_id;

                $exercise_type = $userinterest->exercise_type;

                if ($exercise_type == 1) {
                    // free exercise set

                } else {
                    // purchased exercise set
                    $user = Auth::user();
                    $exerciseset = $user->exercises();
                    $exerciseset = $exerciseset->where('grade_id', '=', $userinterest->grade_id);
                    $exerciseset = $exerciseset->where('language_id', '=', $userinterest->language_id);

                    // list of user exercises
                }

                $listofskills = Exerciseset::join('questions', 'exercisesets.id', '=', 'exercise_id')->where('grade_id', '=', $userinterest->grade_id)
                    ->where('language_id', '=', $userinterest->language_id)->where('price', '=', 0)->whereNotNull('skill_id')
                    ->where('discipline_id', '=', $userinterest->discipline_id)->select('skill_id')->groupBy('skill_id')->get();

                if ($listofskills->count() != 0) {

                    $sub = UserSkillmasterylevel::select('user_id', 'skill_id', DB::raw('max( created_at )  as max_date'))->groupBy('user_id')
                        ->groupBy('skill_id');
                    Storage::disk('local')->append('testtitititiit', $sub->toSql());
                    $mastrylevel = UserSkillmasterylevel::join(DB::raw("( {$sub->toSql()}  )  max_table "), function ($join) {
                        $join->on('max_table.max_date', '=', 'userskillmasterylevels.created_at')
                            ->on('max_table.user_id', '=', 'userskillmasterylevels.user_id')
                            ->on('max_table.skill_id', '=', 'userskillmasterylevels.skill_id');

                    })->wherein('userskillmasterylevels.skill_id', $listofskills)->where('userskillmasterylevels.user_id', '=', Auth::user()->id)->get();

                }

            }

        }

        return view('practice.practiceresult', compact('exerciseset', 'countofcorrectanswer', 'countofbadanswer', 'mastrylevel'));

    }

    private function clearsessiondata($exercise)
    {

        session()->forget('countofcorrectanswer' . $exercise->id);
        session()->forget('countofbadanswer' . $exercise->id);

        session()->forget('countofcorrectanswers');
        session()->forget('countofbadanswers');

        $questions = $exercise->question()->get();
        foreach ($questions as $question) {
            session()->forget('useranswer' . $question->id);
            session()->forget('qisanswered' . $question->id);
            session()->forget('questionischecked' . $question->id);
            session()->forget('correctanswer' . $question->id);

        }
        return;
    }

    public function buyexercise($id)
    {

        try {

            $exerciseset = Exerciseset::with('discipline', 'grade', 'language')->findOrFail($id);

            return view('exercisesets.buyexercise', compact('exerciseset'));

        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function buy($id)
    {

        try {

            $exercisesetbuyers = Exercisesetbuyer::where('user_id', '=', Auth::user()->id)->where('exerciseset_id', '=', $id)->first();
            if (!$exercisesetbuyers) {
                $exercisesetbuyers = new Exercisesetbuyer;
                $exercisesetbuyers->user_id = Auth::user()->id;
                $exercisesetbuyers->exerciseset_id = $id;
                $exercisesetbuyers->save();
                $exerciseset = Exerciseset::where('id', '=', $id)->first();
                event(new ExerciseSetCreated($exerciseset));
            }

            Storage::disk('local')->append('addddddd.txt', 'done');
            return "done";

        } catch (Exception $exception) {
            Storage::disk('local')->append('addddddd.txt', $exception);
            return $exception;
        }
    }

    /**
     *
     * Develop by Wc.
     *
     *  Store user's answere to practice table.
     *
     * @param Illuminate\Http\Request $request
     * @return Response
     */
    public function storeAnswereToPracticeTable()
    {
        $question_id = request('question_id');
        $answere_id = request('answere_id');
        $exercise_id = request('exercise_id');
        $topics_id = request('topic_id');
        $practice_token = request('practice_token');
        if ($exercise_id == null) {
            $question = Question::where('id', '=', $question_id)->first();
            $exercisesets = Exerciseset::where('id', '=', $question->exercise_id)->first();
            $exercise_id = $exercisesets->id;
            $topics_id = $exercisesets->topics->id;
        }
        $correct_ans = Answeroption::where('question_id', '=', $question_id)->where('iscorrect', '=', 1)->first();
        $answere = Answeroption::where('id', '=', $answere_id)->first();
        if (Auth::user()) {
            Practiceresult::create([
                'question_id' => $question_id,
                'user_id' => Auth::user()->id,
                'answer_id' => $answere_id,
                'iscorrect' => $answere->iscorrect == true ? 1 : 0,
                'exercise_id' => $exercise_id,
                'topics_id' => $topics_id,
                'practice_token' => $practice_token,
            ]);
            $val = $this->setskillmasterylevels_for_practice(Auth::user()->id, $question_id);
        }
        return ['answere_id' => $answere->id, 'iscorrect' => $answere->iscorrect, 'correct_ans' => $correct_ans->id];
    }

    /**
     * Develop by : Wc
     * Get single question from array.
     *
     * @param int $questionid
     * @return array
     */
    public function nextquestion($questionid)
    {
        $question = Session()->get('jsonQuesions');
        $index = $questionid;
        if (array_key_exists($index, $question)) {
            return [$question[$index]];
        } else {
            return ["error" => false];
        }
    }

    /**
     *  Developed By : Wc
     *  Send report a problem related query email to the teacher
     *
     *  @param  Request
     *  @return Response
     */
    public function reportProblem()
    {
        //dd(request()->all());
        $questionId = request()->questionId;
        $question = Question::where('id', $questionId)->first();
        $description = request('description');
        $problem = request('problem');
        $exerciseSet = Exerciseset::with('owner')->where('id', request('excersice_id'))->select('createdby')->first(); //Find the owner of exerciseset
        if ($exerciseSet == null) {
            $exercise_id = $question->exercise_id;
            $exerciseSet = Exerciseset::with('owner')->where('id', $exercise_id)->select('createdby')->first();
        }

        if ($exerciseSet) { // Check if record found
            $email = $exerciseSet->owner['email'];
            try {
                Mail::to($email)->send(new ReportProblem($description, $problem, $question));
                Storage::disk('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $email);
                Storage::disk('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');

                return response()->json([
                    'message' => Lang::get('practice.success_message'),
                    'error' => false,
                ]);
            } catch (Exception $exception) {
                return response()->json([
                    'error' => true,
                    'message' => $exception,
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => Lang::get('practice.exercise_owner_not_found'),
            ]);
        }
    }

    /**
     *  Developed By : Wc
     *  Finish Practice Result
     *
     *  @param  Request
     *  @return View
     */

    public function finishPractice()
    {
        // For xppoints Badges
        if (Auth::user()) {
            if (Auth::user()->hasRole('Learner') > 0) {
                $this->add_xp_point(Auth::user()->id, 'practice', 'Learner');
            }
        }

        //For assignment practice.
        if (request('exerciseid') !== null) {
            $exerciseset = Exerciseset::findorfail(request('exerciseid'));
            $discpline = Discipline::where("topic_id", $exerciseset->topics->id)->first();
        } else {
            $exerciseset = [];
            $discpline = [];
        }
        $totalMins = request('totalMinutes');
        if (Auth::user()) {
            $username = Auth::user()->name;
        } else {
            $username = '';
        }
        $totalQuestion = request('totalQuestion');
        $currectAnswers = request('rightanscount');
        $inCurrectAnswers = $totalQuestion - $currectAnswers;
        $exerciseset_url = request('exerciseset_url');

        //Fetch result practice Tokan.
        $practice_token = request('practice_token');

        // Check if result is better or average
        $finalResult = $totalQuestion / 2;
        if ($currectAnswers >= $finalResult) {
            $message = Lang::get('practice.well_done');
        } else {
            $message = Lang::get('practice.you_need_to_improve');
        }
        return view('practice.practiceresult', compact('discpline', 'exerciseset', 'totalMins', 'username', 'totalQuestion', 'currectAnswers', 'inCurrectAnswers', 'message', 'exerciseset_url', 'practice_token'));
    }

    /**
     * Display user's practice report.
     *
     */
    public function getUserPracticeAnswerReport($practice_token)
    {

        $practiceresult = Practiceresult::where('user_id', '=', Auth::user()->id)
            ->where('practice_token', '=', $practice_token)
            ->with('question.answeroptions')->get();

        $dateTime = Practiceresult::where('user_id', '=', Auth::user()->id)
            ->where('practice_token', '=', $practice_token)
            ->latest('created_at')
            ->first();
        // $questions = [];

        // foreach($practiceresult as $request){

        //     echo "<pre>";
        //     print_r($request->question);
        //     echo "<pre>";
        // }
        // dd($dateTime);
        // exit;
        return view('practice.answer_report')->with(['practiceresult' => $practiceresult, 'dateTime' => $dateTime]);
    }

}
