<?php
namespace App\Http\Controllers\User;

use App\Events\CompleteProfile;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Traits\AddXppoint;
use App\Mail\AlreadyChildPresent;
use App\Mail\InviteChildMail;
use App\Models\Avatar;
use App\Models\Badge;
use App\Models\Country;
use App\Models\Grade;
use App\Models\Inviteduser;
use App\Models\Language;
use App\Models\Pendingtask;
use App\Models\Plan;
use App\Models\Role;
use App\Models\School;
use App\Models\Skillmasterylevel;
use App\Models\Subscription;
use App\Models\Topic;
use App\Models\User;
use App\Models\Useractivitylog;
use App\Models\Userbadge;
use App\Models\Userinterest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
//use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use LogicHelper;
use Session;

class UsersController extends Controller
{

    use AddXppoint;

    public function __construct()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware('auth');
        $this->photos_path = public_path('/images');
    }

    /**
     * Display a listing of the users. only for admin
     ** return Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->hasRole('Admin')) {
            $users = User::paginate(25);
            return view('users.index', compact('users'));
        } else {
            return view('unauthorized');
        }

    }

    /** List Roles */
    public function editrole($id)
    {
        $roles = '';
        $user = User::findOrFail($id);
        return view('users.roles', compact('user', 'roles'));
    }

    // Show the form for creating a new user.
    public function create()
    {
        $providers = 'email';
        $grades = Grade::pluck('grade_name', 'id')->all();
        $schools = School::pluck('school_name', 'id')->all();
        $parents = User::pluck('name', 'id')->all();
        $countries = Country::pluck('country_name', 'id')->all();
        $uilanguages = Language::pluck('language', 'id')->all();
        return view('users.create', compact('providers', 'grades', 'schools', 'parents', 'countries', 'uilanguages'));
    }

    /**
     * Store a new user in the storage.
     ** param Illuminate\Http\Request $request
     ** return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $date = Carbon::parse($request->dob)->format('Y');
            if ($this->AgeCounting($date, 13)) {
                $typeEmail = true;
            } else {
                $typeEmail = false;
            }

            $data = $this->getData($request, $typeEmail);
            //Profile image change
            if ($request->hasFile('user_image')) {
                $image = $request->file('user_image');
                $name = $image->getClientOriginalName();
                $destinationPath = public_path('/assets/images/profiles');
                $image->move($destinationPath, $name);
                $data['user_image'] = $name;
            }

            User::create($data);
            return redirect()->route('users.user.index')->with('success_message', 'User was successfully added!');
        } catch (Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified user.
     ** param int $id
     ** return Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::with('grade', 'school', 'country', 'uilanguage')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function userSubscriptions($id)
    {

    }

    /*
     * Display the specified user profile.
     ** param int $id
     */
    public function getprofile($id)
    {
        if ($id == Auth::user()->id || Auth::user()->hasRole(['Admin'])) {
            $user = User::findOrFail($id);
            $lang = \Session::get('local');
            // if($lang == null){
            //     $lang='en';
            // }
            $countries = Country::Select('country_name', 'country_name_ar', 'id')->orderby('country_name', 'asc')->get();
            // For Level ( Skill mastery level )
            $levels = Skillmasterylevel::orderby('id', 'asc')->get();

            $uilanguages = Language::select('language', 'id')->orderBy('language', 'asc')->get();
            $grades = Grade::select('grade_name', 'id')->orderBy('grade_name', 'asc')->get();
            $lastuseractivitylogs = Useractivitylog::where('user_id', '=', $id)->orderBy('id', 'desc')->first();
            $profile = User::where('id', '=', $id)->select('id', 'name', 'mobile', 'email', 'gender', 'country_id', 'native_language', 'city', 'state', 'aboutme', 'user_image', 'grade_id', 'uilanguage_id', 'dob', 'linkedin_url', 'created_at')->first();
            $children = User::where('parentmail', '=', $user->email)->get();
            // for badges
            $badgesAll = Badge::get();
            // Earn badges
            //$earnedBadges = $user->badges()->orderBy('userbadges.id', 'desc')->latest('id')->first();;
            $earnedBadges = Userbadge::where('user_id', '=', Auth::user()->id)->get();

            $pendings = Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)
            //->where('status', 'like', 'pending')
                ->where('task_type', 1)
                ->get();
            // Task Percentage logic
            $totalTaskPr = LogicHelper::countTask();
            //Age calculate
            if ($profile->dob != null) {
                $date = Carbon::createFromFormat('Y-m-d', $profile->dob);
                $year = $date->year;
            }
            if (isset($year) && $this->AgeCounting($year, 13)) {
                $input_email_type = 'email';
            } else {
                $input_email_type = 'username';
            }

            // Get Avatar list
            $avatarList = Avatar::all();

            // Get User total points
            $userTotalPoints = $user->totalpoints;

            $checkuserAge = Carbon::parse($user->dob)->age;

            $roles = Role::all();

            $userTopics = [];
            foreach ($user->userinterest/*s*/ as $interest) {
                $userTopics[] = $interest->topic_id;
            }

            $topics = Topic::where('approve_status', '=', 'approved')->get();

            return view('eduplaycloud.users.profile', compact('userTotalPoints', 'user', 'countries', 'uilanguages', 'profile', 'grades', 'lastuseractivitylogs', 'children', 'badgesAll', 'pendings', 'totalTaskPr', 'input_email_type', 'avatarList', 'levels', 'earnedBadges', 'checkuserAge', 'roles', 'topics', 'userTopics'));
            // return view('users.profile', compact('user', 'countries', 'uilanguages', 'profile', 'grades', 'lastuseractivitylogs'));

        } else {
            return view('unauthorized');
        }
    }

    public function updateUserInterests(User $user, Request $request)
    {

        // Get All Topics
        $topics = Topic::where('approve_status', '=', 'approved')->get();

        // Get User Topics IDs
        $userTopics = [];
        foreach ($user->userinterest/*s*/ as $interest) {
            $userTopics[] = $interest->topic_id;
        }

        if (count($request->bit_topics) > 0) {
            // Compare and add and delete
            foreach ($topics as $topic) {
                // check if topic is selected
                if (in_array($topic->id, $request->bit_topics)) {
                    if (!in_array($topic->id, $userTopics)) {
                        $interest = new Userinterest;
                        $interest->user_id = $user->id;
                        $interest->topic_id = $topic->id;
                        $interest->save();
                    }
                } else if (!in_array($topic->id, $request->bit_topics)) {
                    if (in_array($topic->id, $userTopics)) {
                        $interest = Userinterest::where(['topic_id' => $topic->id, 'user_id' => $user->id])->get()[0];
                        $interest->delete();
                    }
                }

            }
            return redirect(route('users.user.profile', $user->id) . '#pills-interests');
        }
    }

    //get user badges??
    public function userbadges($id)
    {
        if ($id == Auth::user()->id || Auth::user()->hasRole(['Admin'])) {
            $user = User::findOrFail($id);
            return view('users.userbadges', compact('user'));
        } else {
            return view('unauthorized');
        }

    }

    public function parentapproval($code)
    {
        try {
            Storage::disk('local')->append('aprove.txt', 'aprove' . $code);
            $user = User::where('confirmation_code', '=', $code)->first();
            if ($user) {
                return view('users.parentapproval', compact('user', 'code'));
            }

            return view('home');
            //   return ;

        } catch (Exception $exception) {
            Storage::disk('local')->append('aproveerror.txt', $exception);
        }
    }

    public function updatepicture($id, Request $request)
    {
        try {
            Storage::disk('local')->append('uploadimage.txt', 'start');
            Storage::disk('local')->append('uploadimage.txt', $request);
            if ($request->hasFile('upload-photo')) {
                $path = $this->saveimage($request);
                $user = User::findorfail($id);
                $user->user_image = $path;
                $user->save();
                return response()->json(['file is' => 'present', 'filename' => $path]);
            } else {
                Storage::disk('local')->append('uploadimage.txt', "not file present");
                return response()->json(['file is not' => 'present']);
            }
        } catch (Exception $exception) {
            Storage::disk('local')->append('useruploadimageerror', $exception);
        }
    }

    private function saveimage(Request $request)
    {
        try {
            if ($request->file('upload-photo') != null) {
                $path = Storage::disk('images')->putFile('', $request->file('upload-photo'));
                if (!is_dir($this->photos_path)) {
                    mkdir($this->photos_path, 0777);
                }
                $img = Image::make('Images\\' . $path);
                $img->resize(150, 150);
                $img->save('assets\images\profiles\\' . $path);
                $image_path = 'Images\\' . $path; // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete('Images\\' . $path);
                }
                return $path;
            }
            return '0';
        } catch (Exception $exception) {
            Storage::disk('local')->append('useruploadimageerror', $exception);
        }
    }

    public function addrole($id, $role_name)
    {

        try {
            $user = User::findorfail($id);
            if ($user) {

                $role = Role::where('name', $role_name)->first();
                $plan = Plan::getPlanByRoleId($role->id, 0);

                if ($role->plans->count() > 0) {
                    // Create a subscription for this user
                    $subscription = new Subscription;
                    $subscription->user_id = $user->id;
                    $subscription->plan_id = $plan->id;
                    $subscription->subscribed_at = Carbon::now();
                    $subscription->expired_at = Carbon::now()->addYears(5);
                    $subscription->save();
                }

                $user->roles()->attach($role);
                return "done";
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function removerole($id, $role)
    {
        try {
            $user = User::findorfail($id);

            // delete all subscriptions that belongs to user and role
            foreach ($user->subscriptions as $subscription) {
                if ($subscription->plan->role->name == $role) {
                    $subscription->delete();
                }
            }

            if ($user) {
                $user->roles()->detach(Role::where('name', $role)->first());
                if ($user->roles()->count() == 0) {
                    $user->roles()->attach(Role::where('name', 'Learner')->first());
                }
                return "done";
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function invitefriend($id)
    {
        $user = User::findorfail($id);
        $invitedusers = Inviteduser::where('invitedby', '=', $id)->get();
        if ($user) {
            return view('users.invitefriend', compact('user', 'invitedusers'));
        } else {
            return view('/home');
        }

    }

    public function addchildren($id)
    {
        $user = User::findorfail($id);
        if ($user) {
            $children = User::where('parentmail', '=', $user->email)->get();
            //$grades = Grade::select('grade_name','id')->get();
            $grades = Grade::select('grade_name', 'id')->orderBy('id', 'asc')->get();
            $schools = School::select('school_name', 'id')->get();
            return view('eduplaycloud.users.add-children', compact('user', 'grades', 'schools', 'children'));
            //return view('users.add-children', compact ('user' ,'grades' , 'schools','children'));
        } else {
            return view('/home');
        }
    }

    public function savechild(Request $request, $id)
    {
        try {
            $sender = User::findorfail($id);
            $rendompassword = str_random(8);
            $date = Carbon::createFromFormat('d/m/Y', $request->dob);
            $year = $date->year;
            if ($this->AgeCounting($year, 13)) {
                $request->request->add(['password' => $rendompassword]);
                $request->request->add(['child_password_reset' => 0]);
            } else {
                $request->request->add(['email' => $request->username]);
            }
            $presentChild = User::where('email', $request->email)->where('parentmail', '=', null)->where('parent_id', '=', null)->first();
            if ($presentChild != null) {
                User::where('email', $request->email)->update(['parentmail' => $sender->email, 'parent_id' => $sender->id]);
                Mail::to($request->email)->send(new AlreadyChildPresent($sender, $presentChild));
                Storage::disk('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $request->email);
                Storage::disk('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');

            } else {
                $childWithPerent = User::where('email', $request->email)->first();
                if ($childWithPerent != null) {
                    return Redirect::to('/users/profile/' . $sender->id . '#pills-profile')->with('info_message', 'Child already added with other Perent / Teacher');
                } else {
                    $data = $request->all();
                    $data['dob'] = $date->format('Y-m-d');
                    $data['name'] = $request->child_name;
                    $data['parentmail'] = $sender->email;
                    $data['isapproved_byparent'] = 1;
                    $data['isintroinfo_displayed'] = 0;
                    $data['lastloggedon'] = '';
                    $data['parent_id'] = User::findorfail($id)->id;
                    $token = base64_encode(random_bytes(64));
                    $token = substr(strtr($token, '+/', '-_'), 0, 60);
                    $data['password'] = Hash::make($data['password']);
                    $data['remember_token'] = $token;
                    $data['is_email_active'] = '1';
                    $child = User::create($data);
                    // Call traits
                    $this->add_xp_point(Auth::user()->id, 'addlinkedaccount');
                    $child->roles()->attach(Role::where('name', 'Learner')->first());
                    if ($this->AgeCounting($year, 13)) {
                        $url = route('child-password-change');
                        Mail::to($data['email'])->send(new InviteChildMail($url, $rendompassword, $sender, $child));
                        Storage::disk('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $data['email']);
                        Storage::disk('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');

                    }
                }
                event(new UserRegistered($child));
            }
            // $data= array();
            // $data['sender'] = serialize($sender);
            // $job = (new AddChildJob( $child ))->delay (Carbon::now ()->addSeconds (15));
            // $this->dispatch ($job);
            // return Redirect::to(URL::previous() . "#pills-profile")->with('success_message', 'User was successfully added!');
            return Redirect::to('/users/profile/' . $sender->id . '#pills-profile')->with('success_message', Lang::get('controller.child_add_success'));
        } catch (Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Develop by wc.
     *
     * Return edit child form.
     * param id $id
     * return Redirect
     */
    public function editchild($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $children = User::where('parentmail', '=', $user->email)->get();
            //$grades = Grade::select('grade_name','id')->get();
            $grades = Grade::select('grade_name', 'id')->orderBy('id', 'asc')->get();
            $schools = School::select('school_name', 'id')->get();
            return view('eduplaycloud.users.edit-children', compact('user', 'grades', 'schools', 'children'));
        } else {
            return Redirect::back()->with('info_message', 'Child not available !');
        }
    }

    /**
     * Delete child function.
     *
     */
    public function deletechild($id)
    {
        $children = User::where('id', '=', $id)->where('parent_id', '=', Auth::user()->id)->orWhere('parentmail', '=', Auth::user()->email)->first();
        $parents = Auth::user()->id;

        if (!empty($children)) {
            $updateData = [
                'parent_id' => null,
                'parentmail' => null,
            ];

            User::where('id', '=', $id)->update($updateData);
            return Redirect::to('/users/profile/' . $parents . '#pills-profile')->with('success_message', Lang::get('controller.child_delete_success'));
        } else {
            return Redirect::to('/users/profile/' . $parents . '#pills-profile')->with('success_message', Lang::get('controller.unexpected_error'));
        }

    }

    /**
     * Develop by WC
     *
     * Update child details by Parent / Teacher's.
     *
     * param Illuminate\Http\Request $request
     * param id $user
     * param id $childId
     * return Redirect
     */
    public function updatechild(Request $request, $user, $childId)
    {
        $sender = User::findorfail($user);
        $rendompassword = str_random(8);
        $date = Carbon::createFromFormat('d/m/Y', $request->dob);
        $year = $date->year;
        $password = $request->input('password');
        if ($this->AgeCounting($year, 13)) {
            $request->request->add(['password' => Hash::make($rendompassword)]);
            $request->request->add(['child_password_reset' => 0]);
        } else {
            $request->request->add(['email' => $request->username]);
        }
        $child = User::where('id', $childId)->first();
        $data = $request->all();

        if ($password != "" || !empty($password)) {
            $data['password'] = Hash::make($password);
        }

        $date = Carbon::createFromFormat('d/m/Y', $request->dob);
        $finalDob = Carbon::parse($date)->format('Y-m-d');
        $data['isintroinfo_displayed'] = 0;
        $token = base64_encode(random_bytes(64));
        $token = substr(strtr($token, '+/', '-_'), 0, 60);
        $data['dob'] = $finalDob;
        $data['name'] = $request->child_name;
        $data['remember_token'] = $token;
        $data['is_email_active'] = '1';
        $child->fill($data);
        $child->save();
        if ($this->AgeCounting($year, 13)) {
            $url = route('child-password-change');
            $result = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
            if ($result == true) {
                Mail::to($data['email'])->send(new InviteChildMail($url, $rendompassword, $sender, $child));
                Storage::disk('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $data['email']);
                Storage::disk('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');

            }
        }
        return Redirect::to('/users/profile/' . $sender->id . '#pills-profile')->with('success_message', Lang::get('controller.child_update_success'));
    }

    /**
     *
     * Calclulate  Age limit.
     *
     * param int $childYear
     * param int $minAge
     * return Response
     */
    protected function AgeCounting($childYear, $minAge)
    {
        // or the same using Carbon:
        $currentYear = Carbon::now()->year;
        $diff = (int) $currentYear - (int) $childYear;
        if ($diff >= $minAge) { // Check if diffrence is greater then min age
            return true;
        } else {
            return false;
        }
        // return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
    }

    /**
     * Show the form for editing the specified user.
     * param int $id
     * return Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $grades = Grade::pluck('grade_name', 'id')->all();
        $schools = School::pluck('school_name', 'id')->all();
        $parents = User::pluck('name', 'id')->all();
        $countries = Country::pluck('country_name', 'id')->all();
        $uilanguages = Language::pluck('language', 'id')->all();
        return view('users.edit', compact('user', 'providers', 'grades', 'schools', 'parents', 'countries', 'uilanguages'));
    }

    /**
     * Show Children List
     * param int $id
     * return Illuminate\View\View
     */
    public function childrenlist($id)
    {
        $user = User::findorfail($id);
        if ($user) {
            $children = User::where('parentmail', '=', $user->email)->get();
            return view('users.childrenlist', compact('children'));
        } else {
            return view('/home');
        }
    }

    /**
     * Update the specified user in the storage.
     * param  int $id
     * param Illuminate\Http\Request $request
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            //Profile image change
            if ($request->hasFile('user_image')) {
                $image = $request->file('user_image');
                $name = $image->getClientOriginalName();
                $destinationPath = public_path('/assets/images/profiles');
                $image->move($destinationPath, $name);
            }
            // $date = Carbon::createFromFormat('d/m/Y', $request->dob);
            $date = Carbon::parse($request->dob)->format('Y');
            if ($this->AgeCounting($date, 13)) {
                $typeEmail = true;
            } else {
                $typeEmail = false;
            }

            $data = $this->getData($request, $typeEmail);
            $user = User::findOrFail($id);
            if ($request->update_password !== null) {
                $data['password'] = Hash::make($request->get('update_password'));
            }

            if ($request->hasFile('user_image')) {
                $data['user_image'] = $name;
            }
            $user->update($data);
            return redirect()->route('users.user.index')->with('success_message', Lang::get('messages.user_updated'));
        } catch (Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Update Profile
     *
     * param Illuminate\Http\Request $request
     * param int $id
     * return Redirect
     */
    public function updateprofile($id, Request $request)
    {
        try {
            if ($request->hasFile('user_image')) {
                $image = $request->file('user_image');
                //$name = time().'.'.$image->getClientOriginalExtension();
                $name = $image->getClientOriginalName();
                $destinationPath = public_path('/assets/images/profiles');
                //$destinationPath = public_path('/uploads/profile');
                $image->move($destinationPath, $name);
            }
            //Child update his profile
            if (empty($request->email)) {
                $request->request->add(['email' => $request->username]);
            }

            $data = array();
            $data = $request->all();
            // $newDate = Carbon::createFromFormat('d/m/Y', $request->dob);
            // $data['dob'] = $newDate->format('Y-m-d');
            if ($request->hasFile('user_image')) {
                $data['user_image'] = $name;
            }
            $user = User::findOrFail($id);
            $user->update($data);
            $profile = User::where('id', '=', $id)->select('id', 'name', 'mobile', 'email', 'gender', 'country_id', 'user_image', 'grade_id', 'uilanguage_id', 'dob', 'aboutme', 'native_language', 'linkedin_url', 'city', 'state')->first();
            $profilepersent = $user->calculate_profile($profile);
            event(new CompleteProfile($profilepersent));
            //return "called";
            return redirect()->route('users.user.profile', $id)->with('success_message', Lang::get('messages.user_updated'));
        } catch (Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified user from the storage.
     ** param  int $id
     ** return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $folder = public_path() . '/assets/eduplaycloud/upload/exercisesset/user-' . $id;
            File::deleteDirectory($folder);

            $user->delete();
            return redirect()->route('users.user.index')->with('success_message', 'User was successfully deleted!');
        } catch (Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            dd(response()->json(['success' => $success], $this->successStatus));
        } else {
            dd(response()->json(['error' => 'Unauthorised'], 401));
        }
    }

    /**
     * Get the request's data from the request.
     ** param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData(Request $request, $typeEmail = null)
    {
        if (isset($request->password)) {
            if ($typeEmail) {
                $rules = ['name' => 'required|string|min:1|max:250', 'email' => 'required|string|email|max:255|unique:users,id', 'provider' => 'nullable|string|min:0|max:500', 'provider_id' => 'nullable', 'mobile' => 'nullable|string|min:0|max:50', 'gender' => 'nullable', 'password' => 'required|string|min:6', 'isactive' => 'boolean', 'lastloggedon' => 'nullable|date_format:j/n/Y g:i A', 'registeredon' => 'nullable|date_format:j/n/Y g:i A', 'isverified' => 'boolean', 'role_type_id' => 'nullable', 'grade_id' => 'nullable', 'school_id' => 'nullable', 'parent_id' => 'nullable', 'country_id' => 'nullable|numeric|min:0|max:4294967295', 'uilanguage_id' => 'nullable|numeric|min:0|max:4294967295', 'dob' => 'nullable|date|date_format:Y-m-d', 'phone' => 'nullable|string|min:0|max:50', 'parentmail' => 'nullable|string|min:0|max:50', 'isapproved_byparent' => 'boolean', 'isintroinfo_displayed' => 'boolean', 'passwordtoken' => 'nullable|string|min:0|max:100', 'registeredby' => 'required', 'totalpoints' => 'required|numeric|min:0|max:2147483647', 'quota' => 'nullable', 'remember_token' => 'nullable|string|min:0|max:100'];
            } else {
                $rules = ['name' => 'required|string|min:1|max:250', 'email' => 'required|string|max:255|unique:users,id', 'provider' => 'nullable|string|min:0|max:500', 'provider_id' => 'nullable', 'mobile' => 'nullable|string|min:0|max:50', 'gender' => 'nullable', 'password' => 'required|string|min:6', 'isactive' => 'boolean', 'lastloggedon' => 'nullable|date_format:j/n/Y g:i A', 'registeredon' => 'nullable|date_format:j/n/Y g:i A', 'isverified' => 'boolean', 'role_type_id' => 'nullable', 'grade_id' => 'nullable', 'school_id' => 'nullable', 'parent_id' => 'nullable', 'country_id' => 'nullable|numeric|min:0|max:4294967295', 'uilanguage_id' => 'nullable|numeric|min:0|max:4294967295', 'dob' => 'nullable|date|date_format:Y-m-d', 'phone' => 'nullable|string|min:0|max:50', 'parentmail' => 'nullable|string|min:0|max:50', 'isapproved_byparent' => 'boolean', 'isintroinfo_displayed' => 'boolean', 'passwordtoken' => 'nullable|string|min:0|max:100', 'registeredby' => 'required', 'totalpoints' => 'required|numeric|min:0|max:2147483647', 'quota' => 'nullable', 'remember_token' => 'nullable|string|min:0|max:100'];
            }
        } else {
            if ($typeEmail) {
                $rules = ['name' => 'required|string|min:1|max:250', 'email' => 'required|string|email|max:255|unique:users,id', 'provider' => 'nullable|string|min:0|max:500', 'provider_id' => 'nullable', 'mobile' => 'nullable|string|min:0|max:50', 'gender' => 'nullable', 'update_password' => 'nullable|string|min:6', 'isactive' => 'boolean', 'lastloggedon' => 'nullable|date_format:j/n/Y g:i A', 'registeredon' => 'nullable|date_format:j/n/Y g:i A', 'isverified' => 'boolean', 'role_type_id' => 'nullable', 'grade_id' => 'nullable', 'school_id' => 'nullable', 'parent_id' => 'nullable', 'country_id' => 'nullable|numeric|min:0|max:4294967295', 'uilanguage_id' => 'nullable|numeric|min:0|max:4294967295', 'dob' => 'nullable|date|date_format:Y-m-d', 'phone' => 'nullable|string|min:0|max:50', 'parentmail' => 'nullable|string|min:0|max:50', 'isapproved_byparent' => 'boolean', 'isintroinfo_displayed' => 'boolean', 'passwordtoken' => 'nullable|string|min:0|max:100', 'registeredby' => 'required', 'totalpoints' => 'required|numeric|min:0|max:2147483647', 'quota' => 'nullable', 'remember_token' => 'nullable|string|min:0|max:100'];
            } else {
                $rules = ['name' => 'required|string|min:1|max:250', 'email' => 'required|string|max:255|unique:users,id', 'provider' => 'nullable|string|min:0|max:500', 'provider_id' => 'nullable', 'mobile' => 'nullable|string|min:0|max:50', 'gender' => 'nullable', 'update_password' => 'nullable|string|min:6', 'isactive' => 'boolean', 'lastloggedon' => 'nullable|date_format:j/n/Y g:i A', 'registeredon' => 'nullable|date_format:j/n/Y g:i A', 'isverified' => 'boolean', 'role_type_id' => 'nullable', 'grade_id' => 'nullable', 'school_id' => 'nullable', 'parent_id' => 'nullable', 'country_id' => 'nullable|numeric|min:0|max:4294967295', 'uilanguage_id' => 'nullable|numeric|min:0|max:4294967295', 'dob' => 'nullable|date|date_format:Y-m-d', 'phone' => 'nullable|string|min:0|max:50', 'parentmail' => 'nullable|string|min:0|max:50', 'isapproved_byparent' => 'boolean', 'isintroinfo_displayed' => 'boolean', 'passwordtoken' => 'nullable|string|min:0|max:100', 'registeredby' => 'required', 'totalpoints' => 'required|numeric|min:0|max:2147483647', 'quota' => 'nullable', 'remember_token' => 'nullable|string|min:0|max:100'];
            }
        }
        $data = $request->validate($rules);
        // Boolean values are not in the request if checkbox is not checked that's why you need to add them to data
        $data['isactive'] = $request->has('isactive');
        $data['isverified'] = $request->has('isverified');
        $data['isapproved_byparent'] = $request->has('isapproved_byparent');
        $data['isintroinfo_displayed'] = $request->has('isintroinfo_displayed');
        return $data;
    }

    protected function getprofileData(Request $request)
    {
        $rules = ['name' => 'required|string|min:1|max:250', 'email' => 'required||string|min:1|max:25', 'mobile' => 'nullable|string|min:0|max:50', 'gender' => 'nullable', 'registeredon' => 'nullable|date_format:j/n/Y g:i A', 'country_id' => 'nullable|numeric|min:0|max:4294967295', 'grade_id' => 'nullable|numeric|min:0|max:4294967295', 'uilanguage_id' => 'nullable|numeric|min:0|max:4294967295', 'dob' => 'nullable', 'phone' => 'nullable|string|min:0|max:50', 'parentmail' => 'nullable|string|min:0|max:50', 'aboutme' => 'nullable', 'native_language' => 'nullable', 'linkedin_url' => 'nullable', 'city' => 'nullable', 'state' => 'nullable'];
        $data = $request->validate($rules);
        return $data;
    }

    /**
     * Validate user password
     *
     * param Request $request
     * return void
     */
    public function validatePassword(Request $request)
    {
        if (!Hash::check($request->value, Auth::user()->password)) {
            echo "false";
        } else {
            echo "true";
        }
    }

    /**
     * Change password
     *
     * param Request $request
     * return void
     */
    public function changePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        Auth::user()->password = Hash::make($request->get('password'));
        if (Auth::user()->save()) {
            return response(['success' => true, 'icon' => 'success', 'message' => Lang::get('controller.pwd_update_success')]);
        } else {
            return response(['success' => false, 'icon' => 'info', 'message' => Lang::get('controller.oops_something_wrong')]);
        }
    }

    /**
     * Develop by WC
     *
     * change password for child
     *
     */
    /**
     * Change password
     *
     * param Request $request
     * return void
     */
    public function childChangePassword(Request $request)
    {

        $user = User::find(Auth::user()->id);
        if ($user->child_password_reset === 0) {
            Auth::user()->password = Hash::make($request->get('password'));
            Auth::user()->child_password_reset = 1;
            if (Auth::user()->save()) {
                return redirect()->route('users.user.profile', [Auth::user()->id])->with('success_message', Lang::get('controller.pwd_update_success'));
            } else {
                return redirect()->back()->with('error_message', Lang::get('controller.oops_something_wrong'));
            }
        } else {
            return redirect()->route('users.user.profile', [Auth::user()->id])->with('info_message', Lang::get('controller.alredy_change_for_first_time'));
        }
    }
}
