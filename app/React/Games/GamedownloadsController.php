<?php

namespace App\React\Games;

use App\Models\User;
use App\Models\Game;
use App\Models\Gamedownload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class GamedownloadsController extends Controller
{

    /**
     * Display a listing of the gamedownloads.
     *
     * return Illuminate\View\View
     */
    public function index ()
    {
        $gamedownloads = Gamedownload::with ('user', 'game')->paginate (25);

        return view ('gamedownloads.index', compact ('gamedownloads'));
    }

    /**
     * Show the form for creating a new gamedownload.
     *
     * return Illuminate\View\View
     */
    public function create ()
    {
        $users = User::pluck ('id', 'id')->all ();
        $games = Game::pluck ('id', 'id')->all ();

        return view ('gamedownloads.create', compact ('users', 'games'));
    }

    /**
     * Store a new gamedownload in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Gamedownload::create ($data);

            return redirect ()->route ('gamedownloads.gamedownload.index')
                ->with ('success_message', 'Gamedownload was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified gamedownload.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show ($id)
    {
        $gamedownload = Gamedownload::with ('user', 'game')->findOrFail ($id);

        return view ('gamedownloads.show', compact ('gamedownload'));
    }

    /**
     * Show the form for editing the specified gamedownload.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit ($id)
    {
        $gamedownload = Gamedownload::findOrFail ($id);
        $users = User::pluck ('id', 'id')->all ();
        $games = Game::pluck ('id', 'id')->all ();

        return view ('gamedownloads.edit', compact ('gamedownload', 'users', 'games'));
    }

    /**
     * Update the specified gamedownload in the storage.
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

            $gamedownload = Gamedownload::findOrFail ($id);
            $gamedownload->update ($data);

            return redirect ()->route ('gamedownloads.gamedownload.index')
                ->with ('success_message', 'Gamedownload was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified gamedownload from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy ($id)
    {
        try {
            $gamedownload = Gamedownload::findOrFail ($id);
            $gamedownload->delete ();

            return redirect ()->route ('gamedownloads.gamedownload.index')
                ->with ('success_message', 'Gamedownload was successfully deleted!');

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
            'game_id' => 'required',
            'download_type' => 'required',

        ];


        $data = $request->validate ($rules);


        return $data;
    }

}
