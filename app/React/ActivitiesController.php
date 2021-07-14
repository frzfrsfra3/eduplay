<?php

namespace App\React;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Exception;

class ActivitiesController extends Controller
{

    /**
     * Display a listing of the activities.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $activities = Activity::get();
        return response()->json($activities,200);
    }

    /**
     * Display the specified activity.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $activity = Activity::findOrFail($id);

        return response()->json($activity,200);
    }

    /**
     * Show the form for creating a new activity.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        return view('activities.create');
    }

    /**
     * Store a new activity in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);
            $activities=Activity::create($data);

            return $activities;

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Update the specified activity in the storage.
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
            $activity = Activity::findOrFail($id);
            $activity->update($data);
            return response()->json($activity,200);

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified activity from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->delete();

            return  response()->json(null, 204);
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Show the form for editing the specified activity.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        

        return view('activities.edit', compact('activity'));
    }


    /**
     * Get the request's data from the request.
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'role_type' => 'nullable|string|min:1|max:50',
            'activity_description' => 'required|string|min:1|max:250',
            'activity_action' => 'nullable|string|min:1|max:50',
            'order' => 'nullable|numeric|min:0|max:55550',
        ];

        
        $data = $request->validate($rules);


        return $data;
    }

}
