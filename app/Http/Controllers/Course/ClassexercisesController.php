<?php

namespace App\Http\Controllers\Course;

use App\Models\Exercise;
use App\Models\Courseclass;
use Illuminate\Http\Request;
use App\Models\Classexercise;
use App\Http\Controllers\Controller;
use Exception;

class ClassexercisesController extends Controller
{
    //index, create, store, show, edit, update, destroy, getData

    /**
     * Display a listing of the classexercises.
     */
    public function index ()
    {
        $classexercises = Classexercise::with ('courseclass', 'exercise')->paginate (25);

        return view ('classexercises.index', compact ('classexercises'));
    }

    /**
     * Show the form for creating a new classexercise.
     */
    public function create ()
    {
        $courseclasses = Courseclass::pluck ('id', 'id')->all ();
        $exercises = Exercise::pluck ('id', 'id')->all ();

        return view ('classexercises.create', compact ('courseclasses', 'exercises'));
    }

    /**
     * Store a new classexercise in the storage.
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Classexercise::create ($data);

            return redirect ()->route ('classexercises.classexercise.index')
                ->with ('success_message', 'Classexercise was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified classexercise.
     */
    public function show ($id)
    {
        $classexercise = Classexercise::with ('courseclass', 'exercise')->findOrFail ($id);

        return view ('classexercises.show', compact ('classexercise'));
    }

    /**
     * Show the form for editing the specified classexercise.
     */
    public function edit ($id)
    {
        $classexercise = Classexercise::findOrFail ($id);
        $courseclasses = Courseclass::pluck ('id', 'id')->all ();
        $exercises = Exercise::pluck ('id', 'id')->all ();

        return view ('classexercises.edit', compact ('classexercise', 'courseclasses', 'exercises'));
    }

    /**
     * Update the specified classexercise in the storage.
     */
    public function update ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);

            $classexercise = Classexercise::findOrFail ($id);
            $classexercise->update ($data);

            return redirect ()->route ('classexercises.classexercise.index')
                ->with ('success_message', 'Classexercise was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified classexercise from the storage.
     */
    public function destroy ($id)
    {
        try {
            $classexercise = Classexercise::findOrFail ($id);
            $classexercise->delete ();

            return redirect ()->route ('classexercises.classexercise.index')
                ->with ('success_message', 'Classexercise was successfully deleted!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Get the request's data from the request.
     */
    protected function getData (Request $request)
    {
        $rules = [
            'class_id' => 'required',
            'exercise_id' => 'required',
            'addedon' => 'required|date_format:j/n/Y g:i A',

        ];

        $data = $request->validate ($rules);

        return $data;
    }

}
