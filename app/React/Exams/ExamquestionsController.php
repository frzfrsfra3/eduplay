<?php

namespace App\React\Exams;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Examquestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class ExamquestionsController extends Controller
{

    /**
     * Display a listing of the examquestions.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $examquestions = Examquestion::with ('exam', 'question')->paginate (25);

        return view ('examquestions.index', compact ('examquestions'));
    }

    /**
     * Show the form for creating a new examquestion.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $exams = Exam::pluck ('id', 'id')->all ();
        $questions = Question::pluck ('id', 'id')->all ();

        return view ('examquestions.create', compact ('exams', 'questions'));
    }

    /**
     * Store a new examquestion in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Examquestion::create ($data);

            return redirect ()->route ('examquestions.examquestion.index')
                ->with ('success_message', 'Examquestion was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified examquestion.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $examquestion = Examquestion::with ('exam', 'question')->findOrFail ($id);

        return view ('examquestions.show', compact ('examquestion'));
    }

    /**
     * Show the form for editing the specified examquestion.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $examquestion = Examquestion::findOrFail ($id);
        $exams = Exam::pluck ('id', 'id')->all ();
        $questions = Question::pluck ('id', 'id')->all ();

        return view ('examquestions.edit', compact ('examquestion', 'exams', 'questions'));
    }

    /**
     * Update the specified examquestion in the storage.
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

            $examquestion = Examquestion::findOrFail ($id);
            $examquestion->update ($data);

            return redirect ()->route ('examquestions.examquestion.index')
                ->with ('success_message', 'Examquestion was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified examquestion from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $examquestion = Examquestion::findOrFail ($id);
            $examquestion->delete ();

            return redirect ()->route ('examquestions.examquestion.index')
                ->with ('success_message', 'Examquestion was successfully deleted!');

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
            'exam_id' => 'required',
            'question_id' => 'required',
            'sort_order' => 'nullable|numeric|min:-2147483648|max:2147483647',

        ];


        $data = $request->validate ($rules);


        return $data;
    }

}
