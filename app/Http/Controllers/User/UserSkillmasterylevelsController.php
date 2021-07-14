<?php
namespace App\Http\Controllers\User;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Models\UserSkillmasterylevel;
use App\Http\Controllers\Controller;
use Exception;
class UserSkillmasterylevelsController extends Controller {

    /**
     * Display a listing of the userskillmasterylevels.
     *
     * return Illuminate\View\View
     */
    public function index() {
        $userskillmasterylevels = UserSkillmasterylevel::with('user', 'skill')->paginate(25);
        return view('userskillmasterylevels.index', compact('userskillmasterylevels'));
    }

    /**
     * Show the form for creating a new userskillmasterylevel.
     *
     * return Illuminate\View\View
     */
    public function create() {
        $users = User::pluck('id', 'id')->all();
        $skills = Skill::pluck('id', 'id')->all();
        return view('userskillmasterylevels.create', compact('users', 'skills'));
    }

    /**
     * Store a new userskillmasterylevel in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        try {
            $data = $this->getData($request);
            UserSkillmasterylevel::create($data);
            return redirect()->route('userskillmasterylevels.userskillmasterylevel.index')->with('success_message', 'User Skillmasterylevel was successfully added!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified userskillmasterylevel.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id) {
        $userskillmasterylevel = UserSkillmasterylevel::with('user', 'skill')->findOrFail($id);
        return view('userskillmasterylevels.show', compact('userskillmasterylevel'));
    }

    /**
     * Show the form for editing the specified userskillmasterylevel.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id) {
        $userskillmasterylevel = UserSkillmasterylevel::findOrFail($id);
        $users = User::pluck('id', 'id')->all();
        $skills = Skill::pluck('id', 'id')->all();
        return view('userskillmasterylevels.edit', compact('userskillmasterylevel', 'users', 'skills'));
    }

    /**
     * Update the specified userskillmasterylevel in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request) {
        try {
            $data = $this->getData($request);
            $userskillmasterylevel = UserSkillmasterylevel::findOrFail($id);
            $userskillmasterylevel->update($data);
            return redirect()->route('userskillmasterylevels.userskillmasterylevel.index')->with('success_message', 'User Skillmasterylevel was successfully updated!');
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified userskillmasterylevel from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        try {
            $userskillmasterylevel = UserSkillmasterylevel::findOrFail($id);
            $userskillmasterylevel->delete();
            return redirect()->route('userskillmasterylevels.userskillmasterylevel.index')->with('success_message', ' User Skillmasterylevel was successfully deleted!');
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
        $rules = ['user_id' => 'required', 'skill_id' => 'required', 'score' => 'required|numeric|min:-2147483648|max:2147483647', 'masteryLevel' => 'required|numeric|min:-2147483648|max:2147483647', ];
        $data = $request->validate($rules);
        return $data;
    }
}
