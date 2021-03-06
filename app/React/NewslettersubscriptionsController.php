<?php

namespace App\React;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Newslettersubscription;
use Exception;

class NewslettersubscriptionsController extends Controller
{

    /**
     * Display a listing of the newslettersubscriptions.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $newslettersubscriptions = Newslettersubscription::paginate(25);

        return view('newslettersubscriptions.index', compact('newslettersubscriptions'));
    }

    /**
     * Show the form for creating a new newslettersubscription.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('newslettersubscriptions.create');
    }

    /**
     * Store a new newslettersubscription in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Newslettersubscription::create($data);

            return redirect()->route('newslettersubscriptions.newslettersubscription.index')
                             ->with('success_message', 'Newslettersubscription was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified newslettersubscription.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $newslettersubscription = Newslettersubscription::findOrFail($id);

        return view('newslettersubscriptions.show', compact('newslettersubscription'));
    }

    /**
     * Show the form for editing the specified newslettersubscription.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $newslettersubscription = Newslettersubscription::findOrFail($id);
        

        return view('newslettersubscriptions.edit', compact('newslettersubscription'));
    }

    /**
     * Update the specified newslettersubscription in the storage.
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
            
            $newslettersubscription = Newslettersubscription::findOrFail($id);
            $newslettersubscription->update($data);

            return redirect()->route('newslettersubscriptions.newslettersubscription.index')
                             ->with('success_message', 'Newslettersubscription was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified newslettersubscription from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $newslettersubscription = Newslettersubscription::findOrFail($id);
            $newslettersubscription->delete();

            return redirect()->route('newslettersubscriptions.newslettersubscription.index')
                             ->with('success_message', 'Newslettersubscription was successfully deleted!');

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
            'email' => 'required|string|min:1|max:250',
            'subscribedon' => 'required|date_format:j/n/Y g:i A',
     
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
