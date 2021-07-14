<?php

namespace App\React\User;

use App\Models\User;
use App\Models\Exam;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Userexamanswer;
use App\Http\Controllers\Controller;
use Exception;

class UserexamanswersController extends Controller
{

    /**
     * Display a listing of the userexamanswers.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $userexamanswers = Userexamanswer::with ('user', 'exam', 'question', 'answer')->paginate (25);

        return view ('userexamanswers.index', compact ('userexamanswers'));
    }

    /**
     * Show the form for creating a new userexamanswer.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $users = User::pluck ('id', 'id')->all ();
        $exams = Exam::pluck ('title', 'id')->all ();
        $questions = Question::pluck ('details', 'id')->all ();
        $answers = Answer::pluck ('id', 'id')->all ();

        return view ('userexamanswers.create', compact ('users', 'exams', 'questions', 'answers'));
    }

    /**
     * Store a new userexamanswer in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Userexamanswer::create ($data);

            return redirect ()->route ('userexamanswers.userexamanswer.index')
                ->with ('success_message', 'Userexamanswer was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified userexamanswer.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $userexamanswer = Userexamanswer::with ('user', 'exam', 'question', 'answer')->findOrFail ($id);

        return view ('userexamanswers.show', compact ('userexamanswer'));
    }

    /**
     * Show the form for editing the specified userexamanswer.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $userexamanswer = Userexamanswer::findOrFail ($id);
        $users = User::pluck ('id', 'id')->all ();
        $exams = Exam::pluck ('title', 'id')->all ();
        $questions = Question::pluck ('details', 'id')->all ();
        $answers = Answer::pluck ('id', 'id')->all ();

        return view ('userexamanswers.edit', compact ('userexamanswer', 'users', 'exams', 'questions', 'answers'));
    }

    /**
     * Update the specified userexamanswer in the storage.
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

            $userexamanswer = Userexamanswer::findOrFail ($id);
            $userexamanswer->update ($data);

            return redirect ()->route ('userexamanswers.userexamanswer.index')
                ->with ('success_message', 'Userexamanswer was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified userexamanswer from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $userexamanswer = Userexamanswer::findOrFail ($id);
            $userexamanswer->delete ();

            return redirect ()->route ('userexamanswers.userexamanswer.index')
                ->with ('success_message', 'Userexamanswer was successfully deleted!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
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
            'answerdate' => 'required|date_format:j/n/Y g:i A',
            'user_id' => 'required',
            'exam_id' => 'required',
            'class_id ' => 'required',
            'attempt_number' => 'required|numeric|min:-2147483648|max:2147483647',
            'question_id' => 'required',
            'answer_id' => 'required',
            'timespent' => 'required|numeric|min:-2147483648|max:2147483647',
            'iscorrect' => 'required',
            'teachermark' => 'required|numeric|min:-2147483648|max:2147483647',
            'pointsgained' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'gameid' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'user_agent' => 'nullable|numeric',
            'match_uid' => 'nullable|numeric',
            'match_datetime' => 'required|date_format:j/n/Y g:i A',
        ];


        $data = $request->validate ($rules);


        return $data;
    }

}
