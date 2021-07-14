<?php

namespace App\React;

use App\Models\Businessrule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class BusinessrulesController extends Controller
{
    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask for authentication
        $this->middleware('auth');
    }

    /**
     * Display a listing of the businessrules.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $businessrules = Businessrule::paginate(25);

        return view('businessrules.index', compact('businessrules'));
    }

    /**
     * Show the form for creating a new businessrule.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('businessrules.create');
    }

    /**
     * Store a new businessrule in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Businessrule::create($data);

            return redirect()->route('businessrules.businessrule.index')
                             ->with('success_message', 'Businessrule was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified businessrule.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $businessrule = Businessrule::findOrFail($id);

        return view('businessrules.show', compact('businessrule'));
    }

    /**
     * Show the form for editing the specified businessrule.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $businessrule = Businessrule::findOrFail($id);
        

        return view('businessrules.edit', compact('businessrule'));
    }

    /**
     * Update the specified businessrule in the storage.
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
            
            $businessrule = Businessrule::findOrFail($id);
            $businessrule->update($data);

            return redirect()->route('businessrules.businessrule.index')
                             ->with('success_message', 'Businessrule was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified businessrule from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $businessrule = Businessrule::findOrFail($id);
            $businessrule->delete();

            return redirect()->route('businessrules.businessrule.index')
                             ->with('success_message', 'Businessrule was successfully deleted!');

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
            'businessrule_name' => 'required|string|min:1|max:250',
            'businessrule_condition' => 'required|string|min:1|max:250',
            'isactive' => 'boolean',
     
        ];

        
        $data = $request->validate($rules);


        $data['isactive'] = $request->has('isactive');


        return $data;
    }

}
