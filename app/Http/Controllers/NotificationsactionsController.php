<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Notificationsaction;
use App\Http\Controllers\Controller;
use Exception;
class NotificationsactionsController extends Controller {

    /**
     * Display a listing of the notificationsactions.
     *
     * return Illuminate\View\View
     */
    public function index() {
        $notificationsactions = Notificationsaction::paginate(25);
        return view('notificationsactions.index', compact('notificationsactions'));
    }

    /**
     * Show the form for creating a new notificationsaction.
     *
     * return Illuminate\View\View
     */
    public function create() {
        return view('notificationsactions.create');
    }

    /**
     * Store a new notificationsaction in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        try {
            $data = $this->getData($request);
            Notificationsaction::create($data);
            return redirect()->route('notificationsactions.notificationsaction.index')->with('success_message', 'Notificationsaction was successfully added!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified notificationsaction.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id) {
        $notificationsaction = Notificationsaction::findOrFail($id);
        return view('notificationsactions.show', compact('notificationsaction'));
    }

    /**
     * Show the form for editing the specified notificationsaction.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id) {
        $notificationsaction = Notificationsaction::findOrFail($id);
        return view('notificationsactions.edit', compact('notificationsaction'));
    }

    /**
     * Update the specified notificationsaction in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request) {
        try {
            $data = $this->getData($request);
            $notificationsaction = Notificationsaction::findOrFail($id);
            $notificationsaction->update($data);
            return redirect()->route('notificationsactions.notificationsaction.index')->with('success_message', 'Notificationsaction was successfully updated!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified notificationsaction from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        try {
            $notificationsaction = Notificationsaction::findOrFail($id);
            $notificationsaction->delete();
            return redirect()->route('notificationsactions.notificationsaction.index')->with('success_message', 'Notificationsaction was successfully deleted!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }
    
    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData(Request $request) {
        $rules = ['modelname' => 'required|string|min:1|max:250', 'notificationtpl' => 'required', 'type' => 'required', ];
        $data = $request->validate($rules);
        return $data;
    }
}
