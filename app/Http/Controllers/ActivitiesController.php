<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use JonnyW\PhantomJs\Client;
use GuzzleHttp;
use Exception;

class ActivitiesController extends Controller
{
    // index, create, store, show, edit, update, destroy, getData
    
    /**
     * Display a listing of the activities.
     */
    public function index()
    {
        $activities = Activity::paginate(25);
        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create()
    {
        return view('activities.create');
    }

    /**
     * Store a new activity in the storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->getData($request);

            Activity::create($data);

            return redirect()->route('activities.activity.index')
                             ->with('success_message', 'Activity was successfully added!');
        } catch (Exception $exception) {
            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified activity.
     */
    public function show($id)
    {
        $activity = Activity::findOrFail($id);

        return view('activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);

        return view('activities.edit', compact('activity'));
    }

    /**
     * Update the specified activity in the storage.
     */
    public function update($id, Request $request)
    {
        try {
            $data = $this->getData($request);
            $activity = Activity::findOrFail($id);
            $activity->update($data);

            return redirect()->route('activities.activity.index')
                             ->with('success_message', 'Activity was successfully updated!');
        } catch (Exception $exception) {
            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified activity from the storage.
     */
    public function destroy($id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->delete();

            return redirect()->route('activities.activity.index')
                             ->with('success_message', 'Activity was successfully deleted!');
        } catch (Exception $exception) {
            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Get the request's data from the request.
     */
    protected function getData(Request $request)
    {
        $rules = [
            'activity_description' => 'required|string|min:1|max:250',
        ];

        $data = $request->validate($rules);

        return $data;
    }
}
