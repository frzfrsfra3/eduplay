<?php
namespace App\Http\Controllers\Games;
use App\Models\Game;
use App\Models\Platform;
use App\Models\IosBundle;
use App\Models\Gamedetail;
use Illuminate\Http\Request;
use App\Models\IosIpadStore;
use App\Models\IosIphoneStore;
use App\Http\Controllers\Controller;
use Exception;
class GamedetailsController extends Controller {

    /**
     * Display a listing of the gamedetails.
     *
     * return Illuminate\View\View
     */
    public function index() {
        $gamedetails = Gamedetail::with('platform', 'game')->paginate(25);
        return view('gamedetails.index', compact('gamedetails'));
    }

    /**
     * Show the form for creating a new gamedetail.
     *
     * return Illuminate\View\View
     */
    public function create() {
        $platforms = Platform::pluck('id', 'id')->all();
        $games = Game::pluck('id', 'id')->all();
        $iosBundles = IosBundle::pluck('id', 'id')->all();
        $iosIphoneStores = IosIphoneStore::pluck('id', 'id')->all();
        $iosIpadStores = IosIpadStore::pluck('id', 'id')->all();
        return view('gamedetails.create', compact('platforms', 'games', 'iosBundles', 'iosIphoneStores', 'iosIpadStores'));
    }

    /**
     * Store a new gamedetail in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        try {
            $data = $this->getData($request);
            Gamedetail::create($data);
            return redirect()->route('gamedetails.gamedetail.index')->with('success_message', 'Gamedetail was successfully added!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified gamedetail.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id) {
        $gamedetail = Gamedetail::with('platform', 'game', 'iosbundle', 'iosiphonestore', 'iosipadstore')->findOrFail($id);
        return view('gamedetails.show', compact('gamedetail'));
    }

    /**
     * Show the form for editing the specified gamedetail.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id) {
        $gamedetail = Gamedetail::findOrFail($id);
        $platforms = Platform::pluck('id', 'id')->all();
        $games = Game::pluck('id', 'id')->all();
        $iosBundles = IosBundle::pluck('id', 'id')->all();
        $iosIphoneStores = IosIphoneStore::pluck('id', 'id')->all();
        $iosIpadStores = IosIpadStore::pluck('id', 'id')->all();
        return view('gamedetails.edit', compact('gamedetail', 'platforms', 'games', 'iosBundles', 'iosIphoneStores', 'iosIpadStores'));
    }

    /**
     * Update the specified gamedetail in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request) {
        try {
            $data = $this->getData($request);
            $gamedetail = Gamedetail::findOrFail($id);
            $gamedetail->update($data);
            return redirect()->route('gamedetails.gamedetail.index')->with('success_message', 'Gamedetail was successfully updated!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified gamedetail from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        try {
            $gamedetail = Gamedetail::findOrFail($id);
            $gamedetail->delete();
            return redirect()->route('gamedetails.gamedetail.index')->with('success_message', 'Gamedetail was successfully deleted!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }
    
    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData(Request $request) {
        $rules = ['platform_id' => 'required', 'game_id' => 'required', 'android_link' => 'nullable|string|min:0|max:500', 'ios_link' => 'nullable|string|min:0|max:500', 'ios_bundle_id' => 'nullable', 'ios_url_scheme_suffix' => 'nullable|string|min:0|max:500', 'ios_iphone_store_id' => 'nullable', 'ios_ipad_store_id' => 'nullable', 'android_package_name' => 'nullable|numeric|string|min:0|max:500', 'android_key_hashes' => 'nullable|string|min:0|max:500', 'android_class_name' => 'nullable|string|min:0|max:500', 'android_amazon_url' => 'nullable|string|min:0|max:500', ];
        $data = $request->validate($rules);
        return $data;
    }
}
