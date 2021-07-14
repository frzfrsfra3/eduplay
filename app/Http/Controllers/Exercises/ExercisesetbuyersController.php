<?php
namespace App\Http\Controllers\Exercises;
use App\Models\User;
use App\Models\Exerciseset;
use Illuminate\Http\Request;
use App\Models\Exercisesetbuyer;
use App\Http\Controllers\Controller;
use Exception;
class ExercisesetbuyersController extends Controller {

    /**
     * Display a listing of the exercisesetbuyers.
     */
    public function index() {
        $exercisesetbuyers = Exercisesetbuyer::with('exerciseset', 'user')->paginate(25);
        return view('exercisesetbuyers.index', compact('exercisesetbuyers'));
    }

    /**
     * Show the form for creating a new exercisesetbuyer.
     */
    public function create() {
        $exercisesets = Exerciseset::pluck('id', 'id')->all();
        $users = User::pluck('id', 'id')->all();
        return view('exercisesetbuyers.create', compact('exercisesets', 'users'));
    }

    /**
     * Store a new exercisesetbuyer in the storage.
     */
    public function store(Request $request) {
        try {
            $data = $this->getData($request);
            Exercisesetbuyer::create($data);
            return redirect()->route('exercisesetbuyers.exercisesetbuyer.index')->with('success_message', 'Exercisesetbuyer was successfully added!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified exercisesetbuyer.
     */
    public function show($id) {
        $exercisesetbuyer = Exercisesetbuyer::with('exerciseset', 'user')->findOrFail($id);
        return view('exercisesetbuyers.show', compact('exercisesetbuyer'));
    }

    /**
     * Show the form for editing the specified exercisesetbuyer.
     */
    public function edit($id) {
        $exercisesetbuyer = Exercisesetbuyer::findOrFail($id);
        $exercisesets = Exerciseset::pluck('id', 'id')->all();
        $users = User::pluck('id', 'id')->all();
        return view('exercisesetbuyers.edit', compact('exercisesetbuyer', 'exercisesets', 'users'));
    }

    /**
     * Update the specified exercisesetbuyer in the storage.
     */
    public function update($id, Request $request) {
        try {
            $data = $this->getData($request);
            $exercisesetbuyer = Exercisesetbuyer::findOrFail($id);
            $exercisesetbuyer->update($data);
            return redirect()->route('exercisesetbuyers.exercisesetbuyer.index')->with('success_message', 'Exercisesetbuyer was successfully updated!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }
    
    /**
     * Remove the specified exercisesetbuyer from the storage.
     */
    public function destroy($id) {
        try {
            $exercisesetbuyer = Exercisesetbuyer::findOrFail($id);
            $exercisesetbuyer->delete();
            return redirect()->route('exercisesetbuyers.exercisesetbuyer.index')->with('success_message', 'Exercisesetbuyer was successfully deleted!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }
    
    /**
     * Get the request's data from the request.
     */
    protected function getData(Request $request) {
        $rules = ['exerciseset_id' => 'required', 'user_id' => 'required', 'joindate' => 'required|date_format:j/n/Y g:i A', ];
        $data = $request->validate($rules);
        return $data;
    }
}
