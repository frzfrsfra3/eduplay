<?php

namespace App\React\Auth;

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
      //  $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * param  array $data
     * return \Illuminate\Contracts\Validation\Validator
     */

    public function signup_date(\Illuminate\Http\Request $request)
    {


            if (isset($_POST['dob'])&& $_POST['dob']!='') {
                $dob = ($request->dob);

                session(['bday' => $dob]);
                $topics = Topic::all();
                return view('auth.signup_topics', compact('topics'));


            }




    }
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

    public function signup_2(Request $request)
    {

        $bday = $request->input('bday');
        $parentmail = $request->input('parentemail');
        $bit_discipline = $request->input('bit_discipline');

        session(['bday' => $bday]);
        session(['parentemail' => $parentmail]);


        return redirect(route('register'));

    }
    public function signup_topics(Request $request)
    {


        session(['bit_topics' => $request->input('bit_topics')]);

       return redirect(route('register'));

    }

    public function parentapproval($code)
    {

        try {
            Storage::disk('local')->append('aprove.txt', 'aprove' . $code);

            $user = User::where('confirmation_code', '=', $code)->first();
            if ($user) return view('users.parentapproval', compact('user', 'code'));


            return view('home');
            //   return ;
        } catch (Exception $exception) {
            Storage::disk('local')->append('aproveerror.txt', $exception);
        }


    }

    public function acceptedbyparent($code)
    {

        try {
            $user = User::where('confirmation_code', '=', $code)->first();
            if ($user) {
                $user->isapproved_byparent = 1;
                $user->save();

            }


            return view('home');

        } catch (Exception $exception) {
            Storage::disk('local')->append('acceptedbyparenterror.txt', $exception);
        }

    }


    public function rejecteddbyparent($code)
    {

        try {
            $user = User::where('confirmation_code', '=', $code)->first();
            if ($user) {
                $user->isapproved_byparent = -1;
                $user->save();
            }
            return view('home');

        } catch (Exception $exception) {
            Storage::disk('local')->append('rejecteddbyparenterror.txt', $exception);
        }

    }

    protected function validator(array $data)
    {

      $age=  Carbon::parse (session('bday'))->age;

      if ($age <13)  {

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'parentmail' => 'required|string|email|max:255',
            'dob' => 'nullable|date|date_format:n/j/Y',
        ]);
      }
      else {
          return Validator::make($data, [
              'name' => 'required|string|max:255',
              'email' => 'required|string|email|max:255|unique:users',
              'password' => 'required|string|min:6|confirmed',
              'parentmail' => 'nullable|string|email|max:255',
              'dob' => 'nullable|date_format:n/j/Y',
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
        if(isset($data['bit_learner']))  {session(['bit_learner' => $data['bit_learner']]);}
        if(isset($data['bit_teacher']))  {session(['bit_teacher' => $data['bit_teacher']]);}
        if(isset($data['bit_parent']))  {session(['bit_parent' => $data['bit_parent']]);}



        $token = base64_encode(random_bytes(64));
        $token = substr(strtr($token, '+/', '-_'), 0, 60);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'parentmail'=> $data['parentmail'],
            'password' => Hash::make($data['password']),
            'remember_token' => $token,
        ]);
        userregistred($user);
        event(new UserRegistered($user));
        return $user;
    }

    public function registers(Request $request)
    {

        $data=$request->input();
        //($request->toArray());

        $token = base64_encode(random_bytes(64));
        $token = substr(strtr($token, '+/', '-_'), 0, 60);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'parentmail'=> $data['parentmail'],
            'password' => Hash::make($data['password']),
            'remember_token' => $token,
            'dob' => $data['dob']
        ]);


        // ad role for users

         if (array_key_exists ('bit_learner',$data) && $data['bit_learner'] == 'on') {
                $user->roles ()->attach (Role::where ('name', 'Learner')->first ());
           }

         if (array_key_exists ('bit_teacher',$data) && $data['bit_teacher'] == 'on') {
                $user->roles ()->attach (Role::where ('name', 'Teacher')->first ());
           }

        if (array_key_exists ('bit_parent',$data) && $data ['bit_parent'] == 'on') {
                $user->roles ()->attach (Role::where ('name', 'Parent')->first ());
            }

        if ($user->roles ()->count () == 0) {
            $user->roles ()->attach (Role::where ('name', 'Learner')->first ());
        }

        if(array_key_exists ('topics',$data)) {
            $topics = $data['topics'];

            foreach ($topics as $topic) {

                $userinterest = new Userinterest;
                $userinterest->user_id = $user->id;
                $userinterest->topic_id = ($topic);
                $userinterest->save();

            }
        }
       // userregistred($user);
        event(new UserRegistered($user));
        return $user;
    }


}
