<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/19/2018
 * Time: 1:21 PM
 */

namespace App\Http\Controllers\Exams;

use App\Http\Controllers\Controller;
use App\Http\Traits\AddXppoint;
use App\Http\Traits\Setskillmasterylevels;
use App\Models\Answeroption;
use App\Models\Classexam;
use App\Models\Classlearner;
use App\Models\Exam;
use App\Models\Examquestion;
use App\Models\GoogleclassExams;
use App\Models\GoogleclassLearners;
use App\Models\Passage;
use App\Models\Pendingtask;
use App\Models\Question;
use App\Models\Userexamanswer;
use App\Models\Userexamscore;
use function GuzzleHttp\json_decode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class TakeexamController extends Controller
{
    use Setskillmasterylevels;
    use AddXppoint;
    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        //   $this->middleware('auth');

        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($examid, $classid, $isexam = "0")
    {

        if (isset(request()->examtype)) {
            $examFrom = request()->examtype;
        } else {
            $examFrom = null;
        }
        // For xppoints Badges
        if (Auth::check()) {
            if (Auth::user()->hasRole('Learner') > 0) {
                $this->add_xp_point(Auth::user()->id, 'completing assignment', 'Learner');
            }

        }

        if ($examFrom == null) {
            $classexam = Classexam::where('class_id', '=', $classid)->where('exam_id', '=', $examid)->first();
        } else {
            $classexam = GoogleclassExams::where('class_id', '=', $classid)->where('exam_id', '=', $examid)->first();
        }

        if ($classexam) {

            if (Auth::check()) {
                if ($examFrom == null) {
                    $check = Auth::user()->can('takeexam', $classexam);
                } else {
                    $check = Auth::user()->can('tackExamGoogle', $classexam);
                }
            } else {
                if (isset($_GET['share_id']) && Cache::get($_GET['share_id']) == true) {
                    $check = true;
                } else {
                    $check = false;
                }
            }
            if ($check) {

                $exam = Exam::findorfail($examid);
                // $questions = $exam->examquestions ()->orderBy ('examquestions.sort_order', 'asc')->paginate();
                $questions = $exam->examquestions()->orderBy('examquestions.sort_order', 'asc')->get();

                if (Auth::check()) {
                    $this->add_xp_point(Auth::user()->id, 'takeexam');
                }

                $nextquestionid = 0;

                if (count($questions) > 0) {
                    // Create final JSON Object
                    $jsonArr = array();
                    foreach ($questions as $question) {
                        //   $jsonArr[] = json_decode($question->json_details,TRUE);
                        $jsonArr[] = json_decode($question->paramRenderQuestion(), true);
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
                $discpline_url = route('explore.exerciseset');
                $exerciseset_url = route('takeexam.index', [$examid, $classid, $isexam = "1"]);

                $practice_type = 'assignment';

                $exerciseid = '';
                if ($exam->examtype !== 'practice') {
                    //This view for homework and exam.
                    return view('takeexam.index', compact('questions', 'classexam', 'exam', 'isexam', 'classid', 'jsonDetail', 'nextquestionid',
                        'questionCount', 'exerciseid', 'discpline_url', 'exerciseset', 'exerciseset_url', 'practice_type', 'examFrom'))->with(['HideNavBars' => true, 'IsExam' => true]);
                } else {
                    //This view for only practice.
                    return view('practice.index', compact('jsonDetail', 'nextquestionid', 'questionCount', 'exerciseid', 'discpline_url', 'exerciseset',
                        'exerciseset_url', 'practice_type', 'classid', 'exam'))->with(['HideNavBars' => true, 'IsExam' => true]);
                }
                //     return view('practice.index',compact('jsonDetail','nextquestionid','questionCount','exerciseid', 'discpline_url','exerciseset','exerciseset_url','practice_type'));

            } else {

                if (Auth::check()) {
                    $userexamscore = Userexamscore::where('user_id', '=', Auth::user()->id)->where('classexam_id', '=', $classexam->id)->first();
                    if ($userexamscore) {

                        $correctanswers = $this->totalcorrectanswers($classexam);
                        $badanswers = $this->totalbadtanswers($classexam);
                        $userexamscore = Userexamscore::where('user_id', '=', Auth::user()->id)->where('classexam_id', '=', $classexam->id)->first();
                        return view('takeexam.result', compact('userexamscore', 'classexam', 'correctanswers', 'badanswers', 'isexam'))->with(['HideNavBars' => true, 'IsExam' => true]);

                    }
                    if ($examFrom == null) {
                        $classlearner = Classlearner::where('user_id', '=', Auth::user()->id)->where('class_id', '=', $classid)->where('status', '=', 'Accepted')->first();
                    } else {
                        $classlearner = GoogleclassLearners::where('user_id', '=', Auth::user()->id)->where('class_id', '=', $classid)->where('status', '=', 'Accepted')->first();
                    }

                    if ($classlearner) {
                        $this->finishexam($classexam->id);
                        $correctanswers = $this->totalcorrectanswers($classexam);
                        $badanswers = $this->totalbadtanswers($classexam);
                        $userexamscore = Userexamscore::where('user_id', '=', Auth::user()->id)->where('classexam_id', '=', $classexam->id)->first();
                        return view('takeexam.result', compact('userexamscore', 'classexam', 'correctanswers', 'badanswers', 'isexam'))->with(['HideNavBars' => true, 'IsExam' => true]);
                    }

                    return view('takeexam.unauthorized', compact('classexam'))->with(['HideNavBars' => true, 'IsExam' => true]);

                }
                else {
                  return view('unauthorized');
                }

            }
        } else {
            return view('takeexam.unauthorized', compact('classexam'))->with(['HideNavBars' => true, 'IsExam' => true]);
        }

    }

    public function listofquestion($classexamid)
    {

        $classexam = Classexam::where('id', '=', $classexamid)->first();
        if ($classexam) {
            if (Auth::user()->can('takeexam', $classexam)) {
                $exam = Exam::where('id', '=', $classexam->exam_id)->first();
                $questions = $exam->examquestions()->orderBy('examquestions.sort_order', 'asc')->paginate(1);
                return view('takeexam.question', compact('questions', 'classexam'));
            } else {
                return "can't take exam";
                return view('takeexam.unauthorized');
            }
        } else {

            return "class exam not exist";
            return "takeexam.unauthorized";}

    }

    public function clickedanswer($answerid, $classexamid, Request $request)
    {
        $timespent = 0;
        if ($request->has('timespent')) {
            $timespent = $request['timespent'];
        }

        Storage::disk('local')->append("examanswer.txt", $classexamid);

        $answer = Answeroption::findorfail($answerid);
        $question = Question::findorfail($answer->question_id);

        if ($request->has('examtype')) {
            $classexam = GoogleclassExams::where('id', '=', $classexamid)->first();
        } else {
            $classexam = Classexam::where('id', '=', $classexamid)->first();
        }

        $user_id = Auth::user()->id;
        $examquestion = Examquestion::where('exam_id', '=', $classexam->exam_id)->where('question_id', '=', $question->id)->first();
        $userexamanswer = Userexamanswer::where('user_id', '=', $user_id)->where('exam_id', '=', $classexam->exam_id)
            ->where('class_id', '=', $classexam->class_id)->where('classexam_id', '=', $classexam->id)->where('question_id', '=', $question->id)->first();
        if (!$userexamanswer) {
            $userexamanswer = new Userexamanswer();
            $userexamanswer->user_id = $user_id;
            $userexamanswer->exam_id = $classexam->exam_id;
            $userexamanswer->class_id = $classexam->class_id;
            $userexamanswer->classexam_id = $classexam->id;
            $userexamanswer->question_id = $question->id;
            $userexamanswer->answer_id = $answerid;
            if (empty($answer->iscorrect)) {
                $iscorrect = '0';
            } else {
                $iscorrect = '1';
            }
            $userexamanswer->iscorrect = $iscorrect;
            $userexamanswer->teachermark = $examquestion->points;
            $userexamanswer->attempt_number = $userexamanswer->attempt_number + 1;
            $userexamanswer->timespent = $userexamanswer->timespent + $timespent;
            $userexamanswer->user_agent = $request->server('HTTP_USER_AGENT');
            $userexamanswer->save();
        } else {

            $data = ['answer_id' => $answerid, 'timespent' => $userexamanswer->timespent + $timespent];
            $userexamanswer->fill($data);
            $userexamanswer->save();
        }

        $val = $this->setskillmasterylevels_for_exam($user_id, $classexamid, $question->id);
        return "Done";
        // return ['answere_id' => $answer->id, 'iscorrect' => $answer->iscorrect];

    }

    public function finishexam($classexamid, $isexam = "0")
    {

        if (isset(request()->examtype)) {
            $examFrom = request()->examtype;
        } else {
            $examFrom = null;
        }

        $user_id = Auth::user()->id;

        if ($examFrom == null) {
            $classexam = Classexam::where('id', '=', $classexamid)->first();
            // Pending task status update
            $task = Pendingtask::where('user_id', '=', Auth::user()->id)->where('pending_task_description', '=', "Add an Exam set to your class " . $classexam->courseclass->class_name . ", it will start at " . $classexam->exam_start_date)
                ->where('pending_task_action', '=', '/courseclasses/show/' . $classexam->class_id . '#assignments')->where('status', 'pending')->orderBy('id', 'DESC')->first();

            if ($task) {
                $task->status = "done";
                $task->save();
            }
        } else {
            $classexam = GoogleclassExams::where('id', '=', $classexamid)->first();
        }

        // This code develop by WC and This is use for display unique skill categories.
        $skillcategory = collect();
        foreach ($classexam->exam->examquestions as $question) {
            if ($question->skillcategory) {
                $skillcategory->push(
                    [
                        'skill_id' => $question->skillcategory->id,
                        'skill_category_name' => $question->skillcategory->skill_category_name,
                        'skill_category_decsription' => $question->skillcategory->skill_category_decsription,
                    ]
                );
            }

        }
        $uniqueSkillcategory = $skillcategory->unique();

        $userexamanswers = Userexamanswer::selectRaw('sum(timespent) as sumoftimespent  , sum( teachermark *  iscorrect) as score ')
            ->where('user_id', '=', $user_id)->where('classexam_id', '=', $classexamid)->first();
        $userexamscore = Userexamscore::where('user_id', '=', $user_id)->where('classexam_id', '=', $classexamid)->first();

        if (!$userexamscore) {
            $userexamscore = new Userexamscore();
        }

        $userexamscore->user_id = $user_id;
        $userexamscore->classexam_id = $classexamid;

        if (!$userexamanswers->sumoftimespent) {
            //  $timespent=0;
            //fetch total time spen
            if (isset(request()->spen_total_time)) {
                $totaltimespent = $this->seconds_from_time(request()->spen_total_time);
            } else {
                $totaltimespent = 0;
            }
        } else {
            $totaltimespent = $userexamanswers->sumoftimespent;
        }

        $userexamscore->totaltimespent = $totaltimespent;
        if (!$userexamanswers->score) {
            $score = 0;
        } else {
            $score = $userexamanswers->score;
        }

        $userexamscore->score = $score;
        $userexamscore->exam_id = $classexam->exam_id;
        $userexamscore->save();

        $correctanswers = $this->totalcorrectanswers($classexam);
        $badanswers = $this->totalbadtanswers($classexam);

        // Check if result is better or average
        $finalResult = $classexam->exam->examquestions()->count() / 2;
        if ($correctanswers >= $finalResult) {
            $message = Lang::get('practice.well_done');
        } else {
            $message = Lang::get('practice.you_need_to_improve');
        }

        return view('takeexam.result', compact('userexamscore', 'classexam', 'correctanswers', 'badanswers', 'isexam', 'message', 'uniqueSkillcategory', 'userexamanswers', 'examFrom'));

    }

    public function getpassage($passageid)
    {

        $passage = Passage::where('id', '=', $passageid)->first();

        return view('takeexam.passage', compact('passage'));

    }

    private function totalcorrectanswers($classexam)
    {

        $userexamanswers = Userexamanswer::selectRaw('count(id) as countcorrect  ')
            ->where('user_id', '=', Auth::user()->id)->where('classexam_id', '=', $classexam->id)->where('iscorrect', '=', 1)->first();
        return $userexamanswers->countcorrect;

    }

    private function totalbadtanswers($classexam)
    {
        $userexamanswers = Userexamanswer::selectRaw('count(id) as countcorrect  ')
            ->where('user_id', '=', Auth::user()->id)->where('classexam_id', '=', $classexam->id)->where('iscorrect', '=', 0)->first();
        return $userexamanswers->countcorrect;

    }

    /**
     * Develop by : Wc
     * Get single question from array.
     *
     * @param int $questionid
     * @return array
     */
    public function nextSessionQuestion($questionid)
    {
        $question = Session()->get('jsonQuesions');

        //Fetch user's answer.
        $userexamanswer = Userexamanswer::where('user_id', '=', Auth::user()->id)->pluck('question_id')->toArray();

        $index = $questionid;

        $questionIds = [];
        if (array_key_exists($index, $question)) {
            // return [$question[$index]];
            for ($i = 0; $i < count($question); $i++) {
                array_push($questionIds, $question[$i]['Questions'][0]['question_id']);
            }

            // print_r( Auth::user()->id);
            // echo "<pre> userexam";
            // print_r($userexamanswer);
            // echo "question";
            // print_r($questionIds);
            // echo "result";
            $result = array_intersect($questionIds, $userexamanswer);
            $key = array_keys($result);

            $getQuestion = [$question[$index]];
            $questionId = $getQuestion[0]['Questions'][0]['question_id'];
            $userexamanswer = Userexamanswer::where('user_id', '=', Auth::user()->id)->where('question_id', '=', $questionId)->first();

            // echo "<pre>";
            if (!empty($userexamanswer)) {
                if (isset($getQuestion[0]['Questions'][0]['Answers']['Choices'])) {
                    foreach ($getQuestion[0]['Questions'][0]['Answers']['Choices'] as $chkey => $choices) {
                        if ($choices['Attributes']['id'] == $userexamanswer->answer_id) {
                            $getQuestion[0]['Questions'][0]['Answers']['Choices'][$chkey]['Attributes']['checked'] = 'checked';
                        } else {
                            $getQuestion[0]['Questions'][0]['Answers']['Choices'][$chkey]['Attributes']['checked'] = 'unchecked';
                        }
                        // print_r($choices['Attributes']['id']);
                    }
                }
            }

            return ['question' => $getQuestion, 'dontskipquestion' => $key];
        } else {
            return ["error" => false];
        }
    }

    //Conver time
    function seconds_from_time($time)
    {
        list($m, $s) = explode(':', $time);
        return ($m * 60) + $s;
    }

}
