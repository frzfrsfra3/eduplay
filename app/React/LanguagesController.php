<?php

namespace App\React;

use App\Models\Country;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


use Redirect;
use Exception;
use Log;
use Illuminate\Support\Facades\Storage;

class LanguagesController extends Controller
{

    /**
     * Display a listing of the languages.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $languages = Language::paginate(25);
        if (Auth::user()->can('doadminwork',Country::class)){
        return view('languages.index', compact('languages'));}
        return view('unauthorized');
    }
    /* switch between languages */
    public  function switch ($lang =null ){
        try {

      if(session::has('local')) {
          Session::put('local', $lang );

        }
        else
        {
            Session::put('local', $lang );

        }

        return Redirect::back(); }

        catch (Exception $exception) {
            Storage::disk ('local')->append ('session.txt', $exception);


        }
    }

    /**
     * Show the form for creating a new language.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('languages.create');
    }

    /**
     * Store a new language in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Language::create($data);

            return redirect()->route('languages.language.index')
                             ->with('success_message', 'Language was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified language.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $language = Language::findOrFail($id);

        return view('languages.show', compact('language'));
    }

    /**
     * Show the form for editing the specified language.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $language = Language::findOrFail($id);
        

        return view('languages.edit', compact('language'));
    }

    /**
     * Update the specified language in the storage.
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
            
            $language = Language::findOrFail($id);
            $language->update($data);

            return redirect()->route('languages.language.index')
                             ->with('success_message', 'Language was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified language from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $language = Language::findOrFail($id);
            $language->delete();

            return redirect()->route('languages.language.index')
                             ->with('success_message', 'Language was successfully deleted!');

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
            'language' => 'required|string|min:1|max:25',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
