<?php

namespace App\React\Games;

use App\Models\App;
use App\Models\Age;
use App\Models\Game;
use App\Models\Category;
use App\Models\Developer;
use App\Models\Discipline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class GamesController extends Controller
{

    /**
     * Display a listing of the games.
     */
    public function index ()
    {
        $games = Game::with ('discipline', 'developer')->paginate (25);

        return view ('games.index', compact ('games'));
    }

    /**
     * Show the form for creating a new game.
     */
    public function create ()
    {
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
        $developers = Developer::pluck ('id', 'id')->all ();
        $apps = App::pluck ('id', 'id')->all ();
        $categories = Category::pluck ('id', 'id')->all ();
        $ages = Age::pluck ('id', 'id')->all ();

        return view ('games.create', compact ('disciplines', 'developers', 'apps', 'categories', 'ages'));
    }

    /**
     * Store a new game in the storage.
     */
    public function store (Request $request)
    {
        try {

            $data = $this->getData ($request);

            Game::create ($data);

            return redirect ()->route ('games.game.index')
                ->with ('success_message', 'Game was successfully added!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified game.
     */
    public function show ($id)
    {
        $game = Game::with ('discipline', 'developer', 'app', 'category', 'age')->findOrFail ($id);

        return view ('games.show', compact ('game'));
    }

    /**
     * Show the form for editing the specified game.
     */
    public function edit ($id)
    {
        $game = Game::findOrFail ($id);
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
        $developers = Developer::pluck ('id', 'id')->all ();
        $apps = App::pluck ('id', 'id')->all ();
        $categories = Category::pluck ('id', 'id')->all ();
        $ages = Age::pluck ('id', 'id')->all ();

        return view ('games.edit', compact ('game', 'disciplines', 'developers', 'apps', 'categories', 'ages'));
    }

    /**
     * Update the specified game in the storage.
     */
    public function update ($id, Request $request)
    {
        try {

            $data = $this->getData ($request);

            $game = Game::findOrFail ($id);
            $game->update ($data);

            return redirect ()->route ('games.game.index')
                ->with ('success_message', 'Game was successfully updated!');

        } catch (Exception $exception) {

            return back ()->withInput ()
                ->withErrors (['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified game from the storage.
     */
    public function destroy ($id)
    {
        try {
            $game = Game::findOrFail ($id);
            $game->delete ();

            return redirect ()->route ('games.game.index')
                ->with ('success_message', 'Game was successfully deleted!');

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
            'discipline_id' => 'required',
            'developer_id' => 'required',
            'game_name' => 'required|numeric|min:-2147483648|max:2147483647',
            'patform' => 'required',
            'app_id' => 'required',
            'secrete_key' => 'required|string|min:1|max:500',
            'game_icon' => 'required|string|min:1|max:250',
            'image1' => 'required|numeric|string|min:1|max:250',
            'image2' => 'required|numeric|string|min:1|max:250',
            'image3' => 'required|numeric|string|min:1|max:250',
            'image4' => 'required|numeric|string|min:1|max:250',
            'image5' => 'required|numeric|string|min:1|max:250',
            'category_id' => 'required',
            'age_id' => 'required|numeric|min:0|max:4294967295',
            'status' => 'required',
            'isapproved' => 'required',
            'isactive' => 'required',
            'description' => 'required',

        ];


        $data = $request->validate ($rules);


        return $data;
    }

}
