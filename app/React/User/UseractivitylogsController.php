<?php

namespace App\React\User;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Useractivitylog;
use App\Http\Controllers\Controller;
use Exception;

class UseractivitylogsController extends Controller
{

    /**
     * Display a listing of the useractivitylogs.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $useractivitylogs = Useractivitylog::with ('activity', 'user')->paginate (25);

        return view ('useractivitylogs.index', compact ('useractivitylogs'));
    }

    /**
     * Show the form for creating a new useractivitylog.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $activities = Activity::pluck ('activity_description', 'id')->all ();
        $users = User::pluck ('id', 'id')->all ();

        return view ('useractivitylogs.create', compact ('activities', 'users'));
    }

    /**
     * Store a new useractivitylog in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Useractivitylog::create ($data);

            return redirect ()->route ('useractivitylogs.useractivitylog.index')
                ->with ('success_message', 'Useractivitylog was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified useractivitylog.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $useractivitylog = Useractivitylog::with ('activity', 'user')->findOrFail ($id);

        return view ('useractivitylogs.show', compact ('useractivitylog'));
    }

    /**
     * Show the form for editing the specified useractivitylog.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $useractivitylog = Useractivitylog::findOrFail ($id);
        $activities = Activity::pluck ('activity_description', 'id')->all ();
        $users = User::pluck ('id', 'id')->all ();

        return view ('useractivitylogs.edit', compact ('useractivitylog', 'activities', 'users'));
    }

    /**
     * Update the specified useractivitylog in the storage.
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

            $useractivitylog = Useractivitylog::findOrFail ($id);
            $useractivitylog->update ($data);

            return redirect ()->route ('useractivitylogs.useractivitylog.index')
                ->with ('success_message', 'Useractivitylog was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified useractivitylog from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $useractivitylog = Useractivitylog::findOrFail ($id);
            $useractivitylog->delete ();

            return redirect ()->route ('useractivitylogs.useractivitylog.index')
                ->with ('success_message', 'Useractivitylog was successfully deleted!');

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
            'activity_id' => 'required',
            'user_id' => 'required',
            'points' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'accumulated_points' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'details' => 'nullable|string|min:0|max:500',
            'device' => 'nullable|string|min:0|max:500',
            'browserinformation' => 'nullable|string|min:0|max:500',

        ];


        $data = $request->validate ($rules);


        return $data;
    }

}
