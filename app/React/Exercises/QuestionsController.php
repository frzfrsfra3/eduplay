<?php

namespace App\React\Exercises;

use App\Models\Answeroption;
use App\Models\Passage;
use App\Models\Skill;
use App\Models\Question;
use App\Models\Exerciseset;
use Illuminate\Http\Request;
use App\Models\Skillcategory;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use Log;
use Illuminate\Support\Facades\Storage;


//use Exception;

class QuestionsController extends Controller
{

    /**
     * Display a listing of the questions.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $questions = Question::with ('answeroptions')->paginate (4);
        return response()->json($questions,201);
       // return view ('questions.index', compact ('questions'));
    }

    /**
     * Display the specified question.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $question = Question::findOrFail ($id);
        $skills = Skill::select('skill_name', 'id','grade_id','skill_category_id')->get();
        $skillcategories = Skillcategory::select('skill_category_name', 'id')->get();
        $question['skills']=$skills;
        $question['skillcategories']=$skillcategories;

        return response()->json($question,201);
       // return view ('questions.show', compact ('question'));
    }


    /**
     * Show the form for creating a new question.
     */
    public function create ()
    {
        $skills = Skill::pluck ('skill_name', 'id')->all ();
        $skillcategories = Skillcategory::pluck ('skill_category_name', 'id')->all ();
        $exercises = Exerciseset::pluck ('title', 'id')->all ();

        return view ('questions.create', compact ('skills', 'skillcategories', 'exercises'));
    }

    /**
     * Store a new question in the storage.
     */
    public function store (Request $request)
    {




            $data = $this->getData ($request);

        $Question=Question::create ($data);

        return $Question;

    }

    public function store_question (Request $request)
    {
        try {
            // Storage::disk ('local')->append ('store_question.txt', $request);
            $data = $this->getData ($request);

            $id = Question::create ($data)->id;
            $question = Question::findOrFail ($id);
            if ($request->tags) {


            }
            if ($request->param) {

                $ext = $request->param->getClientOriginalExtension ();
                $path = Storage::disk ('params')->putFileAs ('', $request->file ('param'), 'param-' . $id . '.' . $ext);
                Question::where ('id', $id)->update (array('param' => $path));

            }
            return redirect ()->route ('questions.question.single_question', compact ('id'));

        } catch (Exception $exception) {

            return ('Unexpected error occurred while trying to process your request!');
        }
    }

    public function single_question ($id)
    {

        $question = Question::with ('skill', 'skillcategory', 'exercise')->findOrFail ($id);

        return view ('questions.single_question', compact ('question'));
    }


    /**
     * Show the form for editing the specified question.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $question = Question::findOrFail ($id);
        $skills = Skill::pluck ('skill_name', 'id')->all ();
        $skillcategories = Skillcategory::pluck ('skill_category_name', 'id')->all ();
        $exercises = Exerciseset::pluck ('title', 'id')->all ();

        return view ('questions.edit', compact ('question', 'skills', 'skillcategories', 'exercises'));
    }

    /**
     * Update the specified question in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update ($id, Request $request)
    {


            $data = $this->getData ($request);
        //    $request->param->store ('param');

            $question = Question::findOrFail ($id);
            $question->update ($data);

        return response()->json($question,200);


    }

    /**
     * Remove the specified question from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {

        $question = Question::findOrFail ($id);
        $question->delete ();

        return  response()->json(null, 204);


    }


    public function update_question ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);
            if ($request->param) {
                $ext = explode ('.', $request->param->getClientOriginalName ());
                //$path = Storage::disk ('params')->putFile('', $request->file('param'));

                $path = Storage::disk ('params')->putFileAs ('', $request->file ('param'), 'param-' . $id . '.' . $ext[1]);
                // $rr= $request->param->store('param');
                // file($rr)->move(public_path("/assets/param"), $rr);
                $data['param'] = $path;
            }


            $question = Question::findOrFail ($id);
            $question->update ($data);
            $question->untag ();
            if ($request->tags) {
                $question->tag (explode (',', $request->tags));
            }
            return ($this->getData ($request));


        } catch (Exception $exception) {


        }
    }

    public function edit_question ($id)
    {
        //session(['key' => $id]);
        try {
            // Auth::user ()->can('update');

            $question = Question::findOrFail ($id);

            $exersise_id = $question->exercise_id;
            $skillcategory_id = $question->skillcategory_id;
            $discipline_id = Exerciseset::where ('id', $exersise_id)->first ();
            $discipline_id = $discipline_id->discipline_id;

            $skillcategories = Skillcategory::where ('discipline_id', '=', $discipline_id)->pluck ('skill_category_name', 'id')->all ();


            $sk_id = Skillcategory::select ('id')->where ('discipline_id', '=', $discipline_id)->get ()->toArray ();

            if ($skillcategory_id == 0) {
                $skills = null;
            } else {
                $skills = Skill::where ('skill_category_id', $skillcategory_id)->pluck ('skill_name', 'id')->all ();
            }


            //   $skills = Skill::pluck ('skill_name', 'id')->all ();
            $passages = Passage::where ('exercise_id', '=', $_POST['sid'])->get ();
            $passages = $passages->pluck ('passage_title', 'id');
            $exercises = Exerciseset::pluck ('title', 'id')->all ();
            return view ('questions.form-exercise', compact ('question', 'skills', 'skillcategories', 'exercises', 'passages'));

        } catch (Exception $e) {
            Storage::disk ('local')->append ('errorajax.txt', $e);
            report ($e);
            return false;
        }
    }

    public function add_question (Request $request)
    {
        try {
            if ($request->has ('sid')) {
                $exersise_id = $request->sid;
            } else {
                $exersise_id = 0;
            }

            $question = null;

            $discipline_id = Exerciseset::where ('id', $exersise_id)->first ();
            $discipline_id = $discipline_id->discipline_id;

            $skillcategories = Skillcategory::where ('discipline_id', '=', $discipline_id)->pluck ('skill_category_name', 'id')->all ();

            $sk_id = Skillcategory::select ('id')->where ('discipline_id', '=', $discipline_id)->get ()->toArray ();

            $skills = Skill::whereIn ('skill_category_id', $sk_id)->pluck ('skill_name', 'id')->all ();
            $exercises = Exerciseset::pluck ('title', 'id')->all ();
            $skills = null;
            $passages = Passage::where ('exercise_id', '=', $exersise_id)->get ();
            $passages = $passages->pluck ('passage_title', 'id');

            return view ('questions.form-exercise', compact ('question', 'skills', 'skillcategories', 'exercises', 'passages'));

        } catch (Exception $e) {
            Storage::disk ('local')->append ('errorajax.txt', $e);
            report ($e);
            return false;
        }
    }

    public function api_question ($id)
    {

        $question = Question::findorfail ($id);
        return view ('questions.single_question_for_api', compact ('question'));

    }


    public function api_answer ($id)
    {

        $answer = Answeroption::findorfail ($id);

        return view ('questions.single_answer_for_api', compact ('answer'));

    }

    public function savequestionasimage ()
    {
        //just a random name for the image file
        $random = rand (10, 10000000);

        //convert the binary to image using file_put_contents
        $savefile = @file_put_contents ("assets/images/output/$random.png", base64_decode (explode (",", $_POST['data'])[1]));
        //if the file saved properly, print the file name
        if ($savefile) {
            echo $random;
        }
    }


    public function getskills ($skill_categories_id)
    {

        $skills = Skill::where ('skill_category_id', '=', $skill_categories_id)->select ('skill_name', 'id')->get ();

        return Response ($skills);

    }

    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData (Request $request)
    {
        $rules = [
            'details' => 'required',
            'param' => 'nullable',
            'questiontype' => 'required',
            'skill_id' => 'nullable',
            'skillcategory_id' => 'nullable',
            'passage_id' => 'nullable',
            'maxtime' => 'required|numeric|min:0|max:300',
            'mintime' => 'required|numeric|min:0|max:300',
            'size' => 'nullable',
            'exercise_id' => 'nullable',
            'difficultylevel' => 'required',
            'hint' => 'nullable',

        ];

        $data = $request->validate ($rules);

        return $data;
    }

}
