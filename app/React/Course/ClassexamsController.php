<?php

namespace App\React\Course;

use App\Models\Exam;
use App\Models\Classexam;
use App\Models\Courseclass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use Exception;

class ClassexamsController extends Controller
{

    /**
     * Display a listing of the classexams.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $classexams = Classexam::with ('courseclass', 'exam')->paginate (25);

        return response()->json($classexams,201);
    }

    /**
     * Display the specified classexam.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $classexam = Classexam::with ('courseclass', 'exam')->findOrFail ($id);

        return response()->json($classexam,201);
    }

    /**
     * Update the specified classexam in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update ($id, Request $request)
    {


        $data = $this->getData ($request);

        $classexam = Classexam::findOrFail ($id);
        $classexam->update ($data);

        return response()->json($classexam,200);


    }

    /**
     * Store a new classexam in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {

        $data = $this->getData ($request);

        $classexam=Classexam::create ($data);

      return  ($classexam);

    }

    /**
     * Remove the specified classexam from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {

        $classexam = Classexam::findOrFail ($id);
        $classexam->delete ();

        return response()->json (null,204);

    }

    /**
     * Show the form for creating a new classexam.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $courseclasses = Courseclass::pluck ('id', 'id')->all ();
        $exams = Exam::pluck ('id', 'id')->all ();

        return response()->json($courseclasses, 201);
    }



    /**
     * Show the form for editing the specified classexam.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $classexam = Classexam::findOrFail ($id);
        $courseclasses = Courseclass::pluck ('id', 'id')->all ();
        $exams = Exam::pluck ('id', 'id')->all ();

        return view ('classexams.edit', compact ('classexam', 'courseclasses', 'exams'));
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
            'class_id' => 'required',
            'exam_id' => 'required',
            'addedon' => 'date_format:n/j/Y',


        ];


        $data = $request->validate ($rules);

        return $data;
    }

}
