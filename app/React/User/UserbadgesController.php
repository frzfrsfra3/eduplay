<?php

namespace App\React\User;

use App\Models\User;
use App\Models\Badge;
use App\Models\Userbadge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class UserbadgesController extends Controller
{

    /**
     * Display a listing of the userbadges.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $userbadges = Userbadge::with ('user', 'badge')->paginate (25);

        return view ('userbadges.index', compact ('userbadges'));
    }

    /**
     * Show the form for creating a new userbadge.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $users = User::pluck ('id', 'id')->all ();
        $badges = Badge::pluck ('badgetitle', 'id')->all ();

        return view ('userbadges.create', compact ('users', 'badges'));
    }

    /**
     * Store a new userbadge in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Userbadge::create ($data);

            return redirect ()->route ('userbadges.userbadge.index')
                ->with ('success_message', 'Userbadge was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified userbadge.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $userbadge = Userbadge::with ('user', 'badge')->findOrFail ($id);

        return view ('userbadges.show', compact ('userbadge'));
    }

    /**
     * Show the form for editing the specified userbadge.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $userbadge = Userbadge::findOrFail ($id);
        $users = User::pluck ('id', 'id')->all ();
        $badges = Badge::pluck ('badgetitle', 'id')->all ();

        return view ('userbadges.edit', compact ('userbadge', 'users', 'badges'));
    }

    /**
     * Update the specified userbadge in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);

            $userbadge = Userbadge::findOrFail ($id);
            $userbadge->update ($data);

            return redirect ()->route ('userbadges.userbadge.index')
                ->with ('success_message', 'Userbadge was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified userbadge from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $userbadge = Userbadge::findOrFail ($id);
            $userbadge->delete ();

            return redirect ()->route ('userbadges.userbadge.index')
                ->with ('success_message', 'Userbadge was successfully deleted!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData (Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'badge_id' => 'required',
            'dateacquired' => 'required|date_format:j/n/Y g:i A',

        ];


        $data = $request->validate ($rules);


        return $data;
    }

}
