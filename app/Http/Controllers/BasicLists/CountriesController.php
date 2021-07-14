<?php

namespace App\Http\Controllers\BasicLists;

use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;


class CountriesController extends Controller
{
    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware('auth');
    }
    /**
     * Display a listing of the countries.
     *
     * return resources/views/countries/index
     */
    public function index()
    {
        $countries = Country::paginate(25);
        if (Auth::user()->can('view',Country::class)){
        return view('countries.index', compact('countries'));}
        return view('unauthorized');
    }

    /**
     * Show the form for creating a new country.
     *
     * return resources/views/countries/create
     */
    public function create()
    {

        //$request->user()->authorizeRoles(['Admin']); or Auth::user()->authorizeRoles(['Admin']);
        //using a policy instead
        if (Auth::user()->can('create',Country::class)){return view('countries.create');}
        return view('unauthorized');
    }

    /**
     * Store a new country in the storage.
     *
     * param Illuminate/Http/Request $request
     *
     * return Illuminate/Http/RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);

            Country::create($data);

            return redirect()->route('countries.country.index')
                             ->with('success_message', 'Country was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified country.
     *
     * param int $id
     *
     * return resources/views/countries/show
     */
    public function show($id)
    {
        $country = Country::findOrFail($id);

        return view('countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified country.
     *
     * param int $id
     *
     * return resources/views/countries/edit
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);


        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified country in the storage.
     *
     * param  int $id
     * param Request $request
     *
     * return RedirectResponse | Illuminate/Routing/Redirector
     */
    public function update($id, Request $request)
    {
        try {

            $data = $this->getData($request);

            $country = Country::findOrFail($id);
            $country->update($data);

            return redirect()->route('countries.country.index')
                             ->with('success_message', 'Country was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified country from the storage.
     *
     * param  int $id
     *
     * return Illuminate/Http/RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $country = Country::findOrFail($id);
            $country->delete();

            return redirect()->route('countries.country.index')
                             ->with('success_message', 'Country was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * param Request $request
     * return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'country_name' => 'required|string|min:1|max:100',
            'abbreviation_code' => 'nullable|string|min:0|max:50',
            'country_flag' => 'nullable|string|min:0|max:100',
        ];

        $data = $request->validate($rules);
        return $data;
    }

}
