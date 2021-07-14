<?php

namespace App\React\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendingtask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class PendingtasksController extends Controller
{

    /**
     * Display a listing of the pendingtasks.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $pendingtasks = Pendingtask::with('user','sender')->paginate(25);

        return view('pendingtasks.index', compact('pendingtasks'));
    }

    public function mylist()
    {
        $user= Auth::user();
        $pendingtasks = $user->pendingtasks;
               return view('pendingtasks.mypendingtasks', compact('pendingtasks'));
    }
    /**
     * Show the form for creating a new pendingtask.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        $users = User::pluck('id','id')->all();
        $senders = User::pluck('id','id')->all();
        
        return view('pendingtasks.create', compact('users','senders'));
    }

    /**
     * Store a new pendingtask in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);
            
            Pendingtask::create($data);

            return redirect()->route('pendingtasks.pendingtask.index')
                             ->with('success_message', 'Pendingtask was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified pendingtask.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $pendingtask = Pendingtask::with('user','sender')->findOrFail($id);

        return view('pendingtasks.show', compact('pendingtask'));
    }

    /**
     * Show the form for editing the specified pendingtask.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $pendingtask = Pendingtask::findOrFail($id);
        $users = User::pluck('id','id')->all();
        $senders = User::pluck('id','id')->all();

        return view('pendingtasks.edit', compact('pendingtask','users','senders'));
    }

    /**
     * Update the specified pendingtask in the storage.
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
            
            $pendingtask = Pendingtask::findOrFail($id);
            $pendingtask->update($data);

            return redirect()->route('pendingtasks.pendingtask.index')
                             ->with('success_message', 'Pendingtask was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified pendingtask from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $pendingtask = Pendingtask::findOrFail($id);
            $pendingtask->delete();

            return redirect()->route('pendingtasks.pendingtask.index')
                             ->with('success_message', 'Pendingtask was successfully deleted!');

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
            'user_id' => 'required',
            'sender_id' => 'required',
            'pending_task' => 'required|string|min:1|max:250',
            'status' => 'required',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
