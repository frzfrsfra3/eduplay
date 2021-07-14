<?php
namespace App\Http\Controllers\Exercises;
use App\Models\Question;
use App\Models\Answeroption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
class AnsweroptionsController extends Controller {

    /**
     * Display a listing of the answeroptions.
     ** return resources/views/answeroptions/index
     */
    public function index() {
        $answeroptions = Answeroption::with('question')->paginate(25);
        return view('answeroptions.index', compact('answeroptions'));
    }

    /**
     * Show the form for creating a new answeroption.
     ** return resources/views/answeroptions/create
     */
    public function create() {
        $questions = Question::pluck('details', 'id')->all();
        return view('answeroptions.create', compact('questions'));
    }

    /**
     * Store a new answeroption in the storage.
     ** param Request $request
     ** return RedirectResponse | Illuminate/Routing/Redirector
     */
    public function store(Request $request) {
        try {
            $data = $this->getData($request);
            Answeroption::create($data);
            return redirect()->route('answeroptions.answeroption.index')->with('success_message', trans('answeroptions.model_was_added'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => trans('answeroptions.unexpected_error') ]);
        }
    }

    /**
     * Display the specified answeroption.
     ** param int $id
     ** return resources/views/answeroptions/show
     */
    public function show($id) {
        $answeroption = Answeroption::with('question')->findOrFail($id);
        return view('answeroptions.show', compact('answeroption'));
    }

    /**
     * Show the form for editing the specified answeroption.
     ** param int $id
     ** return resources/views/answeroptions/edit
     */
    public function edit($id) {
        $answeroption = Answeroption::findOrFail($id);
        $questions = Question::pluck('id', 'id')->all();
        return view('answeroptions.edit', compact('answeroption', 'questions'));
    }

    /**
     * Update the specified answeroption in the storage.
     ** param  int $id
     * param Illuminate/Http/Request $request
     ** return Illuminate/Http/RedirectResponse | Illuminate/Routing/Redirector
     */
    public function update($id, Request $request) {
        try {
            $data = $this->getData($request);
            $answeroption = Answeroption::findOrFail($id);
            $answeroption->update($data);
            return redirect()->route('answeroptions.answeroption.index')->with('success_message', trans('answeroptions.model_was_updated'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => trans('answeroptions.unexpected_error') ]);
        }
    }

    /**
     * Edit Answer
     * 
     * param int $id
     * return resources/views/answeroptions/form_answer
     */
    public function edit_answer($id) {
        $answeroption = Answeroption::findOrFail($id);
        $questions = Question::pluck('id', 'id')->all();
        return view('answeroptions.form_answer', compact('answeroption', 'questions'));
    }

    /**
     * Update Answer
     * 
     * param int $id
     * param Request $request
     * return Redirect
     */
    public function update_answer($id, Request $request) {
        try {
            $data = $this->getData($request);
            $answeroption = Answeroption::findOrFail($id);
            $answeroption->update($data);
            $up = 1;
            return redirect()->route('answeroptions.answeroption.single_answer', compact('id', 'up'));
        }
        catch(Exception $exception) {
            return ('answeroptions.unexpected_error');
        }
    }

    /**
     * Create Answer
     * 
     * return resources/views/answeroptions_form_answer
     */
    public function create_answer() {
        $answeroption = null;
        return view('answeroptions.form_answer', compact('answeroption'));
    }

    /**
     * Store Answer
     * 
     * param Illuminate/Http/Request $request
     * return Redirect
     */
    public function store_answer(Request $request) {
        try {
            $data = $this->getData($request);
            $id = Answeroption::create($data)->id;
            $up = 2;
            return redirect()->route('answeroptions.answeroption.single_answer', compact('id', 'up'));
        }
        catch(Exception $exception) {
            return ('answeroptions.unexpected_error');
        }
    }

    /**
     * Get Single Answer
     * 
     * param int $id
     * return resources/views/answeroptions/single_answer
     */
    public function single_answer($id) {
        $answer = Answeroption::with('question')->findOrFail($id);
        return view('answeroptions.single_answer', compact('answer'));
    }

    /**
     * Remove the specified answeroption from the storage.
     ** param  int $id
     ** return Illuminate/Http/RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        try {
            $answeroption = Answeroption::findOrFail($id);
            $answeroption->delete();
            $msg = 're_ans' . $id;
            return ($msg);
            return (trans('answeroptions.model_was_deleted'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => trans('answeroptions.unexpected_error') ]);
        }
    }
    
    /**
     * Get the request's data from the request.
     ** param Illuminate/Http/Request/Request $request
     * return array
     */
    protected function getData(Request $request) {
        $rules = ['question_id' => 'required', 'answer_type' => 'required', 'details' => 'required', 'iscorrect' => 'boolean', 'sort_order' => 'required|numeric|min:0|max:100', ];
        $data = $request->validate($rules);
        $data['iscorrect'] = $request->has('iscorrect');
        return $data;
    }
}
