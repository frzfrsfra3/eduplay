<?php

namespace App\Http\Controllers\User;

use App\Models\Grade;
use App\Models\Language;
use App\Models\User;
use App\Models\Discipline;
use App\Models\Userinterest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Lang;

class UserinterestsController extends Controller
{
    public function __construct()
    {
        // If trying to access this controller without being authenticated, it will ask him for authentication
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the userinterests.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $userinterests = Userinterest::with('discipline', 'user')->paginate(25);

        return view('userinterests.index', compact('userinterests'));
    }

    /**
     * Show the form for creating a new userinterest.
     *
     * return Illuminate\View\View
     */
    public function create()
    {
        $disciplines = Discipline::pluck('discipline_name', 'id')->all();
        $users = User::pluck('id', 'id')->all();

        return view('userinterests.create', compact('disciplines', 'users'));
    }

    /**
     * Store a new userinterest in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $data = $this->getData($request);

            Userinterest::create($data);

            return redirect()->route('userinterests.userinterest.index')
                ->with('success_message', 'Userinterest was successfully added!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified userinterest.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id)
    {
        $userinterest = Userinterest::with('discipline', 'user')->findOrFail($id);

        return view('userinterests.show', compact('userinterest'));
    }

    /**
     * Show the form for editing the specified userinterest.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function editinterest($topic_id)
    {
        if ($user = Auth::user()) {
            $userinterest = Userinterest::where('topic_id', '=', $topic_id)->where('user_id', '=', Auth::user()->id)->first();
            $disciplines = Discipline::where('topic_id', '=', $topic_id)->pluck('discipline_name', 'id')->all();

            if ($disciplines) {
                $grades = Grade::pluck('grade_name', 'id')->all();
                $languages = Language::pluck('language', 'id')->all();
                $grade_id = 0;
                if ($userinterest) {
                    if (($userinterest->discipline_id) != 0) {
                        $discipline = Discipline::where('id', '=', $userinterest->discipline_id)->first();
                        $grades = Grade::where('curriculum_gradelist_id', '=', $discipline->curriculum_gradelist_id)->pluck('grade_name', 'id')->all();

                        $grade_id = $userinterest->grade_id;
                    }
                }

                return view('userinterests.edituserinterest', compact('userinterest', 'disciplines', 'languages', 'grades', 'grade_id', 'topic_id'));
            } else {
                return back()->withInput()
                    ->withErrors(['unexpected_error' => 'No discpine for this topics']);
            }
        } else {
            $disciplines = Discipline::where('topic_id', '=', $topic_id)->pluck('discipline_name', 'id')->all();
            if ($disciplines) {
                $grades = Grade::pluck('grade_name', 'id')->all();
                $languages = Language::pluck('language', 'id')->all();
                $grade_id = 0;

                return view('userinterests.guestinterest', compact('disciplines', 'languages', 'grades', 'grade_id', 'topic_id'));
            } else {
                return back()->withInput()
                    ->withErrors(['unexpected_error' => 'No discipline for this topics']);
            }
        }
    }

    public function edit($id)
    {
        $userinterest = Userinterest::findOrFail($id);
        $disciplines = Discipline::pluck('discipline_name', 'id')->all();
        $users = User::pluck('id', 'id')->all();

        return view('userinterests.edit', compact('userinterest', 'disciplines', 'users'));
    }

    /**
     * Update the specified userinterest in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */

    public function updateinterests(Request $request)
    {
        try {
            if ($user = Auth::user()) {
                $user_id = Auth::user()->id;
                $data = $this->getinterset($request);
                $data['user_id'] = $user_id;
                // grade id not selected.
                if($request->get('grade_id') == null){
                    $data['grade_id'] = null;
                }
                $userinterest = Userinterest::where('user_id', '=', $user_id)->where('topic_id', '=', $data['topic_id'])->first();
                if ($userinterest) {
                    $userinterest->update($data);
                } else {
                    $userinterest = Userinterest::create($data);
                }
                //dd($userinterest->toArray());
                session(['language_id' => $data['language_id']]);
                session(['discipline_id' => $data['discipline_id']]);
                session(['exercise_type' => 1]);
                session(['topic_id' => $data['topic_id']]);
                if( $request->grade_id != null){
                    session(['grade_id' => $data['grade_id']]);
                }
                else{
                    session()->forget('grade_id');
                }
                if ($request->ajax()) {
                    return response()->json([
                        'status' => true,
                        'icon' => 'success',
                        'message' => 'Preferences has been update successfully.'
                    ]);
                } else {
                    return redirect()->route('practice.disciplinepractice', [$userinterest->id]);
                }
            } else {
                if (session()->has('grade_id')) {
                    session()->forget('grade_id');
                }
                $data = $this->getinterset_forguset($request);

                session(['language_id' => $data['language_id']]);
                session(['discipline_id' => $data['discipline_id']]);
                session(['exercise_type' => 1]);
                session(['topic_id' => $data['topic_id']]);
                if ($request->has('grade_id')) {
                    if ($data['grade_id'] <> null) session(['grade_id' => $data['grade_id']]);
                }

                if ($request->ajax()) {
                    return response()->json([
                        'status' => true,
                        'icon' => 'success',
                        'message' => 'Preferences has been update successfully.'
                    ]);
                } else {
                    return redirect()->route('guest.guestpractice');
                }
            }
        } catch (Exception $exception) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'icon' => 'info',
                    'message' => 'Unexpected error occurred while trying to process your request!'
                ]);
            } else {
                return back()->withInput()
                    ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
            }
        }
    }

    public function update($id, Request $request)
    {
        try {
            $data = $this->getData($request);

            $userinterest = Userinterest::findOrFail($id);
            $userinterest->update($data);

            return redirect()->route('userinterests.userinterest.index')
                ->with('success_message', 'Userinterest was successfully updated!');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified userinterest from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $userinterest = Userinterest::findOrFail($id);
            $userinterest->delete();

            return redirect()->route('userinterests.userinterest.index')
                ->with('success_message', 'Userinterest was successfully deleted!');
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
            'discipline_id' => 'required',
            'user_id' => 'required',
        ];

        $data = $request->validate($rules);

        return $data;
    }

    protected function getinterset(Request $request)
    {
        if ($request->grade_id != null) {
            $rules = [
                'discipline_id' => 'required',
                'language_id' => 'required',
                'grade_id' => 'required',
                'exercise_type' => 'required',
                'topic_id' => 'required',
            ];
        } else {
            $rules = [
                'discipline_id' => 'required',
                'language_id' => 'required',
                'exercise_type' => 'required',
                'topic_id' => 'required',
            ];
        }

        $data = $request->validate($rules);

        return $data;
    }

    protected function getinterset_forguset(Request $request)
    {
        $rules = [
            'discipline_id' => 'required',
            'language_id' => 'required',
            'grade_id' => 'nullable',
            'topic_id' => 'required',
        ];

        $data = $request->validate($rules);

        return $data;
    }

    /**
     * Update user topic
     *
     * param Request $request
     * return void
     */
    public function updateUserTopic(Request $request)
    {
        if (Auth::user()) {
            if ($request->ajax()) {
                $userId = Auth::user()->id;
                $topicId = $request->topic_id;
                $data = $request->all();

                $userinterest = Userinterest::where('user_id', '=', $userId)->where('topic_id', '=', $topicId)->first();
                if ($userinterest) {
                    $userinterest = Userinterest::findOrFail($userinterest->id);
                    $userinterest->delete();

                    return response()->json([
                        'status' => true,
                        'icon' => 'success',
                        'action' => 'delete',
                        'message' => Lang::get('topic.topic_has_been_removed')
                    ]);
                } else {
                    $userinterest = Userinterest::create($data);

                    return response()->json([
                        'status' => true,
                        'icon' => 'success',
                        'action' => 'create',
                        'message' => Lang::get('topic.topic_has_been_added')
                    ]);
                }
            }
        } else {
            abort(404);
        }
    }
}
