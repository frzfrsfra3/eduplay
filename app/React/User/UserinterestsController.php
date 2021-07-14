<?php

namespace App\React\User;

use App\Models\Grade;
use App\Models\Language;
use App\Models\User;
use App\Models\Discipline;
use App\Models\Userinterest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserinterestsController extends Controller
{

    public function __construct ()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        //   $this->middleware('auth');

        //if trying to access this controller without being authenticated, it will ask him for authentication
        //  $this->middleware ('auth');
    }

    /**
     * Display a listing of the userinterests.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $userinterests = Userinterest::with ('discipline', 'user')->paginate (25);

        return view ('userinterests.index', compact ('userinterests'));
    }

    /**
     * Show the form for creating a new userinterest.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
        $users = User::pluck ('id', 'id')->all ();

        return view ('userinterests.create', compact ('disciplines', 'users'));
    }

    /**
     * Store a new userinterest in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Userinterest::create ($data);

            return redirect ()->route ('userinterests.userinterest.index')
                ->with ('success_message', 'Userinterest was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified userinterest.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $userinterest = Userinterest::with ('discipline', 'user')->findOrFail ($id);

        return view ('userinterests.show', compact ('userinterest'));
    }

    /**
     * Show the form for editing the specified userinterest.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function editinterest ($topic_id)
    {
        if ($user = Auth::user ()) {
            $userinterest = Userinterest::where ('topic_id', '=', $topic_id)->where ('user_id', '=', Auth::user ()->id)->first ();
            $disciplines = Discipline::where ('topic_id', '=', $topic_id)->pluck ('discipline_name', 'id')->all ();
            if ($disciplines) {
                $grades = Grade::pluck ('grade_name', 'id')->all ();
                $languages = Language::pluck ('language', 'id')->all ();
                $grade_id = 0;
                if ($userinterest) {
                    $discipline = Discipline::where ('id', '=', $userinterest->discipline_id)->first ();
                    $grades = Grade::where ('curriculum_gradelist_id', '=', $discipline->curriculum_gradelist_id)->pluck ('grade_name', 'id')->all ();
                    $grade_id = $userinterest->grade_id;
                }

                return view ('userinterests.edituserinterest', compact ('userinterest', 'disciplines', 'languages', 'grades', 'grade_id', 'topic_id'));
            } else
                return back ()->withInput ()
                    ->withErrors (['unexpected_error' => 'No discpine for this topics']);;

        } else {
            $disciplines = Discipline::where ('topic_id', '=', $topic_id)->pluck ('discipline_name', 'id')->all ();
            if ($disciplines) {
                $grades = Grade::pluck ('grade_name', 'id')->all ();
                $languages = Language::pluck ('language', 'id')->all ();
                $grade_id = 0;

                return view ('userinterests.guestinterest', compact ('disciplines', 'languages', 'grades', 'grade_id', 'topic_id'));
            } else
                return back ()->withInput ()
                    ->withErrors (['unexpected_error' => 'No discpine for this topics']);;

        }
    }


    public function edit ($id)
    {
        $userinterest = Userinterest::findOrFail ($id);
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
        $users = User::pluck ('id', 'id')->all ();

        return view ('userinterests.edit', compact ('userinterest', 'disciplines', 'users'));
    }


    /**
     * Update the specified userinterest in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */

    public function updateinterests (Request $request)
    {
       try {

        if ($user = Auth::user ()) {

            $user_id = Auth::user ()->id;
            $data = $this->getinterset ($request);
            $data['user_id'] = $user_id;
            $userinterest = Userinterest::where ('user_id', '=', $user_id)->where ('topic_id', '=', $data['topic_id'])->first ();
            if ($userinterest) {
                $userinterest->update ($data);
            } else {

                $userinterest = Userinterest::create ($data);

            }

            return redirect ()->route ('practice.disciplinepractice', [$userinterest->id]);
        } else {

            if (session ()->has ('grade_id')) {

                session ()->forget ('grade_id');

            }
            $data = $this->getinterset_forguset ($request);

            session (['language_id' => $data['language_id']]);
            session (['discipline_id' => $data['discipline_id']]);
            session (['exercise_type' => 1]);
            session (['topic_id' => $data['topic_id']]);
            if ($request->has ('grade_id')) {
                if ($data['grade_id'] <> null) session (['grade_id' => $data['grade_id']]);

            }


            return redirect ()->route ('guest.guestpractice');

        }

         } catch (Exception $exception) {

               return back()->withInput()
                    ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
            }
    }

    public function update ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);

            $userinterest = Userinterest::findOrFail ($id);
            $userinterest->update ($data);

            return redirect ()->route ('userinterests.userinterest.index')
                ->with ('success_message', 'Userinterest was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified userinterest from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $userinterest = Userinterest::findOrFail ($id);
            $userinterest->delete ();

            return redirect ()->route ('userinterests.userinterest.index')
                ->with ('success_message', 'Userinterest was successfully deleted!');

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
            'discipline_id' => 'required',
            'user_id' => 'required',

        ];


        $data = $request->validate ($rules);


        return $data;
    }

    protected function getinterset (Request $request)
    {
        $rules = [
            'discipline_id' => 'required',
            'language_id' => 'required',
            'grade_id' => 'required',
            'exercise_type' => 'required',
            'topic_id' => 'required',
        ];


        $data = $request->validate ($rules);


        return $data;
    }

    protected function getinterset_forguset (Request $request)
    {
        $rules = [
            'discipline_id' => 'required',
            'language_id' => 'required',
            'grade_id' => 'nullable',
            'topic_id' => 'required',
        ];


        $data = $request->validate ($rules);


        return $data;
    }

}
