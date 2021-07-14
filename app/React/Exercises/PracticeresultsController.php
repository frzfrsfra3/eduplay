<?php

namespace App\React\Exercises;

use App\Models\Topic;
use App\Models\Question;
use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Models\Answeroption;
use App\Models\Practiceresult;
use App\Http\Controllers\Controller;
use Exception;

class PracticeresultsController extends Controller
{

    /**
     * Display a listing of the practiceresults.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $practiceresults = Practiceresult::with('question','answeroption','topic','exercise')->paginate(25);

        return view('practiceresults.index', compact('practiceresults'));
    }

    /**
     * Show the form for creating a new practiceresult.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        $questions = Question::pluck('param','id')->all();
$answeroptions = Answeroption::pluck('answer_type','id')->all();
$topics = Topic::pluck('topic_name','id')->all();
$exercises = Exercise::pluck('id','id')->all();
        
        return view('practiceresults.create', compact('questions','answeroptions','topics','exercises'));
    }

    /**
     * Store a new practiceresult in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Practiceresult::create($data);

            return redirect()->route('practiceresults.practiceresult.index')
                             ->with('success_message', 'Practiceresult was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified practiceresult.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $practiceresult = Practiceresult::with('question','answeroption','topic','exercise')->findOrFail($id);

        return view('practiceresults.show', compact('practiceresult'));
    }

    /**
     * Show the form for editing the specified practiceresult.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $practiceresult = Practiceresult::findOrFail($id);
        $questions = Question::pluck('param','id')->all();
$answeroptions = Answeroption::pluck('answer_type','id')->all();
$topics = Topic::pluck('topic_name','id')->all();
$exercises = Exercise::pluck('id','id')->all();

        return view('practiceresults.edit', compact('practiceresult','questions','answeroptions','topics','exercises'));
    }

    /**
     * Update the specified practiceresult in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $practiceresult = Practiceresult::findOrFail($id);
            $practiceresult->update($data);

            return redirect()->route('practiceresults.practiceresult.index')
                             ->with('success_message', 'Practiceresult was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified practiceresult from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $practiceresult = Practiceresult::findOrFail($id);
            $practiceresult->delete();

            return redirect()->route('practiceresults.practiceresult.index')
                             ->with('success_message', 'Practiceresult was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request 
     * return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'question_id' => 'required',
            'answeroption_id' => 'required',
            'iscorrect' => 'boolean',
            'topics_id' => 'nullable',
            'exercise_id' => 'nullable',
     
        ];
        
        $data = $request->validate($rules);

        $data['iscorrect'] = $request->has('iscorrect');

        return $data;
    }

}
