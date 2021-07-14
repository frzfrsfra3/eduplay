<?php

namespace App\React\Disciplines;


use App\Models\User;
use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Disciplinecollaborator;
use Illuminate\Support\Facades\Auth;

//use Exception;

class DisciplinecollaboratorsController extends Controller
{

    /**
     * Display a listing of the disciplinecollaborators for Admin
     * return Illuminate\View\View
     */
    public function index()
    {
        $disciplinecollaborators = Disciplinecollaborator::with('discipline','user')->paginate(25);
        return view('disciplinecollaborators.index', compact('disciplinecollaborators'));
    }

    /**
     * Show the form for creating a new disciplinecollaborator.
     * return Illuminate\View\View
     */
    public function create()
    {
        $disciplines = Discipline::pluck('discipline_name','id')->all();
        $users = User::pluck('name','id')->all();
        
        return view('disciplinecollaborators.create', compact('disciplines','users'));
    }

    /**
     * Store a new disciplinecollaborator in the storage.
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Disciplinecollaborator::create($data);

            return redirect()->route('disciplinecollaborators.disciplinecollaborator.index')
                             ->with('success_message', 'Disciplinecollaborator was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    public function requestDiscipline()
    {
        try {

            $art = new Disciplinecollaborator;
            $art-> discipline_id = $_GET['disId'];
            $art->user_id = Auth::user()->id ;
            $art->message = 'Request for approval';
            $art->iscoordinator = '0';
            $art->approvalstatus = 'pending';

            $art->save();


            return ('Discipline collaborator was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    /**
     * Display the specified disciplinecollaborator.
     * param int $id
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $disciplinecollaborator = Disciplinecollaborator::with('discipline','user')->findOrFail($id);

        return view('disciplinecollaborators.show', compact('disciplinecollaborator'));
    }

    /**
     * Show the form for editing the specified disciplinecollaborator.
     * param int $id
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $disciplinecollaborator = Disciplinecollaborator::findOrFail($id);
        $disciplines = Discipline::pluck('discipline_name','id')->all();
        $users = User::pluck('name','id')->all();

        return view('disciplinecollaborators.edit', compact('disciplinecollaborator','disciplines','users'));
    }

    /**
     * Update the specified disciplinecollaborator in the storage.
     * param  int $id
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $disciplinecollaborator = Disciplinecollaborator::findOrFail($id);
            $disciplinecollaborator->update($data);

            return redirect()->route('disciplinecollaborators.disciplinecollaborator.index')
                             ->with('success_message', 'Disciplinecollaborator was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified disciplinecollaborator from the storage.
     * param  int $id
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $disciplinecollaborator = Disciplinecollaborator::findOrFail($id);
            $disciplinecollaborator->delete();

            return redirect()->route('disciplinecollaborators.disciplinecollaborator.index')
                             ->with('success_message', 'Disciplinecollaborator was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    
    /**
     * Get the request's data from the request.
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'discipline_id' => 'required',
            'user_id' => 'required',
            'message' => 'nullable|string|min:0|max:50',
            'iscoordinator' => 'boolean',
            'approvalstatus' => 'required',
     
        ];


        $data = $request->validate($rules);
        $data['iscoordinator'] = $request->has('iscoordinator');

        return $data;
    }

}
