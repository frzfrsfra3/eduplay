<?php

namespace App\Http\Controllers\Disciplines;

use App\Models\Country;
use App\Models\Curriculum;
use App\Models\Curriculum_gradelist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class Curriculum_gradelistsController extends Controller
{
    //index, create, store, show, edit, update, destroy, getData

    /**
     * Display a listing from the table curricula_gradelists which is associated to discipline .
     * return Illuminate\View\View
     */
    public function index()
    {
        $curricula = Curriculum_gradelist::paginate(25);

        return view('curricula.index', compact('curricula'));
    }

    /**
     * Show the form for creating a new curriculum.
     * return Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::pluck('country_name','id')->all();
        
        return view('curricula.create', compact('countries'));
    }

    /**
     * Store a new curriculum in the storage.
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Curriculum_gradelist::create($data);

            return redirect()->route('curricula.curriculum.index')
                             ->with('success_message', 'Curriculum was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified curriculum.
     * param int $id
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $curriculum = Curriculum::with('country')->findOrFail($id);

        return view('curricula.show', compact('curriculum'));
    }

    /**
     * Show the form for editing the specified curriculum.
     * param int $id
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $countries = Country::pluck('country_name','id')->all();

        return view('curricula.edit', compact('curriculum','countries'));
    }

    /**
     * Update the specified curriculum in the storage.
     * param  int $id
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $curriculum = Curriculum::findOrFail($id);
            $curriculum->update($data);

            return redirect()->route('curricula.curriculum.index')
                             ->with('success_message', 'Curriculum was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified curriculum from the storage.
     * param  int $id
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            $curriculum->delete();

            return redirect()->route('curricula.curriculum.index')
                             ->with('success_message', 'Curriculum was successfully deleted!');

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
            'curriculum_gradelist_name' => 'required|string|min:1|max:250',
            'description' => 'required',
            'country_id' => 'required|numeric|min:0|max:4294967295',
            'approve_status' => 'required',
            'createdby' => 'required|numeric|min:-2147483648|max:2147483647',
            'updatedby' => 'required|numeric|min:-2147483648|max:2147483647',
     
        ];

        
        $data = $request->validate($rules);

        return $data;
    }

}
