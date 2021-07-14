<?php

namespace App\Http\Controllers\Disciplines;

use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Models\Disciplineversion;
use App\Http\Controllers\Controller;
use Exception;

class DisciplineversionsController extends Controller
{
    // is this controller needed??!!!!

    /**
     * Display a listing of the disciplineversions.
     * return Illuminate\View\View
     */
    public function index()
    {
        $disciplineversions = Disciplineversion::with('discipline')->paginate(25);

        return view('disciplineversions.index', compact('disciplineversions'));
    }

    /**
     * Show the form for creating a new disciplineversion.
     * return Illuminate\View\View
     */
    public function create()
    {
        $disciplines = Discipline::pluck('discipline_name','id')->all();
        
        return view('disciplineversions.create', compact('disciplines'));
    }

    /**
     * Store a new disciplineversion in the storage.
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Disciplineversion::create($data);

            return redirect()->route('disciplineversions.disciplineversion.index')
                             ->with('success_message', 'Disciplineversion was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified disciplineversion.
     * param int $id
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $disciplineversion = Disciplineversion::with('discipline')->findOrFail($id);
        return view('disciplineversions.show', compact('disciplineversion'));
    }

    /**
     * Show the form for editing the specified disciplineversion.
     * param int $id
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $disciplineversion = Disciplineversion::findOrFail($id);
        $disciplines = Discipline::pluck('discipline_name','id')->all();

        return view('disciplineversions.edit', compact('disciplineversion','disciplines'));
    }

    /**
     * Update the specified disciplineversion in the storage.
     * param  int $id
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $disciplineversion = Disciplineversion::findOrFail($id);
            $disciplineversion->update($data);

            return redirect()->route('disciplineversions.disciplineversion.index')
                             ->with('success_message', 'Disciplineversion was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified disciplineversion from the storage.
     * param  int $id
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $disciplineversion = Disciplineversion::findOrFail($id);
            $disciplineversion->delete();

            return redirect()->route('disciplineversions.disciplineversion.index')
                             ->with('success_message', 'Disciplineversion was successfully deleted!');

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
            'version' => 'required|numeric|min:-2147483648|max:2147483647',
            'ispublished' => 'required|numeric|min:-2147483648|max:2147483647',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
