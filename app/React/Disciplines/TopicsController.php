<?php

namespace App\React\Disciplines;

use App\Models\Topic;
use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class TopicsController extends Controller
{

    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        //   $this->middleware('auth');

        //if trying to access this controller without being authenticated, it will ask him for authentication
     //   $this->middleware ('auth');
    }

    /**
     * Display a listing of the topics.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        
        $topics = Topic::where('approve_status','=' ,'approved')->get();
        return response()->json($topics,201);
        //return view('topics.index', compact('topics'));

    }


    /**
     * Display the specified topic.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        return response()->json($topic,201);
    //    return view('topics.show', compact('topic'));
    }


    /**
     * Store a new topic in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);
        dd($data);
            $topics=Topic::create($data);

        return $topics;

        } catch (Exception $exception) {

             $exception->errors();

            return false;
        }
    }

    /**
     * Update the specified topic in the storage.
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

            $topic = Topic::findOrFail($id);
            $topic->update($data);

          //  return redirect()->route('topics.topic.index')
            //    ->with('success_message', 'Topic was successfully updated!');

            return response()->json($topic,200);
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    /**
     * Remove the specified topic from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $topic = Topic::findOrFail($id);
            $topic->delete();

          //  return redirect()->route('topics.topic.index')
              //  ->with('success_message', 'Topic was successfully deleted!');
            return  response()->json(null, 204);
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }



    /**
     * Show the form for creating a new topic.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        $disciplines = Discipline::pluck('discipline_name','id')->all();
        
        return view('topics.create', compact('disciplines'));
    }



    /**
     * Show the form for editing the specified topic.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        $disciplines = Discipline::pluck('discipline_name','id')->all();

        return view('topics.edit', compact('topic','disciplines'));
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
            'topic_name' => 'required|string|min:1|max:250',
            'approve_status' => 'required',
            'iconurl'=>'string',
            'createdby' => 'required|numeric|min:-2147483648|max:2147483647',
            'updatedby' => 'required|numeric|min:-2147483648|max:2147483647',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
