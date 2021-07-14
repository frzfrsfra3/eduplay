<?php

namespace App\Http\Controllers\Auth;

use App\Models\Discipline;
use App\Models\User;
use App\Models\Topic;
use App\Models\Userinterest;
use App\Models\Role;
use App\Http\Controllers\Controller;
//use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Hash;
use App\Events\UserRegistered;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Lang;
use Auth;
use App\Http\Traits\AddXppoint;
use Mail;
use App\Mail\VerifiedEmail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */
    use RegistersUsers;
    use AddXppoint;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * param  array $data
     * return \Illuminate\Contracts\Validation\Validator
     */
    public function signup_date(\Illuminate\Http\Request $request)
    {
        if (isset($_POST['dob']) && $_POST['dob'] != '') {
            $dob = ($request->dob);

            session(['bday' => $dob]);
            $topics = Topic::all();
            return view('auth.signup_topics', compact('topics'));
        }
    }

    /**
     * Undocumented function
     *
     * param \Illuminate\Http\Request $request
     * return void
     */
    public function signup_1(\Illuminate\Http\Request $request)
    {
        $bit_learner = $request->input('bit_learner');
        $bit_teacher = $request->input('bit_teacher');
        $bit_parent = $request->input('bit_parent');

        session(['bit_learner' => $bit_learner]);
        session(['bit_teacher' => $bit_teacher]);
        session(['bit_parent' => $bit_parent]);
        $disciplines = Discipline::all();

        return view('auth.signup_2', compact('disciplines'));
    }
    
    /**
     * Undocumented function
     *
     * param Request $request
     * return void
     */
    public function signup_2(Request $request)
    {
        $bday = $request->input('bday');
        $parentmail = $request->input('parentemail');
        $bit_discipline = $request->input('bit_discipline');

        session(['bday' => $bday]);
        session(['parentemail' => $parentmail]);

        return redirect(route('register'));
    }

    /**
     * Undocumented function
     *
     * param Request $request
     * return void
     */
    public function signup_topics(Request $request)
    {
        session(['bit_topics' => $request->input('topics')]);

        return redirect(route('register'));
    }

    /**
     * Undocumented function
     *
     * param [type] $code
     * return void
     */
    public function parentapproval($code)
    {
        try {
            
            Storage::disk('local')->append('aprove.txt', 'aprove' . $code);

            $user = User::where('confirmation_code', '=', $code)->first();
            if ($user) return view('users.parentapproval', compact('user', 'code'));

            return redirect(route('welcome'));
        } catch (Exception $exception) {
            //return $code;
            Storage::disk('local')->append('aproveerror.txt', $exception);
        }
    }

    /**
     * Undocumented function
     *
     * param [type] $code
     * return void
     */
    public function acceptedbyparent(Request $request, $code)
    {
        try {
            $user = User::where('confirmation_code', '=', $code)->first();
            if ($user) {
                $user->isapproved_byparent = 1;
                $user->confirmation_code = '';
                $user->save();
            }

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'icon' => 'success',
                    'message' => Lang::get('register_request_accepted')
                ]);
            } else {
                return redirect('/home');
            }
        } catch (Exception $exception) {
            Storage::disk('local')->append('acceptedbyparenterror.txt', $exception);
        }
    }

    /**
     * Undocumented function
     *
     * param [type] $code
     * return void
     */
    public function rejecteddbyparent(Request $request, $code)
    {
        try {
            $user = User::where('confirmation_code', '=', $code)->first();
            if ($user) {
                $user->isapproved_byparent = -1;
                $user->confirmation_code = '';
                $user->save();
            }

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'icon' => 'success',
                    'message' => Lang::get('controller.register_request_rejected')
                ]);
            } else {
                return redirect('/home');
            }
        } catch (Exception $exception) {
            Storage::disk('local')->append('rejecteddbyparenterror.txt', $exception);
        }
    }

    /**
     * Undocumented function
     *
     * param array $data
     * return void
     */
    protected function validator(array $data)
    {
        $age = Carbon::parse(session('bday'))->age;

        if ($age < 13) {
            return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'parentmail' => 'required|string|email|max:255',
            ]);
        } else {
            return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'parentmail' => 'nullable|string|email|max:255',
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * param  array $data
     * return \App\Models\User
     */
    protected function create(array $data)
    {
        if (isset($data['bit_learner'])) {
            session(['bit_learner' => $data['bit_learner']]);
        }
        if (isset($data['bit_teacher'])) {
            session(['bit_teacher' => $data['bit_teacher']]);
        }
        if (isset($data['bit_parent'])) {
            session(['bit_parent' => $data['bit_parent']]);
        }

        $token = base64_encode(random_bytes(64));
        $token = substr(strtr($token, '+/', '-_'), 0, 60);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'parentmail' => $data['parentmail'],
            'password' => Hash::make($data['password']),
            'remember_token' => $token,
        ]);

        userregistred($user);
        event(new UserRegistered($user));
        return $user;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * param  array $data
     * return \App\Models\User
     */
    protected function registerNewUser(Request $request)
    {
        // Clear old session data
        \Session::forget(['bday', 'bit_topics', 'parentemail', 'bit_learner', 'bit_teacher', 'bit_parent']);

        // Get ajax request data
        $userData = $request->userDetails;
        $userData = parse_str($userData, $userDataArr);
        $dateOfBirth = str_replace('/', '-', $request->dateOfBirth);
        $dateOfBirth = date('Y-m-d', strtotime($dateOfBirth));

        // Store value to session as per old logic
        session(['bday' => $dateOfBirth]);
        session(['bit_topics' => $request->topics]);
        if (isset($request->parentEmail) && !empty($request->parentEmail)) {
            $parentmail = $request->parentEmail;
            session(['parentemail' => $parentmail]);
        } else {
            $parentmail = null;
        }
        
        if (isset($userDataArr['role']) && !empty($userDataArr['role'])) {
            if (in_array("1", $userDataArr['role'])) {
                session(['bit_learner' => 'on']);
            }
            if (in_array("2", $userDataArr['role'])) {
                session(['bit_teacher' => 'on']);
            }
            if (in_array("3", $userDataArr['role'])) {
                session(['bit_parent' => 'on']);
            }
        }

        // Create token for remember token
        $token = base64_encode(random_bytes(64));
        $token = substr(strtr($token, '+/', '-_'), 0, 60);

        //dd($userDataArr,$parentmail,$token);
        // Create user
        $user = User::create([
            'name' => $userDataArr['name'],
            'email' => $userDataArr['email'],
            'parentmail' => $parentmail,
            'password' => Hash::make($userDataArr['password']),
            'remember_token' => $token,
            'verified_token' => $token,
            'is_email_active' => '0',
        ]);


        // Call helper
        userregistred($user);

        $role = $user->roles()->first()->name;

        // For Add xppoints(Badges)
        $this->add_xp_point($user->id, 'signup',$role);

        // Run event
        event(new UserRegistered($user));

        if (isset($request->parentEmail) && !empty($request->parentEmail)) {
            $email = $request->parentEmail;
        } else {
            $email = $user->email;
        }
        if(filter_var($email, FILTER_VALIDATE_EMAIL) == true)
        {

            Mail::to($email)->send(new VerifiedEmail($user, $user->verified_token));
            Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $email );
            Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    
            if (false) {
                return 'Mail send unsuccessfully!';
            } else {
                if ($user) {
                    if($user->parentmail != null){
                        $child = false;
                    }else{
                        $child = true;
                    }
                    return response(['status' => true, 'icon' => 'success', 'message' => Lang::get('controller.account_created_successfully'),'child'=>$child]);
                } else {
                    return response(['status' => false, 'icon' => 'info', 'message' => Lang::get('controller.oops_something_wrong')]);
                }
            }
        }else{
            $user = User::where('id','=', $user->id)->update(['is_email_active' => '1']);
            return response(['status' => true, 'icon' => 'success', 'message' => Lang::get('controller.account_created_successfully'),'child'=>'withname']);
        }
    }

    /**
     * Reset Password
     * 
     * param Illuminate\Http\Request $request
     * return Redirect
     */
    public function reset(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user_id = $user->id;
        $obj_user = User::find($user_id);
        $obj_user->password = Hash::make($request->password);
        $obj_user->isapproved_byparent = 1;
        $obj_user->save();

        $userdata = array(
            'email' => $request->email ,
            'password' => $request->password
        );
        // attempt to do the login
        if (Auth::attempt($userdata))
        {
            return redirect()->route('exercisesets.exerciseset.private');
        }
    }

    /**
     * Active Your Account
     */
    public function verifyAccount($email,$token){
        $user = User::where('email', $email)->where('verified_token',$token)->first();
        if($user){
            $user = User::where('email','=', $email)->where('verified_token','=',$token)->update(['is_email_active' => '1']);
            return redirect()->route('arrprovedAccount')->with('success', 'Your account activited success !!');
        }

    }

    /**
     * Undocumented function
     *
     * param [type] $email
     * param [type] $token
     * return void
     */
    public function arrprovedAccount(){
        $topics = Topic::all();
        return view('arrprovedAccount', compact('topics'));
    }
}
