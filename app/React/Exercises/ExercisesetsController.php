<?php

namespace App\React\Exercises;

use App\Models\Exercisesetbuyer;
use App\Models\Passage;
use App\Models\Skill;
use App\Models\Question;
use App\Models\Grade;
use App\Models\Language;
use App\Models\Curriculum;
use App\Models\Discipline;
use App\Models\Exerciseset;
use App\Models\Answeroption;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Models\SkillCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Events\ExerciseSetCreated;
use App\Http\Traits\AddXppoint;
use Log;

//use Exception;

    class ExercisesetsController extends Controller
{
    use AddXppoint;
    public function __construct()
    {
    //    $this->middleware('auth');
    }
    /**
     * Display a listing of the exercisesets in the Public Library.
     * returns index view
     **/
    public function index()
    {
        // return excercisesets that are published to the public library
        if(isset($_GET['searchkey'])){ $name = $_GET['searchkey'];}else {$name='';}
        $exercisesets = Exerciseset::with('discipline','grade','language')
            ->where([['title', 'like', '%'.$name.'%'],['publish_status', 'like', 'public']])
            ->orwhere([['description', 'like', '%'.$name.'%'],['publish_status', 'like', 'public']])->paginate(2);

        return response()->json($exercisesets,201);
        //return view('exercisesets.index', compact('exercisesets'));
    }

    /**
     * Display the specified exerciseset with all questions in preparation for editing.
     */
    public function show($id)
    {  $this->middleware('auth');

        $disciplines = Discipline::select('discipline_name','id','curriculum_gradelist_id')->get();
        $languages = Language::select('language','id')->get();
        $grades = Grade::select('grade_name','id','curriculum_gradelist_id')->get();


        $exerciseset = Exerciseset::with('question','question.answeroptions')->findOrFail($id);
        $exerciseset['disciplines']=$disciplines;

        $exerciseset['grades']=$grades;
        $exerciseset['languages']=$languages;
       // $passages=$exerciseset->passages()->get();
        $questions = Question::where('exercise_id','=',$id)->paginate(6);

        return response()->json($exerciseset,201);
        //return view('exercisesets.show', compact('exerciseset','question' ,'ispublic'))->nest('nestquestion','questions/exercise_question', compact('questions' ,'passages'));
    }

        /**
         * Store a new exerciseset in the storage.
         */
        public function store(Request $request)
        {
            try {

                $data = $this->getData($request);

                if (!array_key_exists('publish_status', $data)) {
                    $data['publish_status']='private';
                }

                $ispublic=0;
                $pid=Exerciseset::create($data);
                $id=$pid->id;

             //   event(new ExerciseSetCreated($pid));
            //    $this->add_xp_point(Auth::user ()->id ,'createexercise');
               // return redirect()->route('exercisesets.exerciseset.show',compact('id' ,'ispublic'))
                  //  ->with('success_message', 'Exerciseset was successfully added!');
            return $pid;
            } catch (Exception $exception) {

                return back()->withInput()
                    ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
            }
        }


    public function search($key)
    {
        $exercisesets = Exerciseset::with('discipline','grade','language')->where('title','like','%'.$key.'%')->paginate(25);
        return view('exercisesets.index', compact('exercisesets'));
    }

    /**
     * Display a listing of the exercisesets in the Private Library.
     * returns private view
     **/
    public function listprivatelib(){
        //list the exercisesets createdby the user or bought by the user (exercisesetbuyers)
        if (Auth::user()) {

            if(isset($_GET['searchkey'])){ $name = $_GET['searchkey'];}else {$name='';}

        $user=Auth::user ();
            $myexercises = $user->myexercises()
            ->where([['title', 'like', '%'.$name.'%'],['createdby','=',$user->id]])
            ->orwhere([['description', 'like', '%'.$name.'%'],['createdby','=',$user->id]])->get();
            $exercisesbuy=$user->exercises;


        $myexercises->unique ();
            $exercisesbuy->unique ();

        return view('exercisesets.private', compact('myexercises','exercisesbuy'));
    }
    else
        {
            return view('auth.login');
        }
    }
    /**
     * Show the form for creating a new exerciseset.
     */
    public function create()
    {
        $disciplines = Discipline::pluck('discipline_name','id')->all();
        $languages = Language::pluck('language','id')->all();

        $grades = Grade::where('id','=',-1)->pluck('grade_name','id');


        return view('exercisesets.create', compact('disciplines','languages' ,'grades') );
    }

    /**
     * Import form is shown to paste the questions content inside the Editor and specify parameters
     */
    public function importform($id)
    {
        $exerciseset = Exerciseset::with('discipline','grade','language')->findOrFail($id);
        return view('exercisesets.importform', compact('exerciseset'));
    }

    // import is the action of the import form, it converts content in json that is then converted into onjects saved in the DB
    public function import($id ,Request $request)
    {

        $json = $request->input ('jsonString');
        $tags='';


        $data=json_decode($json);
        $difficulty_level = array('easy', 'medium', 'hard');
        foreach ($data as $obj){

            $question=new Question();
            $question-> exercise_id=$id;
            $qu=str_replace('&lt;','<',$obj->content);
            $qu=str_replace('&gt;','/>',$qu);
            $question->details=$qu." ";
            $question->questiontype='richtext';
            $question->maxtime=60;
            $at=count($obj->Attrs);

                for ($j=0 ;$j < $at ;$j++){

                    switch ($obj->Attrs[$j]->name)
                        {
                            case ('T'): $question->maxtime=$obj->Attrs[$j]->value;break;
                            case ('D'): if ((in_array($obj->Attrs[$j]->value, $difficulty_level))){$question->difficultylevel=$obj->Attrs[$j]->value;} else {$question->difficultylevel='easy';}break;
                            case ('H'): $question-> hint =$obj->Attrs[$j]->value;break;
                            case ('tag'):$tags=$obj->Attrs[$j]->value; break;
                        }
                }

            $question->save();
            $qid=$question->id;
            //add tags to the taggeble system
            if(strlen($tags)>0) {$question->tag( $tags);}

            $nbr=count($obj->Ans);
            for($i = 0; $i < $nbr; $i++) {
                $answer=new Answeroption();
                $answer->details = $obj->Ans[$i]->content;
                $answer->answer_type = 'richtext';
                if (count($obj->Ans[$i]->Attrs) > 0) {
                    $answer->iscorrect = 1;
                } else {
                    $answer->iscorrect = 0;
                }
                $answer->question_id = $qid;
                $answer->sort_order = $i+1;
                $answer->save();
            }
        }
        $ispublic=0;
        $exerciseset = Exerciseset::with('discipline','grade','language')->findOrFail($id);
        $questions = Question::with('skill','skillcategory','exercise','answeroptions')->where('exercise_id','=',$id)->paginate(6);
        return view('exercisesets.show', compact('exerciseset','question'))->nest('nestquestion','questions/exercise_question', compact('questions'));
    }
    /**
     * Display the specified exerciseset summary in preparation for practicing or generating an exam.
     */
    public function summary($id , $ispublic)
    {
      //  $this->middleware('auth');
        $exerciseset = Exerciseset::with('discipline','grade','language')->findOrFail($id);

        $userrate=0;
        if (Auth::user() ) {
        if (        $exerciseset->find( Auth::user() ) ) {
            $userrate= $exerciseset->find( Auth::user() )->rating;
        } }

        return view('exercisesets.summary', compact('exerciseset' ,'userrate' ,'ispublic'));
    }



    public function addrate(Request $request){

        $user = Auth::user ();
        $id= $request->id;
        $rate =$request->value;
        $exerciseset = Exerciseset::findorfail($id);
        $ratingauth=$exerciseset->find( $user);
        if (!$ratingauth)  {

        $rating = $exerciseset->rating([
            'title' => '',
            'body' => '',
            'rating' => $rate,
        ], $user);

        }
        else
        {
            $rating = $exerciseset->updateRating($ratingauth->id, [

                'rating' =>  $rate,
            ]);
        }

        return response()->json($exerciseset->find( $user)->rating);
    }

    public function addreview(Request $request){
        $user = Auth::user ();
        $id= $request->id;
        $rate =$request->value;
        $title=$request->title;
        if ( $title ==null) $title='';

        $comment=$request->comment;
        if ( $comment ==null) $comment='';


        $exerciseset = Exerciseset::findorfail($id);
        $ratingauth=$exerciseset->find( $user);
        if (!$ratingauth)  {

            $rating = $exerciseset->rating([
                'title' => $title,
                'body' => $comment,
                'rating' => $rate,
            ], $user);

        }
        else
        {
            $rating = $exerciseset->updateRating($ratingauth->id, [
                'title' => $title,
                'body' => $comment,
                'rating' =>  $rate,
            ]);
        }

        return response()->json($ratingauth->id);

    }



    public function listofquestion ($exercise_id ,Request $request) {

        $exercise=Exerciseset::where('id','=',$exercise_id)->where('publish_status', '=', 'public')->first();
        $exercise=Exerciseset::where('id','=',$exercise_id)->first();

        $questions=$exercise->question()->paginate(5);


        return view ('questions.exercise_question_public',compact ('questions'));
    }



    /**
     * Show the form for editing the specified exerciseset.
     */
    public function edit($id)
    {if (Auth::user ()) {
        $exerciseset = Exerciseset::findOrFail($id);

        $disciplines = Discipline::pluck('discipline_name','id')->all();
        if($exerciseset->discipline_id){
        $discipline=Discipline::findorfail($exerciseset->discipline_id);
             $grade=$discipline->curriculum_gradelist->grades;
            $grades = $grade->pluck('grade_name','id');
        }
        else      {$grades =null;}

        $languages = Language::pluck('language','id')->all();

        return view('exercisesets.edit', compact('exerciseset','curricula','disciplines','grades','skillCategories','languages'));


        }
        return view ('auth.login');
    }


    public function savetext(Request $request)
    {
        try {

            $data = $this->getData($request);
            $pid=Exerciseset::create($data);
            $id=$pid->id;
            $ispublic=0;
            return redirect()->route('exercisesets.exerciseset.show',compact('id' ,'ispublic'))
                ->with('success_message', 'Exerciseset was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }
    /**
     * Update the specified exerciseset in the storage.
     */
    public function update($id, Request $request)
    {

            
            $data = $this->getData($request);

         //   dd($request);
            $exerciseset = Exerciseset::findOrFail($id);
            $exerciseset->update($data);
        //    $exerciseset->tag(explode(',', $request->tags));

          //  return redirect()->route('exercisesets.exerciseset.show',compact('id' ,'ispublic'))
              //               ->with('success_message', 'Exerciseset was successfully updated!');
            return response()->json($exerciseset,200);

    }



    /**
     * Remove the specified exerciseset from the storage.
     */
    public function destroy($id)
    {

            $exerciseset = Exerciseset::findOrFail($id);

            $exerciseset->delete();
        return  response()->json(null, 204);

    }

    public function addtomylibrary ($id){

        try {

            $this->middleware ('auth');
            $exercisesetbuyers = New Exercisesetbuyer;
            $exercisesetbuyers->user_id = Auth::user ()->id;
            $exercisesetbuyers->exerciseset_id = $id;
            $exercisesetbuyers->save ();
            Storage::disk ('local')->append ('addddddd.txt', 'done');
            return "done";

         }catch (Exception $exception) {
            Storage::disk ('local')->append ('addddddd.txt', $exception);
            return $exception;
            }
    }

    public function getgrades ($discipline_id){

        $discipline=Discipline::findorfail($discipline_id);


        $grade=$discipline->curriculum_gradelist->grades;

        return Response($grade);

    }



    public function show1 ($discipline_id){

        $discipline=Discipline::findorfail($discipline_id);
          dd($discipline);

        return "0";
    }


    /**
     * Get the request's data from the request.
     */
    protected function getData(Request $request)
    {
        $rules = [
            'title' => 'required|string|min:1|max:250',
            'discipline_id' => 'nullable',
            'grade_id' => 'nullable',
            'skill_category_id' => 'nullable',
            'language_id' => 'required|numeric|min:0|max:4294967295',
            'description' => 'required',
            'publish_status' => 'nullable',
            'createdby' => 'required|numeric|min: 0|max:2147483647',
            'price'=>'nullable|numeric|min: 0|max:2147483647',
     
        ];

        $data = $request->validate($rules);
        return $data;
    }




}
