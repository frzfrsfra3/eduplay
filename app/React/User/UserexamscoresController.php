<?php

namespace App\React\User;

use App\Models\User;
use App\Models\Exam;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Models\Userexamscore;
use App\Http\Controllers\Controller;
use Exception;

class UserexamscoresController extends Controller
{

    /**
     * Display a listing of the userexamscores.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $userexamscores = Userexamscore::with ('user', 'exam', 'skill')->paginate (25);

        return view ('userexamscores.index', compact ('userexamscores'));
    }

    /**
     * Show the form for creating a new userexamscore.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $users = User::pluck ('id', 'id')->all ();
        $exams = Exam::pluck ('title', 'id')->all ();
        $skills = Skill::pluck ('skill_name', 'id')->all ();

        return view ('userexamscores.create', compact ('users', 'exams', 'skills'));
    }

    /**
     * Store a new userexamscore in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Userexamscore::create ($data);

            return redirect ()->route ('userexamscores.userexamscore.index')
                ->with ('success_message', 'Userexamscore was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified userexamscore.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $userexamscore = Userexamscore::with ('user', 'exam', 'skill')->findOrFail ($id);

        return view ('userexamscores.show', compact ('userexamscore'));
    }

    /**
     * Show the form for editing the specified userexamscore.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $userexamscore = Userexamscore::findOrFail ($id);
        $users = User::pluck ('id', 'id')->all ();
        $exams = Exam::pluck ('title', 'id')->all ();
        $skills = Skill::pluck ('skill_name', 'id')->all ();

        return view ('userexamscores.edit', compact ('userexamscore', 'users', 'exams', 'skills'));
    }

    /**
     * Update the specified userexamscore in the storage.
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

            $userexamscore = Userexamscore::findOrFail ($id);
            $userexamscore->update ($data);

            return redirect ()->route ('userexamscores.userexamscore.index')
                ->with ('success_message', 'Userexamscore was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified userexamscore from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $userexamscore = Userexamscore::findOrFail ($id);
            $userexamscore->delete ();

            return redirect ()->route ('userexamscores.userexamscore.index')
                ->with ('success_message', 'Userexamscore was successfully deleted!');

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
            'user_id' => 'required',
            'exam_id' => 'required',
            'score' => 'required|numeric|min:-2147483648|max:2147483647',
            'totaltimespent' => 'required|numeric|min:-2147483648|max:2147483647',
            'skill_id' => 'nullable',

        ];


        $data = $request->validate ($rules);


        return $data;
    }

}
