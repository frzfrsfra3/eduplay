<?php

namespace App\React\Course;

use App\Models\Exercise;
use App\Models\Courseclass;
use Illuminate\Http\Request;
use App\Models\Classexercise;
use App\Http\Controllers\Controller;
use Exception;

class ClassexercisesController extends Controller
{

    /**
     * Display a listing of the classexercises.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $classexercises = Classexercise::with ('courseclass', 'exercise')->paginate (25);

        return response()->json($classexercises,201);
    }

    /**
     * Show the form for creating a new classexercise.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $courseclasses = Courseclass::pluck ('id', 'id')->all ();
        $exercises = Exercise::pluck ('id', 'id')->all ();

        return view ('classexercises.create', compact ('courseclasses', 'exercises'));
    }

    /**
     * Store a new classexercise in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {


       $data = $this->getData ($request);

        $classexercise= Classexercise::create ($data);

            return ($classexercise);
    }

    /**
     * Display the specified classexercise.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $classexercise = Classexercise::with ('courseclass', 'exercise')->findOrFail ($id);

        return response()->json($classexercise,201);
    }

    /**
     * Show the form for editing the specified classexercise.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $classexercise = Classexercise::findOrFail ($id);
        $courseclasses = Courseclass::pluck ('id', 'id')->all ();
        $exercises = Exercise::pluck ('id', 'id')->all ();

        return response()->json($classexercise);
    }

    /**
     * Update the specified classexercise in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update ($id, Request $request)
    {
             $data = $this->getData ($request);

            $classexercise = Classexercise::findOrFail ($id);
            $classexercise->update ($data);

            return response()->json($classexercise,200);

    }

    /**
     * Remove the specified classexercise from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {

            $classexercise = Classexercise::findOrFail ($id);
            $classexercise->delete ();

            return response()->json(null,204);

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
            'exercise_id' => 'required',
            'addedon' => 'required|date_format:n/j/Y',

        ];


        $data = $request->validate ($rules);


        return $data;
    }

}
