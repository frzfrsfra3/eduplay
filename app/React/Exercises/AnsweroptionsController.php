<?php

namespace App\React\Exercises;

use App\Models\Question;
use App\Models\Answeroption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class AnsweroptionsController extends Controller
{

    /**
     * Display a listing of the answeroptions.
     ** return Illuminate\View\View
     */
    public function index()
    {
        $answeroptions = Answeroption::paginate(25);

        return response()->json($answeroptions,201);
    }

    /**
     * Display the specified answeroption.
     ** param int $id
     ** return Illuminate\View\View
     */
    public function show($id)
    {
        $answeroption = Answeroption::findOrFail($id);

        return response()->json($answeroption,201);
    }

    /**
     * Show the form for creating a new answeroption.
     ** return Illuminate\View\View
     */
    public function create()
    {
        $questions = Question::pluck('details','id')->all();
        
        return view('answeroptions.create', compact('questions'));
    }

    /**
     * Store a new answeroption in the storage.
     ** param Illuminate\Http\Request $request
     ** return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {


         $data = $this->getData($request);

        $answer=   Answeroption::create($data);

        return $answer;


    }


    /**
     * Show the form for editing the specified answeroption.
     ** param int $id
     ** return Illuminate\View\View
     */
    public function edit($id)
    {
        $answeroption = Answeroption::findOrFail($id);
        $questions = Question::pluck('id','id')->all();

        return view('answeroptions.edit', compact('answeroption','questions'));
    }


    /**
     * Update the specified answeroption in the storage.
     ** param  int $id
     * param Illuminate\Http\Request $request
     ** return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

            
            $data = $this->getData($request);
            
            $answeroption = Answeroption::findOrFail($id);
            $answeroption->update($data);


        return response()->json($answeroption,200);


    }

    public function edit_answer($id)
    {
        $answeroption = Answeroption::findOrFail($id);
        $questions = Question::pluck('id','id')->all();

        return view('answeroptions.form_answer', compact('answeroption','questions'));
    }

    public function update_answer($id, Request $request)
    {
        try {

            $data = $this->getData($request);

            $answeroption = Answeroption::findOrFail($id);
            $answeroption->update($data);
            $up=1;

            return redirect()->route('answeroptions.answeroption.single_answer',compact('id','up'));

        } catch (Exception $exception) {

            return ('answeroptions.unexpected_error');
        }
    }
    public function create_answer()
    {

        $answeroption = null;

        return view('answeroptions.form_answer', compact('answeroption'));
    }
    public function store_answer(Request $request)
    {
        try {

            $data = $this->getData($request);

            $id =Answeroption::create($data)->id;
            $up=2;
             return redirect()->route('answeroptions.answeroption.single_answer',compact('id','up'));

        } catch (Exception $exception) {

            return ('answeroptions.unexpected_error');
        }
    }

    public function single_answer($id)
    {

        $answer = Answeroption::with('question')->findOrFail($id);
        return view('answeroptions.single_answer', compact('answer'));
    }
    /**
     * Remove the specified answeroption from the storage.
     ** param  int $id
     ** return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {

            $answeroption = Answeroption::findOrFail($id);
            $answeroption->delete();


        return  response()->json(null, 204);


    }


    /**
     * Get the request's data from the request.
     ** param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'question_id' => 'required',
            'answer_type' => 'required',
            'details' => 'required',
            'iscorrect' => 'boolean',
            'sort_order' => 'required|numeric|min:0|max:100',
        ];

        
        $data = $request->validate($rules);


      //  $data['iscorrect'] = $request->has('iscorrect');

        return $data;
    }

}
