<?php

namespace App\Http\Controllers\User;

use App\Models\Action;
use Illuminate\Http\Request;
use App\Models\Usernotification;
use App\Http\Controllers\Controller;
use Exception;

class UsernotificationsController extends Controller
{

    /**
     * Display a listing of the usernotifications.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $usernotifications = Usernotification::paginate(25);

        return view('usernotifications.index', compact('usernotifications'));
    }

    /**
     * Show the form for creating a new usernotification.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        $actions = Action::pluck('id','id')->all();
        
        return view('usernotifications.create', compact('actions'));
    }

    /**
     * Store a new usernotification in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Usernotification::create($data);

            return redirect()->route('usernotifications.usernotification.index')
                             ->with('success_message', 'Usernotification was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified usernotification.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $usernotification = Usernotification::with('action')->findOrFail($id);

        return view('usernotifications.show', compact('usernotification'));
    }

    /**
     * Show the form for editing the specified usernotification.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $usernotification = Usernotification::findOrFail($id);
        $actions = Action::pluck('id','id')->all();

        return view('usernotifications.edit', compact('usernotification','actions'));
    }

    /**
     * Update the specified usernotification in the storage.
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
            
            $usernotification = Usernotification::findOrFail($id);
            $usernotification->update($data);

            return redirect()->route('usernotifications.usernotification.index')
                             ->with('success_message', 'Usernotification was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified usernotification from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $usernotification = Usernotification::findOrFail($id);
            $usernotification->delete();

            return redirect()->route('usernotifications.usernotification.index')
                             ->with('success_message', 'Usernotification was successfully deleted!');

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
            'receiver_userid' => 'required|numeric|min:-2147483648|max:2147483647',
            'sender_userid' => 'required|numeric|min:-2147483648|max:2147483647',
            'notification' => 'required',
            'action_id' => 'nullable',
            'status' => 'nullable',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
