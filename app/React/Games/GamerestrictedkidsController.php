<?php

namespace App\React\Games;

use App\Models\Kid;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\RestrictedBy;
use App\Models\Gamerestrictedkid;
use App\Http\Controllers\Controller;
use Exception;

class GamerestrictedkidsController extends Controller
{

    /**
     * Display a listing of the gamerestrictedkids.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $gamerestrictedkids = Gamerestrictedkid::with ('kid', 'game', 'restrictedby')->paginate (25);

        return view ('gamerestrictedkids.index', compact ('gamerestrictedkids'));
    }

    /**
     * Show the form for creating a new gamerestrictedkid.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $kids = Kid::pluck ('id', 'id')->all ();
        $games = Game::pluck ('id', 'id')->all ();
        $restrictedBies = RestrictedBy::pluck ('id', 'id')->all ();

        return view ('gamerestrictedkids.create', compact ('kids', 'games', 'restrictedBies'));
    }

    /**
     * Store a new gamerestrictedkid in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Gamerestrictedkid::create ($data);

            return redirect ()->route ('gamerestrictedkids.gamerestrictedkid.index')
                ->with ('success_message', 'Gamerestrictedkid was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified gamerestrictedkid.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $gamerestrictedkid = Gamerestrictedkid::with ('kid', 'game', 'restrictedby')->findOrFail ($id);

        return view ('gamerestrictedkids.show', compact ('gamerestrictedkid'));
    }

    /**
     * Show the form for editing the specified gamerestrictedkid.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $gamerestrictedkid = Gamerestrictedkid::findOrFail ($id);
        $kids = Kid::pluck ('id', 'id')->all ();
        $games = Game::pluck ('id', 'id')->all ();
        $restrictedBies = RestrictedBy::pluck ('id', 'id')->all ();

        return view ('gamerestrictedkids.edit', compact ('gamerestrictedkid', 'kids', 'games', 'restrictedBies'));
    }

    /**
     * Update the specified gamerestrictedkid in the storage.
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

            $gamerestrictedkid = Gamerestrictedkid::findOrFail ($id);
            $gamerestrictedkid->update ($data);

            return redirect ()->route ('gamerestrictedkids.gamerestrictedkid.index')
                ->with ('success_message', 'Gamerestrictedkid was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified gamerestrictedkid from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $gamerestrictedkid = Gamerestrictedkid::findOrFail ($id);
            $gamerestrictedkid->delete ();

            return redirect ()->route ('gamerestrictedkids.gamerestrictedkid.index')
                ->with ('success_message', 'Gamerestrictedkid was successfully deleted!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    /**
     * Get the request's data from the request.
    */
    protected function getData (Request $request)
    {
        $rules = [
            'kid_id' => 'required',
            'game_id' => 'required',
            'restricted_by' => 'required',
            'isactive' => 'required',

        ];

        $data = $request->validate ($rules);

        return $data;
    }

}
