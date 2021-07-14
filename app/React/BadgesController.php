<?php

namespace App\React;

use App\Models\Badge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Exception;

class BadgesController extends Controller
{

    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask for authentication
        $this->middleware('auth');
    }

    /**
     * Display a listing of the badges.
     * return Illuminate\View\View
     */
    public function index()
    {
        $badges = Badge::paginate(25);

        return view('badges.index', compact('badges'));
    }

    /**
     * Show the form for creating a new badge.
     * return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('badges.create');
    }

    /**
     * Store a new badge in the storage.
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Badge::create($data);

            return redirect()->route('badges.badge.index')
                             ->with('success_message', 'Badge was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified badge.
     * param int $id
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $badge = Badge::findOrFail($id);

        return view('badges.show', compact('badge'));
    }

    /**
     * Show the form for editing the specified badge.
     * param int $id
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $badge = Badge::findOrFail($id);
        

        return view('badges.edit', compact('badge'));
    }

    /**
     * Update the specified badge in the storage.
     * param  int $id
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $badge = Badge::findOrFail($id);
            $badge->update($data);

            return redirect()->route('badges.badge.index')
                             ->with('success_message', 'Badge was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified badge from the storage.
     * param  int $id
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $badge = Badge::findOrFail($id);
            $badge->delete();

            return redirect()->route('badges.badge.index')
                             ->with('success_message', 'Badge was successfully deleted!');

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
            'badgetitle' => 'required',
            'badgedescription' => 'required',
            'badgeimageurl' => 'required|numeric|string|min:1|max:250',
            'points' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'badgeorder' => 'nullable|numeric|min:-2147483648|max:2147483647',
            'isactive' => 'boolean',
            'badge_condition' => 'required|string|min:1|max:250',
            'addedon' => 'required|date_format:j/n/Y g:i A',
     
        ];

        
        $data = $request->validate($rules);

        $data['isactive'] = $request->has('isactive');

        return $data;
    }

}
