<?php

namespace App\React\Disciplines;

use App\Models\Country;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class CurriculaController extends Controller
{

    /**
     * Display a listing of the curricula.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $curricula = Curriculum::with('country')->paginate(25);

        return response()->json($curricula,200);
    }

    /**
     * Show the form for creating a new curriculum.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::pluck('country_name','id')->all();

        return view('curricula.create', compact('countries'));
    }

    /**
     * Store a new curriculum in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'curriculum_gradelist_name' => 'required|string|min:1|max:250',
            'description' => 'required',
            'country_id' => 'required|numeric|min:0|max:4294967295',
            'approve_status' => 'required',
        ]);



        $urriculu = Curriculum::create($request->all());


        return $urriculu;

    }

    /**
     * Display the specified curriculum.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $curriculum = Curriculum::with('country')->findOrFail($id);

        return response()->json($curriculum,201);
    }

    /**
     * Show the form for editing the specified curriculum.
     *
     * param int $id
     *
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
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {


            $data = $this->getData($request);

            $curriculum = Curriculum::findOrFail($id);
            $curriculum->update($data);

        return response()->json($curriculum,200);



    }

    /**
     * Remove the specified curriculum from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {

            $curriculum = Curriculum::findOrFail($id);
            $curriculum->delete();

        return  response()->json(null, 204);
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
