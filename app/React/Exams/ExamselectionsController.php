<?php

namespace App\React\Exams;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\Examselection;
use App\Http\Controllers\Controller;
use Exception;

class ExamselectionsController extends Controller
{

    /**
     * Display a listing of the examselections.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $examselectionsObjects = Examselection::with('exam')->paginate(25);

        return view('examselections.index', compact('examselectionsObjects'));
    }

    /**
     * Show the form for creating a new examselections.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        $exams = Exam::pluck('title','id')->all();

        
        return view('examselections.create', compact('exams'));
    }

    /**
     * Store a new examselections in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            examselection::create($data);

            return redirect()->route('examselections.examselections.index')
                             ->with('success_message', 'Examselections was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified examselections.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $examselections = examselection::with('exam','selection')->findOrFail($id);

        return view('examselections.show', compact('examselections'));
    }

    /**
     * Show the form for editing the specified examselections.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $examselections = examselection::findOrFail($id);
        $exams = Exam::pluck('title','id')->all();


        return view('examselections.edit', compact('examselections','exams'));
    }

    /**
     * Update the specified examselections in the storage.
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
            
            $examselections = examselection::findOrFail($id);
            $examselections->update($data);

            return redirect()->route('examselections.examselections.index')
                             ->with('success_message', 'Examselections was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified examselections from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $examselections = examselection::findOrFail($id);
            $examselections->delete();

            return redirect()->route('examselections.examselections.index')
                             ->with('success_message', 'Examselections was successfully deleted!');

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
            'exam_id' => 'required',
            'selection_id' => 'required',
            'selection_table' => 'required|numeric|min:-2147483648|max:2147483647',
            'isselected' => 'boolean',
     
        ];

        
        $data = $request->validate($rules);


        $data['isselected'] = $request->has('isselected');


        return $data;
    }

}
