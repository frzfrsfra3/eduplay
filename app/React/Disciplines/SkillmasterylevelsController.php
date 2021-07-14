<?php

namespace App\React\Disciplines;

use Illuminate\Http\Request;
use App\Models\Skillmasterylevel;
use App\Http\Controllers\Controller;
use Exception;

class SkillmasterylevelsController extends Controller
{

    /**
     * Display a listing of the skillmasterylevels.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $skillmasterylevels = Skillmasterylevel::paginate(25);

        return view('skillmasterylevels.index', compact('skillmasterylevels'));
    }

    /**
     * Show the form for creating a new skillmasterylevel.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('skillmasterylevels.create');
    }

    /**
     * Store a new skillmasterylevel in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Skillmasterylevel::create($data);

            return redirect()->route('skillmasterylevels.skillmasterylevel.index')
                             ->with('success_message', 'Skillmasterylevel was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified skillmasterylevel.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $skillmasterylevel = Skillmasterylevel::findOrFail($id);

        return view('skillmasterylevels.show', compact('skillmasterylevel'));
    }

    /**
     * Show the form for editing the specified skillmasterylevel.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $skillmasterylevel = Skillmasterylevel::findOrFail($id);
        

        return view('skillmasterylevels.edit', compact('skillmasterylevel'));
    }

    /**
     * Update the specified skillmasterylevel in the storage.
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
            
            $skillmasterylevel = Skillmasterylevel::findOrFail($id);
            $skillmasterylevel->update($data);

            return redirect()->route('skillmasterylevels.skillmasterylevel.index')
                             ->with('success_message', 'Skillmasterylevel was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified skillmasterylevel from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $skillmasterylevel = Skillmasterylevel::findOrFail($id);
            $skillmasterylevel->delete();

            return redirect()->route('skillmasterylevels.skillmasterylevel.index')
                             ->with('success_message', 'Skillmasterylevel was successfully deleted!');

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
            'levelname' => 'nullable|string|min:0|max:250',
            'level_massage' => 'nullable|numeric|string|min:0|max:250',
            'min_score' => 'required|numeric|min:-2147483648|max:2147483647',
            'max_score' => 'required|numeric|min:-2147483648|max:2147483647',
            'consecutive_value' => 'required|numeric|min:-2147483648|max:2147483647',
     
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

}
