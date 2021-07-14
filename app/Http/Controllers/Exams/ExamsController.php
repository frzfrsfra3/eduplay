<?php

namespace App\Http\Controllers\Exams;

use App\Models\Discipline;
use App\Models\Disciplineversion;
use App\Models\Exam;
use App\Models\Topic;
use App\Models\Examquestion;
use App\Models\Exerciseset;
use App\Models\Question;
use App\Models\Skill;
use App\Models\Examtopic;
use App\Models\ExamDiscipline;
use App\Models\ExamExercises;
use App\Models\ExamSkillCategories;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\Skillcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Trexology\ReviewRateable\Contracts\ReviewRateable;
use Trexology\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;
use App\Models\User;
use App\Models\Examselection;
use App\Models\Classexam;
use Exception;
use Redirect;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use function GuzzleHttp\json_encode;
use function GuzzleHttp\Psr7\readline;
use phpDocumentor\Reflection\Types\Null_;
use function GuzzleHttp\json_decode;

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
        // dd(request()->stud);
        // dd(str_replace(url('/'), '', url()->previous()));
        Auth::user ()->authorizeRoles (['Learner', 'Teacher', 'Admin', 'Parent']);
        $exams = $this->myAssigmentData();

            $user=Auth::user ();
            $enrolledclasses=$user->enrolledclasses()->where('status','=' , 'Accepted')->get();
            $classesexams =new Collection;
            foreach ($enrolledclasses as $enrolledclass             ) {
               $classexams=$enrolledclass->exams()->get();

                $classesexams=$classesexams->merge($classexams);
            }
        $classesexams=$classesexams->sortByDesc('pivot.exam_start_date');
        /* for exam show */
        $skills=array();
        $skillcategorys=array();

        return view('exams.index', compact ('exams' ,'classesexams','skills','skillcategorys'));
    }

    //Assingment filter data.
    public function myAssigmentDisplayFiltered(){
     
        $exams = $this->myAssigmentData();        
        return view('exams.exam-filter', compact ('exams'))->render();
    }

    public function myAssigmentData(){
        $exam = Exam::where ('teacheruser_id', '=', Auth::user ()->id);
        
        //Fetch Data by created date.
        if(request('start_date') != ''){
            $startDate = Carbon::parse(request('start_date'))->format('Y-m-d')." 00:00:00";
            $endDate = Carbon::parse(request('end_date'))->format('Y-m-d')." 23:59:59";
            $exam->whereBetween('created_at', [$startDate, $endDate]); 
        }

        //Fetch data by status
        if(request('Status_search') != ''){
            $exam->where ('isavailable', '=',request('Status_search'));
        }
        
        
        //Sorting Data by order.
        if(!empty(request('Sort_search')) && request('Sort_search') === 'Descending' ){
            
            $exam->orderBy('title', 'desc');
        } else {
            $exam->orderBy('title', 'asc');
        }
        
        $exam->with ('skillcategory', 'skill', 'teacheruser');

        return $exam->paginate(9);
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
    public function create_firstpage ($edit =null,$page=null,Request $request)
    {
        $examID=$edit;
        if(is_null($examID)){
            $topic = Topic::where('approve_status','approved')
                                    ->orderBy("topic_name", "ASC")
                                    ->get();

            $disciplines = Discipline::where('approve_status','approved')
                                    ->orderBy("discipline_name", "ASC")
                                    ->get();
            $exercisesets = new Collection();
            $skillcategories = new Collection;
            session ()->pull ('selectdisciplines');
            if($edit == 'class'){
                //return $edit;
                $classId =  request('class_id');
            } else {
                $classId= 'Null';
            }

            $languages = Language::orderBy('language', 'asc')->get();

            if($request->ajax()){
                $topic = $this->getTopicFilteredData();
                return view ('exams.disciplines', compact ('exercisesets', 'skillcategories','classId','topic','languages','disciplines'));
            }

            return view ('exams.create_firstpage', compact ('exercisesets', 'skillcategories','classId','topic','languages','disciplines'));
        } else{
            // For edit - get selected topic
            $examTopics=Examtopic::where('exam_id',$examID)->select('topic_id')->get();
            $selected_topic = array();
            foreach ($examTopics as $examTopic) {
                array_push ($selected_topic, $examTopic->topic_id);
            }

            $topic = Topic::where('approve_status','approved')
                                    ->orderBy("topic_name", "ASC")
                                    ->get();

            $disciplines = Discipline::where('approve_status','approved')
                                    ->orderBy("discipline_name", "ASC")
                                    ->get();
            $exercisesets = new Collection();
            $skillcategories = new Collection;
            session ()->pull ('selectdisciplines');
            if($edit == 'class'){
                //return $edit;
                $classId =  request('class_id');
            } else {
                $classId= 'Null';
            }

            $languages = Language::orderBy('language', 'asc')->get();

            if($request->ajax()){
                $topic = $this->getTopicFilteredData();
                return view ('exams.disciplines', compact ('exercisesets', 'skillcategories','classId','topic','languages','selected_topic','examID','disciplines'));
            }

            return view ('exams.create_firstpage', compact ('exercisesets', 'skillcategories','classId','topic','languages','selected_topic','examID','disciplines'));
        }
    }

    /**
     * Prepare by Wc
     * Exam topic filter
     **/
    public function getTopicFilteredData()
    {
        //dd(request('Language_search'));
        $topic = Topic::where('approve_status', '=', 'approved');

        // Fetch data by Topic's title.
        if (!empty(request('Title_search'))) {
            if (request('Title_operator') === 'like') {
                $topic->where('topic_name', 'like', '%' . request('Title_search') . '%');
            } else {
                $topic->where('topic_name', request('Title_operator'), request('Title_search'));
            }
        }

        // Sorting Data by order.
        if (!empty(request('Sort_search')) && request('Sort_search') === 'Descending') {
            $topic->orderBy('topic_name', 'desc');
        } else {
            $topic->orderBy('topic_name', 'asc');
        }

        //$topic->withCount('discipilnes');
        //$topic->withCount('exercisesets');

        //Filter by Curriculum count
        if(request('Curriculum_search') != ''){
            $topic->has('discipilnes',request('Curriculum_operator'),request('Curriculum_search'));
        }

        //Filter by Exercisesets count
        if(request('Exercisesets_search') != ''){
            $topic->has('exercisesets',request('Exercisesets_operator'),request('Exercisesets_search'));
        }

        return $topic->get();
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

            //--TODO-- If no exercise set selected get the questions of all exercise sets related to this discipline/user
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
    public function store_old (Request $request)
    {
        return $request->all();
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
                    ->withErrors (['unexpected_error' => Lang::get('exam.you_didnot_select_question')]);

            }


            return redirect ()->route ('exams.exam.index')
                ->with ('success_message', Lang::get('exam.exam_was_added'));

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => Lang::get('exam.unexpected_err') ]);
        }
    }


    private function store_selection ($list ,$selection_table ,$exam){

        //$list_exercises=session()->get('getSelectedExercisesets');
        //$list_exercises=session()->get('selectedexercises');  // old code
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
        $exam = Exam::with ('teacheruser')->findOrFail ($id);
        $examdata =  $exam->examquestions()->with('skill','skillcategory')->get();
        //create OR define collection;
        $skills=collect();
        $skillcategory=collect();
        foreach ($examdata as $value) {
            if($value->skill){
               $skills->push($value->skill);
            }
            if($value->skillcategory){
                $skillcategory->push($value->skillcategory);
            }
        }
        // unique collections
        $uniqueSkills = $skills->unique();
        $uniqueSkillcategory = $skillcategory->unique();

        if($uniqueSkills->count() > 0){
            $skills = $uniqueSkills->implode('skill_name',', ');
        }
        if($uniqueSkillcategory->count() > 0){
            $skillcategorys = $uniqueSkillcategory->implode('skill_category_name',', ');
        }
        //  return $skillcategory;
        return view ('exams.show', compact ('exam','skillcategorys','skills'));
    }

    /**
     * Show the form for editing the specified exam.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id,$page)
    {
        $exam = Exam::findOrFail ($id);

        $teacherusers = Auth::user ();
        if (Auth::user ()->can ('editexam', $exam)) {
            

            if (session ()->has ('norefresh')) session ()->pull ('norefresh');

            $slected_question_id = Examquestion::select ('question_id')->where ('exam_id', '=', $id)->get ()->toArray ();
            $slected_question = Question::whereIn ('id', $slected_question_id)->with('examquestion')->get ();

            $questions = $slected_question;

            // Create final JSON Object
            $jsonArrSelQue = array();
            foreach ($questions as $key=> $question) {
                $mark= Examquestion::select ('points')->where('question_id', '=', $question->id)->where('exam_id', '=', $id)->first();
                $jsonArrSelQue[$key] = json_decode($question->paramRenderQuestion(),TRUE);
                $jsonArrSelQue[$key]['Questions'][0]['mark'] = $mark->points;
            }

            $finalJsonObjSelQue = json_encode($jsonArrSelQue,TRUE);
            //dd($finalJsonObjSelQue);
            return view ('exams.edit', compact ('exam', 'teacherusers', 'questions','finalJsonObjSelQue','slected_question_id','page'));
            // return view ('exams.edit', compact ('exam', 'teacherusers', 'questions'))
            //     ->nest ('nestquestion', 'exams/exercise_question', compact ('questions', 'exam'));

        }
        else {
            return back ()
                ->with (['success_message' => Lang::get('exam.you_cannot_edit_this_exam')]);
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
            $delExamQue= Examquestion::where('exam_id',$id)->delete();
            $mark = $request->mark;
            $data = $this->getData ($request);
            if ($request->has ('isavailable')) {
                $data['isavailable'] = 'Y';
            } else {
                $data['isavailable'] = 'N';
            }
            $data['teacheruser_id'] = Auth::user ()->id;
            $exam = Exam::findOrFail ($id);
            $exam->update ($data);

            if (!empty($mark)) {
                foreach ($mark as $question_id => $mark) {
                    $i = 0;
                    $examquestions = new Examquestion;
                    $examquestions->exam_id = $exam->id;
                    $examquestions->question_id = $question_id;
                    $examquestions->points = $mark;
                    $examquestions->sort_order = $i;
                    $examquestions->save ();
                }
            }
            return redirect ()->route ('exams.exam.index','page='.$request->page)
                ->with ('success_message', Lang::get('exam.exam_was_updated'));

       } catch (Exception $exception) {
            return back ()->withInput ()
                ->withErrors (['unexpected_error' => Lang::get('exam.unexpected_err')]);
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

              $classExam = Classexam::where('exam_id','=',$id)->first();
              if(empty($classExam)){
                $topic = Examtopic::where('exam_id','=',$id)->delete();
                $discipline = ExamDiscipline::where('exam_id','=',$id)->delete();
                $exercises = ExamExercises::where('exam_id','=',$id)->delete();
                $skillcategory = ExamSkillCategories::where('exam_id','=',$id)->delete();
                $exam = Exam::findOrFail ($id);
                $exam->delete ();
                $deleteselection =Examselection::where('exam_id','=',$id) ->delete();

                return redirect ()->route ('exams.exam.index')
                    ->with ('success_message', Lang::get('exam.assignment_was_deleted'));
              } else {
                return back()->with (['error_message' => Lang::get('exam.you_unassign_from_class')]);
              }
            
        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => Lang::get('exam.unexpected_err')]);
        }
    }

    /**
     * Prepare by Wc
     *
     * Get exercisesset from discipline Invision flow( Create exam S1)
     */
    public function getCurriculam(Request $request)
    {
        // dd($request->all());
        /*
        if($request->getExamID == 'class'){
            // For edit - get selected curriculum
            $examDisciplines = ExamDiscipline::where('exam_id',$request->getExamID)->select('discipline_id')->get();
        }
        $selected_discipline = array();
        foreach ($examDisciplines as $examDiscipline) {
            array_push ($selected_discipline, $examDiscipline->discipline_id);
        } */

        if($request->getExamID != 'class'){
            // For edit - get selected curriculum
            $examDisciplines = ExamDiscipline::where('exam_id',$request->getExamID)->select('discipline_id')->get();
            $selected_discipline = array();
            foreach ($examDisciplines as $examDiscipline) {
                array_push ($selected_discipline, $examDiscipline->discipline_id);
            }
        }
        $disciplines = Discipline::whereIn('topic_id',$request->id)
            ->where('approve_status','approved')
            ->where('publish_status','published')
            ->get();

        $user = Auth::user();
        if(empty($request->getExamID) || $request->getExamID == 'class'){
            $exam =new Exam;
            $exam->isavailable = 'N';
        }
        else{
            $exam=Exam::find($request->getExamID);
        }
        $exam->teacheruser_id = $user->id;
        $exam->save ();
        $exam->topics()->sync($request->id);
        $exam->save ();
        $exercisesets = new Collection;
        $exercisesets1 = $user->myexercises ()->whereIn('discipline_id',$request->id)->orderBy('title', 'asc')->get();
        // $exercisesets2 = $user->exercises ()->whereIn('discipline_id',$request->id)->get();
        $exercisesets = $exercisesets->merge ($exercisesets1);
        // $exercisesets = $exercisesets->merge ($exercisesets2);


        $html = view('exams.curriculum',compact('disciplines','selected_discipline'))->render();
        return ['html'=>$html,'exam_id'=>$exam->id];
    }


    public function curriculumFiltes(Request $request)
    {
        // For edit - get selected curriculum
        $examDisciplines = ExamDiscipline::where('exam_id',$request->getexamId)->select('discipline_id')->get();
        $selected_discipline = array();
        foreach ($examDisciplines as $examDiscipline) {
            array_push ($selected_discipline, $examDiscipline->discipline_id);
        }
        $t= explode(",",$request->req_topic_id);
        $user = Auth::user();
        $exam=Exam::find($request->getexamId);
        $exam->isavailable = 'N';
        $exam->teacheruser_id = $user->id;
        $exam->save ();
        $exam->topics()->sync($request->id);
        $exam->save ();
        $disciplines = Discipline::with(['courseclasses','exercisesets','languagePreference'])
            ->whereIn('topic_id',$t)
            ->where('publish_status', 'like', 'published');
        if(!empty(request('topic_id'))){
            $disciplines->where('topic_id','=',request('topic_id'));
        }

        //Fetch Data by Topic name.
        if(request('Discipline_search') != ''){
            $disciplines->whereHas('topics',function($topic){
                if(request('Discipline_operator') === 'like'){
                    $topic->where('topic_name','like','%'.request('Discipline_search').'%');
                } else {
                    $topic->where('topic_name','=',request('Discipline_search'));
                }
                });
            } else {
            $disciplines->with('topics');
        }

        //Fetch data by discipline's name.
        if(!empty(request('Name_search'))){
            if(request('Name_operator') === 'like'){
                $disciplines->where('discipline_name','like','%'.request('Name_search').'%');
            } else {
                $disciplines->where('discipline_name',request('Name_operator'),request('Name_search'));
            }
        }

        //Fetch data by Language's name.
        if(!empty(request('Language_search'))){
            dd(request('Language_search'));
           $disciplines->where('language_preference_id','=',request('Language_search'));
        }

        //Sorting Data by order.
        if(!empty(request('Sort_search')) && request('Sort_search') === 'Descending' ){
            $disciplines->orderBy('discipline_name', 'desc');
        } else {
            $disciplines->orderBy('discipline_name', 'asc');
        }

        $disciplines->withCount('exercisesets');
        $disciplines->withCount('courseclasses');

        //Filter by Exercisesets count.
        if(request('Exercisesets_search') != ''){
          $disciplines->having('exercisesets_count',request('Exercisesets_operator'),request('Exercisesets_search'));
        }

        //Filter by Classes count.
        if(request('Classes_search') != ''){
            $disciplines->having('courseclasses_count',request('Classes_operator'),request('Classes_search'));
        }
        $disciplines = $disciplines->get();
        $html = view('exams.curriculum',compact('disciplines','selected_discipline'))->render();
        return ['html'=>$html,'exam_id'=>$exam->id];
    }

    /**
     * Prepare by Wc
     *
     * Get exercisesset from discipline Invision flow( Create exam S1)
     */
    public function getExercisesset(Request $request)
    {
        //  dd($request->all());
        // For edit - get selected exercises
        $examexercisesets=ExamExercises::where('exam_id',$request->getExamID)->select('exerciseset_id')->get();
        $selected_examexercisesets = array();
        foreach ($examexercisesets as $examexerciseset) {
            array_push ($selected_examexercisesets, $examexerciseset->exerciseset_id);
        }
        $user = Auth::user();
        if(!empty($request->id)){
            $exercisesets = new Collection;
            $exercisesets1 = $user->myexercises ()->whereIn('discipline_id',$request->id)->get();
            $exercisesets2 = $user->exercises ()->whereIn('discipline_id',$request->id)->get();
            $exercisesets = $exercisesets->merge ($exercisesets1);
            $exercisesets = $exercisesets->merge ($exercisesets2);

            $exam=Exam::find($request->getExamID);
            $exam->newdiscipline()->sync($request->id);
            $exam->save();

            // store in session
            $request->session()->put('getSelectedDiscipline', $request->id);
        }else{
            $exam=Exam::find($request->getExamID);
            $exam->newdiscipline()->sync([]);   // pass empty array due to unsync data.
            $exam->save();

            $exam=Examtopic::where('exam_id',$request->getExamID)->select('topic_id')->get();
            $topic=[];
            foreach($exam as $exm){
                if(!in_array($exm->topic_id,$topic)){
                    array_push($topic,$exm->topic_id);
                }
            }
            $exercisesets = new Collection;
            $exercisesets1 = $user->myexercises ()->whereIn('topic_id',$topic)->get();
            $exercisesets2 = $user->exercises ()->whereIn('topic_id',$topic)->get();
            $exercisesets = $exercisesets->merge ($exercisesets1);
            $exercisesets = $exercisesets->merge ($exercisesets2);

            // store in session
            $request->session()->put('getTopics', $topic);
        }

        return view('exams.myexercies',compact('exercisesets','selected_examexercisesets'))->render();
    }

    /**
     * Get Filter Exercise data.
     * 
     */
    public function getExercisessetFilter(){
        // For edit - get selected exercises
        $examexercisesets=ExamExercises::where('exam_id',request()->getexamId)->select('exerciseset_id')->get();
        $selected_examexercisesets = array();
        foreach ($examexercisesets as $examexerciseset) {
            array_push ($selected_examexercisesets, $examexerciseset->exerciseset_id);
        }

        $user = Auth::user();
        $exercisesets = new Collection;
        $exercisesets1 = $this->getExercisessetFilteredData($user);
        $exercisesets = $exercisesets->merge ($exercisesets1);

        // Do not delete this code
        /* if(!empty(request()->id)){
            $exercisesets2 = $user->exercises()->whereIn('discipline_id',request()->id)->get();
        }else{
            $exercisesets2 = $user->exercises()->whereIn('topic_id',$topic)->get();
        }
        dd($exercisesets2);
        $exercisesets = $exercisesets->merge ($exercisesets1);
        $exercisesets = $exercisesets->merge ($exercisesets2); */

        if(request('Rating_search') != null){
            $exercisesets = collect($exercisesets)->filter(function ($exercise_value, $key) {
                //Filter by Rating count.
                if(!empty(request('Rating_search'))){
                    if(request('Rating_search') === $exercise_value->averageRating(1)[0]){
                        return $exercise_value->averageRating(1)[0] == request('Rating_search');
                    }
                }
            })->unique()->all();
        } else {
            $exercisesets = $exercisesets;
        }

        // $exercisesets = $exercisesets->merge ($exercisesets2);
        return view('exams.myexercies',compact('exercisesets','selected_examexercisesets'))->render();
    }

    /**
     * 
     * Get Exercises Filtered data.
     *
     */
    public function getExercisessetFilteredData($user){

        //dd(request()->all());
        if(!empty(request('id'))){
            $descipline_ids = explode(',',request('id'));
            $myExercises = $user->myexercises()->where('createdby','=', Auth::user()->id)->whereIn('discipline_id', $descipline_ids);
        }else{
            $exam=Examtopic::where('exam_id',request('getexamId'))->select('topic_id')->get();
            $topic=[];
            foreach($exam as $exm){
                if(!in_array($exm->topic_id,$topic)){
                    array_push($topic,$exm->topic_id);
                }
            }
            $myExercises = $user->myexercises()->where('createdby','=', Auth::user()->id)->whereIn('topic_id',$topic);
        }
        //Fetch data by exerciseset's title.
        if(!empty(request('Title_search'))){
            if(request('Title_operator') === 'like'){
                $myExercises->where('title','LIKE','%'.request('Title_search').'%');
            } else {
                $myExercises->where('title','=',request('Title_search'));                            
            }
        }

        //Fetch Data by created date.
        //dd(request()->all());
        if(!empty(request('start_date'))){
            $startDate = Carbon::parse(request('start_date'))->format('Y-m-d')." 00:00:00";
            $endDate = Carbon::parse(request('end_date'))->format('Y-m-d')." 23:59:59";
            //dd($startDate,$endDate);
            $myExercises->whereBetween('created_at', [$startDate, $endDate]);
        }

        //Sorting Data by order.
        if(request('Sort_search') != '' && request('Sort_search') == 'Descending' ){

            $myExercises->orderBy('title', 'desc');
        } else {
            $myExercises->orderBy('title', 'asc');
        }

        //Fetch Data by Disicipline name.
        if(!empty(request('Curriculum_search'))){

            if(request('Curriculum_search') === 'N/A') {
                $myExercises->where('discipline_id','=',NULL);
            } else {
                $myExercises->whereHas('discipline',function($discipline){
                    if(request('Curriculum_operator') === 'like'){
                        $discipline->where('discipline_name','like','%'.request('Curriculum_search').'%');
                    } else {
                        $discipline->where('discipline_name','=',request('Curriculum_search'));
                    }
                });
            }
        } else {
            $myExercises->with('discipline');
        }

        if(!empty(request('Topic_search'))){
            $topicName= request('Topic_search');
            $topics = Topic::where('topic_name','LIKE','%'.$topicName.'%')->first();
            if($topics){
                //dd($topics);
                if(request('Title_operator') === 'like'){
                    $myExercises->where('topic_id','like','%'.$topics->id.'%');
                } else {
                    $myExercises->where('topic_id','=',$topics->id);
                }
            }
            else{
                $myExercises->where('topic_id','=',NULL);
            }
        }
            //Fetch Data by Grade name.
        if(!empty(request('Grade_search'))){
            if(request('Grade_search') === 'N/A') {
                $myExercises->where('grade_id','=',NULL);
            } else {
                $myExercises->whereHas('grade',function($grade){
                    if(request('Grade_operator') === 'like'){
                        $grade->where('grade_name','like','%'.request('Grade_search').'%');
                    } else {
                        $grade->where('grade_name','=',request('Grade_search'));
                    }
                });
            }
        } else {
            $myExercises->with('grade');
        }
        

        $myExercises->withCount('question');
        $myExercises->withCount('buyers');

       //Filter by Questions count
        if(request('Question_search') != ''){
            $myExercises->having('question_count',request('Question_operator'),request('Question_search'));
        }
        
        //Filter by Buyer count.
        if(request('Buyer_search') != ''){
            $myExercises->having('buyers_count',request('Buyer_operator'),request('Buyer_search'));
        }



        return $myExercises->get();
    }

    /**
     * Prepare by Wc
     *
     * Get Skillcategorties from exercisesset Invision flow( Create exam S2)
     */
    public function getSkillCategories(Request $request)
    {
        //return $request->all();
        // For edit - get selected SkillCategories
        $examSkillCategories=ExamSkillCategories::where('exam_id',request()->getExamID)->select('skill_category_id','skill_count')->get();
        $examId = request()->getExamID;
        $selected_examSkillCategories = array();
        foreach ($examSkillCategories as $examSkillCategorie) {
            array_push ($selected_examSkillCategories, $examSkillCategorie->skill_category_id);
        }

        $questions = Question::whereIn('exercise_id', $request->id)->select('skillcategory_id')->get();
        // Get null skill count
        $questionsNullCount = Question::whereIn('exercise_id', $request->id)->where('skillcategory_id',Null)->count();

        //dd($questions->toArray());

        $skillCatList =  $this->skillData($questions,true,$examId);
        //dd($skillCatList->toArray());
        // $skillCatListId = Skillcategory::whereIn('id',$questions)->where('publish_status','published')->pluck('id')->toArray();
        //return $request->id;
        $exam=Exam::find($request->getExamID);
        $exam->examExercises()->sync($request->id);
        $exam->save();

        // store in session
        $request->session()->put('getSelectedExercisesets', $request->id);
        // $request->session()->put('getSelectedSkillCatList', $skillCatListId);

        return view('exams.Skillcategories_exercise',compact('skillCatList','totalQuestion','questionsNullCount','selected_examSkillCategories','examSkillCategories'))->render();
    }

     /**
     * Prepare by Wc
     *
     * Get Skillcategorties Filtered data.
     */
    public function getskillFilter(Request $request){
        //dd($request->all());
        $examId = request()->getexamId;
        $exercise_ids = explode(',',$request->exercise_id);

        // For edit - get selected SkillCategories
        $examSkillCategories=ExamSkillCategories::where('exam_id',request()->getexamId)->select('skill_category_id','skill_count')->get();

        $selected_examSkillCategories = array();
        foreach ($examSkillCategories as $examSkillCategorie) {
            array_push ($selected_examSkillCategories, $examSkillCategorie->skill_category_id);
        }

        $questions = Question::whereIn('exercise_id',$exercise_ids)->select('skillcategory_id')->get();

        // Get null skill count
        $questionsNullCount = Question::whereIn('exercise_id', $exercise_ids)->where('skillcategory_id',Null)->count();

        $skillCatList = $this->skillData($questions,true,$examId);
        // store in session
        $request->session()->put('getSelectedExercisesets', $request->id);

        return view('exams.Skillcategories_exercise',compact('skillCatList','totalQuestion','questionsNullCount','selected_examSkillCategories','examSkillCategories'))->render();
    }

    //Get Skill categories filterd data.
    public function skillData($questions , $is_count = false,$examId){
        if(request()->has('id')){
            $exe_Ids = request()->id;  //comming in array formate
        }else{
            $exe_Ids = explode(',',request()->exercise_id); //come without array so need to explode
        }
        $skill_cate = Skillcategory::whereIn('id',$questions)->where('publish_status','published');
        $skill_cate->with(['SkillExamCategories'=>function($q) use ($examId){
            $q->where('exam_id',$examId)->select('skill_category_id','skill_count');
        }]);
        if($is_count){
            // Exercises related question count get
            $skill_cate->withCount(['question' => function ($query) use ($exe_Ids){
                $query->whereIn('exercise_id', $exe_Ids);
            }]);
        }
        //Fetch data by exerciseset's title.
        if(!empty(request('Title_search'))){
            if(request('Title_operator') === 'like'){
                $skill_cate->where('skill_category_name','LIKE','%'.request('Title_search').'%');
            } else {
                $skill_cate->where('skill_category_name','=',request('Title_search'));
            }
        }
        //Sorting Data by order.
        if(request('Sort_search') != '' && request('Sort_search') == 'Descending' ){
            $skill_cate->orderBy('skill_category_name', 'DESC');
        } else {
            $skill_cate->orderBy('skill_category_name', 'ASC');
        }
        return $skill_cate->get(); //->sortBy('sort_order');
    }

    /**
     * Prepare by Wc
     *
     * Get Skillcategorties from exercisesset Invision flow( Create exam S3)
     */
    public function getQuestions(Request $request)
    {
        
        // For edit - get selected questions
        $examQuestions = Examquestion::where('exam_id',$request->getExamID)->select('question_id')->get();
        
        $selected_questions = array();
        foreach ($examQuestions as $examQuestion) {
            array_push ($selected_questions, $examQuestion->question_id);
        }

        $skillcate = [];
        foreach($request->skillcat_id as $key=>$skillcat_id){
            
            $skillcate[$skillcat_id == 'NULL' ? 0 : $skillcat_id ]['skill_count'] = $request->noofquestion[$key];
        }
        // dd($skillcate);


        $exam=Exam::find($request->getExamID);
        $exam->examSkillCategories()->sync($skillcate);
        $exam->save();
        $skillCatIds= $request->skillcat_id;
        $noOfQuestion= $request->noofquestion;

        // Total require question
        $totalReqQuestion= array_sum($noOfQuestion);

        $exercisesIds=Session::get('getSelectedExercisesets');

        $skillcatData=array_combine($skillCatIds,$noOfQuestion);
        $no_of_questions = array_values($skillcatData);

        $list_skills=Skill::whereIn('skill_category_id',$skillCatIds)->get();
        $list_skills = $list_skills->unique ();

        $array_of_skills = array();
        foreach ($list_skills as $skill) {
            array_push ($array_of_skills, $skill->id);
        }

        $listquestions1 = $this->questionsFilterData( $skillcatData, $skillCatIds, $array_of_skills,$selectedQusetionId=null,$selected_questions);
        $Uquestions = $listquestions1->unique ();
        // For teacher & learner role OR only Teacher role
        if(Auth::user()->hasRole('Teacher') && Auth::user()->hasRole('Learner') || Auth::user()->hasRole('Teacher')){
            $questionsCollect = collect($Uquestions);
            $questions = $questionsCollect->collapse();
            $questions->all();
            $questionsId = collect($questions)->map(function ($value, $key) {
                return $value->id;
            })->all();

            $jsonArr = array();
            $questionsId = array();
            foreach($questions as $key => $uque){
                // Create final JSON Object
                $jsonArr[] = json_decode($uque->paramRenderQuestion(),TRUE);
                array_push ($questionsId, $uque['id']);
                if(isset($selected_questions)){
                    if(in_array($uque->id, $selected_questions)){
                        $jsonArr[$key]['checked_id'] = "checked";
                    }
                }
            }
            $finalJsonObj = json_encode($jsonArr,TRUE);

            $questionsId=implode(',',$questionsId);
            $skillCatIds=implode(',',$skillCatIds);
            $exercisesIds=implode(',',$exercisesIds);
            $array_of_skills=implode(',',$array_of_skills);

            return view('exams.selectquestions',compact('questions','finalJsonObj','totalReqQuestion','skillCatIds','exercisesIds','array_of_skills','questionsId','selected_questions'))->render();
        }else{
            // Only for Learner Role.
            $exam_Id=$request->getExamID;
            $getExam = Exam::find($exam_Id);
            $data=[];
            $data['examtype'] = 'practice';
            if($getExam['title'] == ''){
                $data['title'] = 'Exam-'.time();
            }
            $data['isavailable'] = 'N';
            $data['teacheruser_id'] = Auth::user()->id;
            $exam = Exam::find($exam_Id);
            $exam->fill($data);
            $exam->save();
            // Delete old question
            $examquestions = Examquestion::where('exam_id',$exam_Id)->delete();
            $mark=1;    // each question mark default.
            $i = 0;     // For shorting.
            foreach ($Uquestions as $key => $uquestion) {
                foreach ($uquestion as $skey => $val) {
                    $i++;
                    $examquestions = new Examquestion;
                    $examquestions->exam_id = $exam_Id;
                    $examquestions->question_id = $val->id;
                    $examquestions->points = $mark;
                    $examquestions->sort_order = $i;
                    $examquestions->save ();
                }
            }
            //return redirect()->route('exams.exam.index');
            return "true";
        }
    }

    // Question filter
    public function getQuestionsByFilter(Request $request){
        // For edit - get selected questions
        $examQuestions = Examquestion::where('exam_id',$request->getexamId)->select('question_id')->get();
        $selected_questions = array();
        foreach ($examQuestions as $examQuestion) {
            array_push ($selected_questions, $examQuestion->question_id);
        }
        $skillCatIds= explode(",",$request->skillcat_id);
        $noOfQuestion= explode(",",$request->noofquestion);
        $skillcate = [];
        foreach($skillCatIds as $key=>$skillcat_id){
            $skillcate[$skillcat_id]['skill_count'] = $request->noofquestion[$key];
        }
        $exam=Exam::find($request->getexamId);
        $exam->examSkillCategories()->sync($skillcate);
        $exam->save();

        //conflict code check this
        $selectedQusetionId= array_map('intval',explode(",",$request->selectedQuestionId));
        $exercisesIds=Session::get('getSelectedExercisesets');
        $skillcatData=array_combine($skillCatIds,$noOfQuestion);

        $no_of_questions = array_values($skillcatData);

        $list_skills=Skill::whereIn('skill_category_id',$skillCatIds)->get();
        $list_skills = $list_skills->unique ();

        $array_of_skills = array();
        foreach ($list_skills as $skill) {
            array_push ($array_of_skills, $skill->id);
        }

        $listquestions1 = $this->questionsFilterData( $skillcatData, $skillCatIds, $array_of_skills,$selectedQusetionId,$selected_questions);
        $Uquestions = $listquestions1->unique ();
        $questionsCollect = collect($Uquestions);
        $questions = $questionsCollect->collapse();
        $questions->all();
        $questionsId = collect($questions)->map(function ($value, $key) {
             return $value->id;
        })->all();

        //$questionIds = json_encode($questionsId);

        $jsonArr = array();
        $questionsId = $selectedQusetionId;
        foreach($questions as $key =>  $uque){
            // Create final JSON Object
            $jsonArr[] = json_decode($uque->paramRenderQuestion(),TRUE);
            // For checked question
            if(isset($selected_questions)){
                if(in_array($uque->id, $selected_questions)){
                    $jsonArr[$key]['checked_id'] = "checked";
                }
            }
        }
        $finalJsonObj = json_encode($jsonArr,TRUE);

        $questionsId=implode(',',$questionsId);
        $skillCatIds=implode(',',$skillCatIds);
        $exercisesIds=implode(',',$exercisesIds);
        $array_of_skills=implode(',',$array_of_skills);

        return view('exams.selectquestions',compact('questions','finalJsonObj','totalReqQuestion','skillCatIds','exercisesIds','array_of_skills','questionsId','selected_questions'))->render();
    }

    /**
     * Develp By WC
     *
     * Get filtered data
     *
     */
    public function questionsFilterData( $skillcatData,$skillCatIds, $array_of_skills,$selectedQusetionId=null,$selected_questions){

        //dd( $skillcatData,$skillCatIds, $array_of_skills,$selectedQusetionId,$selected_questions);
        $exercisesIds=Session::get('getSelectedExercisesets');
        $questionsData = collect();

        foreach($skillcatData as $key=>$skillc)
        {
            $questionsList = Question::whereIn('exercise_id',$exercisesIds)
            ->where('json_details', '<>', null);

            if(count($selected_questions) > 0){
                $questionsList->whereIn('id',$selected_questions);
            }

            // For no link & link qustion data
            if($key == 'NULL'){
                $questionsList->whereNull('skillcategory_id');
            } else{
                $questionsList->where('skillcategory_id', $key);
            }

            if($selectedQusetionId != ''){
                $questionsList->whereIn('id',$selectedQusetionId);
            }else{
                $questionsList->orderByRaw("RAND()")->limit($skillc);
            }

            //Fetch data by questionsData's questions.
            if(!empty(request('Details_search'))){
                if(request('Details_operator') === 'like'){
                    $questionsList->where('details','LIKE','%'.request('Details_search').'%');
                } else {
                    $questionsList->where('details','=',request('Details_search'));
                }
            }

            //Sorting Data by order.
            if(request('Sort_search') != '' && request('Sort_search') == 'Descending' ){
                $questionsList->orderBy('details', 'DESC');
            } else {
                $questionsList->orderBy('details', 'ASC');
            }

            //Fetch data by min-time.
            if(request('Min-time_search') != ""){
                $questionsList->where('mintime',request('Min-time_operator'),request('Min-time_search'));
            }

            //Fetch data by Max-time.
            if(request('question-Max-time_search') != ""){
                $questionsList->where('maxtime',request('question-Max-time_operator'),request('question-Max-time_search'));
            }

            //Fetch data by Difficuly.
            if(!empty(request('Difficuly_search'))){
                $questionsList->where('difficultylevel','=',request('Difficuly_search'));
            }
            $questionsData->push($questionsList->get());
            // Collection Sorting Data by order.
            if(request('Sort_search') != '' && request('Sort_search') == 'Descending' ){
                $questionsData->sortByDesc('details');
            } else {
                $questionsData->sortBy('details');
            }
        }
        //dd($questionsData->toArray());
        return $questionsData;
        //return $questionsData->get();
    }

    /**
     * Prepare by Wc
     *
     * Get Selected Questions from Questions Invision flow( Create exam S4)
     */
    public function getSelectedQuestions(Request $request)
    {
        //return request()->all();
        $exam = Exam::findOrFail($request->getExamID);
        $examquestions = Examquestion::where('exam_id',$request->getExamID)
        ->whereNotIn('question_id',request()->id)
        ->delete();

        // $examquestions = new Examquestion();
        // $examquestions->question_id = $request->question_id;
        // $examquestions->exam_id = $request->getExamID;
        // $examquestions->save();

        $question_id = $request->id;
        $questions = Question::whereIn('id', $question_id)->get ();

        // Create final JSON Object
        $jsonArrSelQue = array();
        foreach ($questions as $key => $question) {
          //$jsonArrSelQue[] = json_decode($question->paramRenderQuestion(),TRUE);
          $mark= Examquestion::select ('points')->where('question_id', '=', $question->id)->where('exam_id', '=', $request->getExamID)->first();
          $jsonArrSelQue[$key] = json_decode($question->paramRenderQuestion(),TRUE);
          if($mark != ''){
              $jsonArrSelQue[$key]['Questions'][0]['mark'] = $mark->points;
          }
        }

        //dd($jsonArrSelQue);
        $finalJsonObjSelQue = json_encode($jsonArrSelQue);

        return view('exams.exam_details',compact('questions','finalJsonObjSelQue','exam'))->render();
    }

    /**
     * Get one more question and added it to create exam question list.
     * 
     */
    public function addedNewQuestion(Request $request){
        $exercise_id = explode(",",request('exercise_id'));
        $skill_cat_id = explode(",",request('skill_cat_id'));
        $skill_id = explode(",",request('skill_id'));
        $question_id = explode(",",request('question_id'));
        $skill_cat=str_replace("",null,$skill_cat_id);

        $questionsObj = Question::whereNotIn('id',$question_id)->whereIn('exercise_id',$exercise_id);
        // For no link & link qustion data
        $SkillCat = [];
        $isNullCat = false;
        foreach($skill_cat_id as $key=>$skillc)
        {
            if($skillc == 'NULL'){
                $isNullCat = true;
            } else{
                array_push($SkillCat,$skillc);
            }
        }
        if($isNullCat == true && !empty($SkillCat)){
            $questionsObj->where(function($q) use ($skill_cat){
                $q->whereNull('skillcategory_id');
                $q->orWhereIn('skillcategory_id',$skill_cat);
            });
        }elseif($isNullCat == true && empty($SkillCat)){
            $questionsObj->whereNull('skillcategory_id');
        }else{
            $questionsObj->whereIn('skillcategory_id',$SkillCat);
        }
        $questions = $questionsObj->get();

        $jsonArr = array();
        foreach($questions as $uque){
            // Create final JSON Object
            $jsonArr[] = json_decode($uque->json_details,TRUE);
        }

        return $jsonArr;

    }

    /**
     * Prepare by Wc
     *
     * Create Exam Invision flow( Create exam Final Step)
     *
     * store
     */
    public function store (Request $request,$classID)
    {
        //dd(request()->all(),$classID);
        try {

            $examquestions = Examquestion::where('exam_id',$request->exam_id)->delete();
            //->get();

            //return $classID;
            $data = $this->getData ($request);
            if ($request->has ('isavailable')) {
                $data['isavailable'] = 'Y';
            } else {
                $data['isavailable'] = 'N';
            }

            $data['maxpoints'] = array_sum($data['mark']);
            $data['teacheruser_id'] = Auth::user()->id;
            //return $request->exam_id;
                //$exam = Exam::create ($data);
                $exam = Exam::find($request->exam_id);
                $exam->fill($data);
                $exam->save();

                //return $exam;

                $i = 0;
                $list_questions = $request->mark;

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
            if(session()->has ('getSelectedSkillCatList')) {
                $list_skillcategories=session()->get('getSelectedSkillCatList');
                $this->store_selection($list_skillcategories ,'skillcategories',$exam);
            }

            if(session()->has ('getSelectedExercisesets')) {
                    $list_exercises=session()->get('getSelectedExercisesets');
                    $this->store_selection($list_exercises ,'exercisesets',$exam);
            }

            if(session()->has ('getSelectedDiscipline')) {
                $list_disciplines=session()->get('getSelectedDiscipline');
                $this->store_selection($list_disciplines ,'disciplines',$exam);
            }

            if(isset($request->action) && $request->action != "class"){
                return redirect ()->route ('exams.exam.index')
                    ->with ('success_message', 'Exam was successfully Updated!');
            }else{
                if($classID !='Null'){

                    return redirect ()->route ('courseclasses.courseclass.addexamtoclass',$classID)
                    ->with ('success_message', 'Exam was successfully added!');
                } else {

                    return redirect ()->route ('exams.exam.index')
                    ->with ('success_message', 'Exam was successfully added!');
                }
            }
            //return redirect ()->route ('exams.exam.index')
                //->with ('success_message', 'Exam was successfully added!');

        } catch (Exception $exception) {
            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Prepare by Wc
     *
     * Export to PDF
     *
     * store
     */
    public function exportExam($id) {
        $exam = Exam::findOrFail ($id);

        $teacherusers = Auth::user ();
        if (session ()->has ('norefresh')) session ()->pull ('norefresh');

        $slected_question_id = Examquestion::select ('question_id')->where ('exam_id', '=', $id)->get ()->toArray ();
        $slected_question = Question::whereIn ('id', $slected_question_id)->with('examquestion')->get ();

        $questions = $slected_question;

        // Create final JSON Object
        $jsonArrSelQue = array();
        foreach ($questions as $key=> $question) {
            $mark= Examquestion::select ('points')->where('question_id', '=', $question->id)->where('exam_id', '=', $id)->first();
            $jsonArrSelQue[$key] = json_decode($question->paramRenderQuestion(),TRUE);
            $jsonArrSelQue[$key]['Questions'][0]['mark'] = $mark->points;
        }
        
        
        $finalJsonObjSelQue = json_encode($jsonArrSelQue,TRUE);
        // dd($finalJsonObjSelQue);


        //$pdf = PDF::loadView('exams.exportExam', compact ('exam', 'teacherusers', 'questions','finalJsonObjSelQue','slected_question_id'));
        //return $pdf->download($exam->title.'.pdf');

        // trying to render
        // $view = view ('exams.exportExam', compact ('exam', 'teacherusers', 'questions','finalJsonObjSelQue','slected_question_id'))->render();
        // dd($view);

        return view ('exams.exportExam', compact ('exam', 'teacherusers', 'questions','finalJsonObjSelQue','slected_question_id'))->render();
    }

    public function exportExamPost($id,Request $request) {
  
        $exam = Exam::findOrFail ($id);

        $question_img=$request->htmlSrcData;
        $totalQuestion=$request->totalQuestion;
        $totalduration=$request->totalduration;
        $schoolName=$request->schoolName;
        $teacherName=$request->teacherName;
        $learnerName=$request->learnerName;
        $totalMarksHidden=$request->totalMarksHidden;

        $pdf = PDF::loadView('exams.pdf', compact ('exam', 'question_img','totalQuestion','totalduration','schoolName','teacherName','learnerName','totalMarksHidden'));
        return $pdf->download($exam->title.'.pdf');

        // return view ('exams.pdf', compact ('exam', 'question_img','totalQuestion','totalduration','schoolName','teacherName','learnerName','totalMarksHidden'));
    }

    // Update status
    public function updateExamStatus(){
        $cStatus=request()->mode;
        $examId=request()->examid;
        $exam = Exam::where('teacheruser_id',Auth::user()->id)->where('id',$examId)->first();
        if($cStatus == "true"){
            $exam->update(['isavailable' => 'Y']);
        }else{
            $exam->update(['isavailable' => 'N']);
        }
        //return redirect ()->route ('exams.exam.index')->with ('success_message', Lang::get('exam.exam_was_added'));
        return 'true';
    }
}
