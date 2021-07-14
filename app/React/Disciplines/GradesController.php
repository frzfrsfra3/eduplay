<?php

namespace App\React\Disciplines;

use App\Models\Curriculum_gradelist;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class GradesController extends Controller
{

    /**
     * Display a listing of the grades.
     *
     *
     */
    public function index()
    {
        $grades = Grade::with('curriculum_gradelist')->paginate(25);

        return view('grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new grade.
     *
     *
     */
    public function create()
    {
        $curriculum_gradelists = Curriculum_gradelist::pluck('curriculum_gradelist_name','id')->all();
        
        return view('grades.create', compact('curricula'));
    }

    /**
     * Store a new grade in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Grade::create($data);

            return redirect()->route('grades.grade.index')
                             ->with('success_message', 'Grade was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified grade.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $grade = Grade::with('curriculum')->findOrFail($id);

        return view('grades.show', compact('grade'));
    }

    /**
     * Show the form for editing the specified grade.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $curriculum_gradelist = Curriculum_gradelist::pluck('curriculum_gradelist_name','id')->all();

        return view('grades.edit', compact('grade','curricula'));
    }

    /**
     * Update the specified grade in the storage.
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
            
            $grade = Grade::findOrFail($id);
            $grade->update($data);

            return redirect()->route('grades.grade.index')
                             ->with('success_message', 'Grade was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified grade from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $grade = Grade::findOrFail($id);
            $grade->delete();

            return redirect()->route('grades.grade.index')
                             ->with('success_message', 'Grade was successfully deleted!');

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
            'grade_name' => 'required|string|min:1|max:250',
            'curriculum_gradelist_id' => 'nullable',
            'createdby' => 'required|numeric|min:-2147483648|max:2147483647',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
