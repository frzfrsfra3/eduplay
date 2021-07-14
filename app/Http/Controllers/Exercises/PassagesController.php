<?php

namespace App\Http\Controllers\Exercises;

use App\Models\Passage;
use App\Models\Exerciseset;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;

class PassagesController extends Controller
{

    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        //   $this->middleware('auth');

        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware ('auth');
    }


    /**
     * Display a listing of the passages.
     *
     * return Illuminate\View\View
     */
    public function index($exercise_id)
    {

        $passages = Passage::with('exerciseset')->where('exercise_id','=',$exercise_id) ->where('createdby','=',Auth::user()->id)->paginate(25);
       $exerciseset=Exerciseset::findorfail($exercise_id);
       return view('passages.index', compact('passages' ,'exercise_id' ,'exerciseset'));
    }

    /**
     * Show the form for creating a new passage.
     *
     * return Illuminate\View\View
     */
    public function create($exercise_id)
    {

        $exerciseset = Exerciseset::where('id','=' ,$exercise_id)->first();
     //   $exercisesets=$exercisesets->pluck('title','id');

        return view('passages.create', compact('exerciseset'));
    }

    /**
     * Store a new passage in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store( $exercisesets_id ,Request $request )
    {
    // try {

            $data = $this->getData($request);

            $data['createdby']=Auth::user ()->id;
          $data['exercise_id']=$exercisesets_id;
            Passage::create($data);

            return redirect()->route('passages.passage.index' ,[$exercisesets_id])
                             ->with('success_message', 'Passage was successfully added!');

   /*   } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }*/
    }

    /**
     * Display the specified passage.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $passage = Passage::with('exerciseset')->findOrFail($id);

        return view('passages.show', compact('passage'));
    }

    /**
     * Show the form for editing the specified passage.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $passage = Passage::findOrFail($id);
        $exercisesets = Exerciseset::pluck('title','id')->all();


        return view('passages.edit', compact('passage','exercisesets'));
    }

    /**
     * Update the specified passage in the storage.
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
            
            $passage = Passage::findOrFail($id);
            $passage->update($data);
            return redirect()->route('passages.passage.index' ,[$passage->exercise_id])
                             ->with('success_message', 'Passage was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified passage from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
     try {
         Question::where ('passage_id','=' ,$id)      ->update(['passage_id' => null]);
            $passage = Passage::findOrFail($id);
            $passage->delete();

            return redirect()->route('passages.passage.index')
                             ->with('success_message', 'Passage was successfully deleted!');

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
            'passage_title' => 'required|string|min:1|max:250',
            'passage_text' => 'required',


     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
