<?php

namespace App\React\Exams;

use App\Models\Discipline;
use App\Models\Disciplineversion;
use App\Models\Exam;
use App\Models\Examquestion;
use App\Models\Exerciseset;
use App\Models\Question;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Models\Skillcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Trexology\ReviewRateable\Contracts\ReviewRateable;
use Trexology\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;
use App\Models\User;
use App\Models\Examselection;
use Exception;

class ExamsController extends Controller
{

    public function __construct ()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware ('auth');
    }

    // displaying list of exams
    public function index ()
    {
        Auth::user ()->authorizeRoles (['Learner', 'Teacher', 'Admin', 'Parent']);
        $exams = Exam::with ('skillcategory', 'skill', 'teacheruser')->where ('teacheruser_id', '=', Auth::user ()->id)->paginate (3);
            $user=Auth::user ();
            $enrolledclasses=$user->enrolledclasses()->where('status','=' , 'Accepted')->get();
            $classesexams =new Collection;
            foreach ($enrolledclasses as $enrolledclass             ) {
               $classexams=$enrolledclass->exams()->get();

                $classesexams=$classesexams->merge($classexams);
            }
        $classesexams=$classesexams->sortByDesc('pivot.exam_start_date');

        return view ('exams.index', compact ('exams' ,'classesexams'));
    }


    // Show the form for creating a new exam.
    public function create ()
    {

        $skillcategories = Skillcategory::pluck ('skill_category_name', 'id')->all ();
        $skills = Skill::pluck ('skill_name', 'id')->all ();
        $teacherusers = Auth::user ();
        $questions=$this->myquestionsection();
        $exam=new Exam();
         return view ('exams.create', compact ('skillcategories', 'skills', 'teacherusers', 'questions'))
            ->nest ('nestquestion', 'exams/exercise_question', compact ('questions' , 'exam'));
    }

    public function myquestionsection(){

        $list_questions_id = array();
        $list_questions = session ()->get ('questions', []);

        foreach ($list_questions as $question) {
            array_push ($list_questions_id, key ($list_questions));
            next ($list_questions);
        }
        $questions = Question::whereIn ('id', $list_questions_id)->get ();
        session ()->pull('selected_question');
        session ()->put('selected_question', $questions);

        $allquestion=session ()->get('listquestions');


        session ()->pull('listquestions');
        session ()->put('listquestions', $allquestion);
         return $questions;

    }


    public function storequestionselection (Request $request)
    {

        if ($request->has ('selected_question')) {
            //get selected question id and store them in session
            $questions = $request->input ('selected_question');
            if (session ()->has ('questions')) {
                session ()->pull ('questions');
            }
            session ()->put ('questions', $questions);
        }
        if ( session ()->has ('edit')) {
            $exam_id=session ()->get('edit');
            $exam=Exam::findorfail($exam_id);
            $teacherusers=Auth::user ();
            $questions=$this->myquestionsection();
            return view ('exams.edit', compact ( 'exam','teacherusers', 'questions'))
                ->nest ('nestquestion', 'exams/exercise_question', compact ('questions' ,'exam'));


        }

        return redirect ()->route ('exams.exam.create');


    }


    // first page of exam creation, to select disciplines, exercisesets and skill categories
    public function create_firstpage ($edit =null)
    {


        if (!$edit) {
            if (session ()->has ('edit')) session ()->pull ('edit');
        }


        if ( session ()->has ('selectdisciplines'))  session ()->pull ('selectdisciplines');
        if ( session ()->has ('skillcategories'))  session ()->pull ('skillcategories');
        if ( session ()->has ('selectedexercises'))  session ()->pull ('selectedexercises');
        if ( session ()->has ('questions'))  session ()->pull ('questions');
        if ( session ()->has ('selected_question'))  session ()->pull ('selected_question');
        if ( session ()->has ('listquestions'))  session ()->pull ('listquestions');
        session ()->put ('norefresh', 'no');



        $disciplines = Discipline::all ();
        $exercisesets = new Collection();
        $skillcategories = new Collection;
        session ()->pull ('selectdisciplines');
        return view ('exams.create_firstpage', compact ('disciplines', 'exercisesets', 'skillcategories'));
    }

    // part of the first page of exam creation
    public function selectdiscipline ()
    {

        $id = $_GET['id'];
        $action = $_GET['action'];
        $selected_rate = $_GET['selectedrate'];

        if ($action == 'checked') {
            if ($id == -2) {
                $alldisciplines = Discipline::all ();
                foreach ($alldisciplines as $discipline) {
                    session ()->put ('selectdisciplines', array_add ($selectdisciplines = session ()->get ('selectdisciplines'), $discipline->id, 'on'));
                    session ()->put ('selectdisciplines', array_add ($selectdisciplines = session ()->get ('selectdisciplines'), -1, 'on'));

                }
            } else {


                session ()->put ('selectdisciplines', array_add ($selectdisciplines = session ()->get ('selectdisciplines'), $id, 'on'));
            }

        } elseif ($action == 'unchecked') {
            if ($id == -2) {
                $alldisciplines = Discipline::all ();
                foreach ($alldisciplines as $discipline) {

                    session ()->forget ('selectdisciplines.' . $discipline->id);
                    session ()->forget ('selectdisciplines.-1');
                }
            }

            session ()->forget ('selectdisciplines.' . $id);
        }


        $selected_disciplines = session ()->get ('selectdisciplines', []);
        $exercisesets = new Collection;
        $skillcategories = new Collection;
        $user = Auth::user ();
        foreach ($selected_disciplines as $selected_discipline) {

            $discipline_id = key ($selected_disciplines);
            if ($discipline_id == -1) { // No specified discipline , i.e discipline_id is null

                $exercisesets1 = $user->myexercises ()->get ()->where ('discipline_id', '=', null);
                $exercisesets2 = $user->exercises ()->get ()->where ('discipline_id', '=', null);
                $exercisesets = $exercisesets->merge ($exercisesets1);
                $exercisesets = $exercisesets->merge ($exercisesets2);

            } else {
                $exercisesets1 = $user->myexercises ()->get ()->where ('discipline_id', '=', $discipline_id);
                $exercisesets2 = $user->exercises ()->get ()->where ('discipline_id', '=', $discipline_id);
                $exercisesets = $exercisesets->merge ($exercisesets1);
                $exercisesets = $exercisesets->merge ($exercisesets2);
            }

            if ($discipline_id != -1) {
                $disciplines = Discipline::findorfail ($discipline_id);
                // get the last knowledge map version
                $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplines->id)->max ('version');
                if (is_null ($lastversion) == true) $lastversion = 0;

                $skillcategories_discipline = Skillcategory::Where ([['discipline_id', '=', $disciplines->id], ['version', '=', $lastversion], ['publish_status', '=', 'published']])
                    ->get ()->sortBy ('sort_order');

                $skillcategories = $skillcategories->merge ($skillcategories_discipline);
            }
            next ($selected_disciplines);
        }
        session ()->put ('norefresh', 'no');
        $exercisesets->unique ();


        return view ('exams.Skillcategories_exercise', compact ('exercisesets', 'skillcategories'));
    }

    /**
     * data for the second page of exam creation
     * getting the list of questions as per the filter in the first page
     **/

    public function selectquestions (Request $request)
    {


        /*------------------------------- this part is used when user click back */
        $slected_question = new Collection();
        if (session ()->has ('norefresh')) {

            if (session ()->has ('questions')) {

                session ()->pull ('listquestions');
                session ()->pull ('selected_question');
                session ()->pull ('norefresh');

            }
        } else {

            $back=1;
            $listquestions=session ()->get('listquestions');
            $slected_question=session ()->get('selected_question');
            $listquestions=$listquestions->diff($slected_question);
            if ($slected_question==null) {
                $slected_question=new Collection();
            }
            return view ('exams.selectquestions', compact ('listquestions', 'slected_question' ,'back'));

        }
        //-----------------------------------------------------------------------------------

        //getting the list of skillcategories and the list of skills
        $list_skilcats = array();
        $list_skills = new Collection();
        if ($request->has ('skillcategory')) {
            //get skill category ids from request or session
            $skillcategories = $request->input ('skillcategory');
            if (session ()->has ('skillcategories')) {
                session ()->pull ('skillcategories');
            }
            session ()->put ('skillcategories', $skillcategories);

            //build skillcategories lists
            // those skill categories are already selected from last version
            foreach ($skillcategories as $skillcategory) {
                array_push ($list_skilcats, key ($skillcategories));
                next ($skillcategories);
            }

            $list_skills=Skill::whereIn('skill_category_id',$list_skilcats)->get();
            $list_skills = $list_skills->unique ();
        }

        $questions = new Collection();

        //getting the questions available in the selected exercise sets
        if ($request->has ('exercise')) {
            $selectedexercises_id = $request->input ('exercise');
            if (session ()->has ('selectedexercises')) {
                session ()->pull ('selectedexercises');
            }
            session ()->put ('selectedexercises', $selectedexercises_id);

            $list_exercises = array();
            foreach ($selectedexercises_id as $exercise) {
                array_push ($list_exercises, key ($selectedexercises_id));
                next ($selectedexercises_id);
            }


            if (count ($list_exercises) <> 0)
                $questions = Question::whereIn ('exercise_id', $list_exercises)->get ();
        } else {
          //  sets
            //--TODO-- If no exercise set selected get the questions of all exercise  related to this discipline/user
            // $questions= ;
        }


        $array_of_skills = array();
        foreach ($list_skills as $skill) {
            array_push ($array_of_skills, $skill->id);
        }

        // filter the questions that are related to skill categories list and skills list


        if (count ($list_skilcats) <> 0 && $questions->count () <> 0) {
            $listquestions1 = $questions->whereIn ('skill_category_id', $list_skilcats);
            $listquestions2 = $questions->whereIn ('skill_id', $array_of_skills);

            // --TODO-- should we get the questions that are not related to skillcategory or skill??
            $listquestions = $listquestions1->merge ($listquestions2);
        } else {
            // if no categories selected no filtering applied
            $listquestions = $questions;
        }
        $listquestions = $listquestions->unique ();

        $back=0;
        $slected_question =new Collection();
        session()->put('listquestions', $listquestions);
        return view ('exams.selectquestions', compact ('listquestions', 'slected_question' ,'back'));

    }


    /**
     * Store a new exam in the storage.
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            if (session ()->has ('questions')) {

                $data = $this->getData ($request);

                if ($request->has ('isavailable')) {

                    $data['isavailable'] = 'Y';


                } else {
                    $data['isavailable'] = 'N';
                }
                $data['teacheruser_id'] = Auth::user ()->id;

                $exam = Exam::create ($data);
                $i = 0;
                $list_questions = session ()->get ('questions', []);

                foreach ($list_questions as $question_id) {
                    $i++;
                    $examquestions = new Examquestion;
                    $examquestions->exam_id = $exam->id;
                    $examquestions->question_id = key ($list_questions);
                    $mark=array_get($data, 'mark.'.key ($list_questions));
                    $examquestions->points = $mark;
                    $examquestions->sort_order = $i;
                    $examquestions->save ();
                    next ($list_questions);
                }
                if(session()->has ('skillcategories')) {
                    $list_skillcategories=session()->get('skillcategories');
                    $this->store_selection($list_skillcategories ,'skillcategories',$exam);
                                    }

                    if(session()->has ('selectedexercises')) {
                        $list_exercises=session()->get('selectedexercises');
                       $this->store_selection($list_exercises ,'exercisesets',$exam);
                }

                if(session()->has ('selectdisciplines')) {
                    $list_disciplines=session()->get('selectdisciplines');
                    $this->store_selection($list_disciplines ,'disciplines',$exam);
                            }
            } else {
                return back ()->withInput ()
                    ->withErrors (['unexpected_error' => "you didn't select any question"]);

            }


            return redirect ()->route ('exams.exam.index')
                ->with ('success_message', 'Exam was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    private function store_selection ($list ,$selection_table ,$exam){

        $list_exercises=session()->get('selectedexercises');
        foreach ($list as $item){
            $examselection =New Examselection();
            $examselection->exam_id=$exam->id;
            $examselection->selection_id=key($list);
            $examselection->selection_table=$selection_table;
            $examselection->isselected=1;
            $examselection->save();
            next($list);
        }
        return;

    }

    /**
     * Get the request's data from the request.
     * return array
     */
    protected function getData (Request $request)
    {
        $rules = [
            'examtype' => 'required',
            'title' => 'required|string|min:1|max:250',

        ];

        if ($request->has('mark')) {
        foreach($request->get('mark') as $key => $val)
        {
            $rules['mark.'.$key] = 'required|numeric';
        } }


        $data = $request->validate ($rules);

        return $data;
    }

    /**
     * Display the specified exam.
     * param int $id
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $exam = Exam::with ('skillcategory', 'skill', 'teacheruser')->findOrFail ($id);

        return view ('exams.show', compact ('exam'));
    }

    /**
     * Show the form for editing the specified exam.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {

        $exam = Exam::findOrFail ($id);

        $teacherusers = Auth::user ();

        if (Auth::user ()->can ('editexam', $exam)) {

            if (session ()->has ('norefresh')) session ()->pull ('norefresh');

            $examselections_exercises = Examselection::select ('selection_id')->where ('exam_id', '=', $id)->where ('selection_table', '=', 'exercisesets')->get ()->toArray ();
            $examselections_skillcats = Examselection::select ('selection_id')->where ('exam_id', '=', $id)->where ('selection_table', '=', 'skillcategories')->get ()->toArray ();
            $questions = Question::whereIn ('exercise_id', $examselections_exercises)->get ();
            $list_skills = Skill::select ('id')->whereIn ('skill_category_id', $examselections_skillcats)->get ()->toArray ();


            if (count ($examselections_skillcats) <> 0 && $questions->count () <> 0) {
                $listquestions1 = Question::whereIn ('skillcategory_id', $examselections_skillcats)->whereIn ('exercise_id', $examselections_exercises)->get ();;
                $listquestions2 = Question::whereIn ('skill_id', $list_skills)->whereIn ('exercise_id', $examselections_exercises)->get ();;
                $listquestions = $listquestions1->merge ($listquestions2);

            } else {
                // if no categories selected no filtering applied
                $listquestions = $questions;
            }

            $slected_question_id = Examquestion::select ('question_id')->where ('exam_id', '=', $id)->get ()->toArray ();
            $slected_question = Question::whereIn ('id', $slected_question_id)->get ();

            $listquestions = $listquestions->unique ();



            if (session ()->has ('listquestions')) session ()->pull ('listquestions');
            if (session ()->has ('selected_question')) session ()->pull ('selected_question');
            if (session ()->has ('edit')) session ()->pull ('edit');

            session ()->put ('listquestions', $listquestions);
            session ()->put ('edit', $id);
            session ()->put ('selected_question', $slected_question);


            $questions = $slected_question;
            return view ('exams.edit', compact ('exam', 'teacherusers', 'questions'))
                ->nest ('nestquestion', 'exams/exercise_question', compact ('questions', 'exam'));

        }
        else {
            return back ()
                ->with (['success_message' => 'You cannot edit this exam']);
        }
    }

    /**
     * Update the specified exam in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);
            if ($request->has ('isavailable')) {
                $data['isavailable'] = 'Y';
            } else {
                $data['isavailable'] = 'N';
            }
            $data['teacheruser_id'] = Auth::user ()->id;
            $exam = Exam::findOrFail ($id);
            $exam->update ($data);
            $i = 0;
            $deletedexamquestions =Examquestion::where('exam_id','=',$id)->delete();
            $list_questions = session ()->get ('selected_question');
            foreach ($list_questions as $question) {
                $i++;
                $examquestions = new Examquestion;
                $examquestions->exam_id = $exam->id;
                $examquestions->question_id = $question->id;
                $mark=array_get($data, 'mark.'.$question->id);
                $examquestions->points = $mark;
                $examquestions->sort_order = $i;
                $examquestions->save ();

            }


            if(session()->has ('skillcategories')) {
                $deleteselection =Examselection::where('exam_id','=',$id) ->where ('selection_table','=','skillcategories')->delete();
                $list_skillcategories=session()->get('skillcategories');
                $this->store_selection($list_skillcategories ,'skillcategories',$exam);
            }

            if(session()->has ('selectedexercises')) {
                $deleteselection =Examselection::where('exam_id','=',$id) ->where ('selection_table','=','exercisesets')->delete();
                $list_exercises=session()->get('selectedexercises');
                $this->store_selection($list_exercises ,'exercisesets',$exam);
            }

            if(session()->has ('selectdisciplines')) {
                $deleteselection =Examselection::where('exam_id','=',$id) ->where ('selection_table','=','disciplines')->delete();
                $list_disciplines=session()->get('selectdisciplines');
                $this->store_selection($list_disciplines ,'disciplines',$exam);
            }



            return redirect ()->route ('exams.exam.index')
                ->with ('success_message', 'Exam was successfully updated!');

       } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified exam from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $exam=Exam::findorfail($id);
            if (Auth::user ()->can ('editexam', $exam)) {
                $exam = Exam::findOrFail ($id);
                $exam->delete ();
                $deleteselection =Examselection::where('exam_id','=',$id) ->delete();

                return redirect ()->route ('exams.exam.index')
                    ->with ('success_message', 'Exam was successfully deleted!');
            }
            else {
                return back ()
                    ->with (['success_message' => 'You cannot delete this exam']);

            }
        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

}
