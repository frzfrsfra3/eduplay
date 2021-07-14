<?php

namespace App\Http\Controllers\Course;

use App\Models\Exam;
use App\Models\Classexam;
use App\Models\Courseclass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Exception;

class ClassexamsController extends Controller
{
    //index, create, store, show, edit, update, destroy, getData

    /**
     * Display a listing of the classexams.
     * return classexams.index
     */
    public function index ()
    {
        $classexams = Classexam::with ('courseclass', 'exam')->paginate (25);

        return view ('classexams.index', compact ('classexams'));
    }

    /**
     * Show the form for creating a new classexam.
     * return classexams.create
     */
    public function create ()
    {
        $courseclasses = Courseclass::pluck ('id', 'id')->all ();
        $exams = Exam::pluck ('id', 'id')->all ();

        return view ('classexams.create', compact ('courseclasses', 'exams'));
    }

    /**
     * Store a new classexam in the storage.
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Classexam::create ($data);

            return redirect ()->route ('classexams.classexam.index')
                ->with ('success_message', 'Classexam was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified classexam.
     */
    public function show ($id)
    {
        $classexam = Classexam::with ('courseclass', 'exam')->findOrFail ($id);

        return view ('classexams.show', compact ('classexam'));
    }

    /**
     * Show the form for editing the specified classexam.
     */
    public function edit ($id)
    {
        $classexam = Classexam::findOrFail ($id);
        $courseclasses = Courseclass::pluck ('id', 'id')->all ();
        $exams = Exam::pluck ('id', 'id')->all ();

        return view ('classexams.edit', compact ('classexam', 'courseclasses', 'exams'));
    }

    /**
     * Update the specified classexam in the storage.
     */
    public function update ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);

            $classexam = Classexam::findOrFail ($id);
            $classexam->update ($data);

            return redirect ()->route ('classexams.classexam.index')
                ->with ('success_message', 'Classexam was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified classexam from the storage.
     */
    public function destroy ($id)
    {
        try {
            $classexam = Classexam::findOrFail($id);
            $classexam->delete ();

            return redirect ()->route ('classexams.classexam.index')
                ->with ('success_message', 'Classexam was successfully deleted!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Get the request's data from the request.
     * return array
     */
    protected function getData (Request $request)
    {
        $rules = [
            'class_id' => 'required',
            'exam_id' => 'required',
            'addedon' => 'date_format:j/n/Y',

        ];


        $data = $request->validate ($rules);

        return $data;
    }
}
