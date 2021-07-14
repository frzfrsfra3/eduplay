<?php

namespace App\Http\Controllers;

use App\Models\Xp_point;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class XpPointsController extends Controller
{

    /**
     * Display a listing of the xp points.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $xpPoints = Xp_point::paginate(25);

        return view('xp_points.index', compact('xpPoints'));
    }

    /**
     * Show the form for creating a new xp point.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('xp_points.create');
    }

    /**
     * Store a new xp point in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Xp_point::create($data);

            return redirect()->route('xp_points.xp_point.index')
                             ->with('success_message', 'Xp Point was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified xp point.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $xpPoint = Xp_point::findOrFail($id);

        return view('xp_points.show', compact('xpPoint'));
    }

    /**
     * Show the form for editing the specified xp point.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $xpPoint = Xp_point::findOrFail($id);
        

        return view('xp_points.edit', compact('xpPoint'));
    }

    /**
     * Update the specified xp point in the storage.
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
            
            $xpPoint = Xp_point::findOrFail($id);
            $xpPoint->update($data);

            return redirect()->route('xp_points.xp_point.index')
                             ->with('success_message', 'Xp Point was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified xp point from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $xpPoint = Xp_point::findOrFail($id);
            $xpPoint->delete();

            return redirect()->route('xp_points.xp_point.index')
                             ->with('success_message', 'Xp Point was successfully deleted!');

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
            'activity_name' => 'required|string|min:1|max:250',
            'point' => 'required|numeric|min:-2147483648|max:2147483647',
     
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
