<?php

namespace App\React\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

   // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo= '/home';

    /**
     * Create a new controller instance.
     *
     * return void
     */
    public function __construct()
    {
     //   $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * return Response
     */
    public function handleProviderCallback($provider)
    {



      //  dd(Socialite::driver($provider));
        $user = Socialite::driver($provider)->user();
     //  dd($provider);

        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);

        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * param  $user Socialite user object
     * param $provider Social auth provider
     * return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        try {

        $authUser = User::where('provider_id', $user->id)->first();

        if ($authUser) {

            return $authUser;
        }

        if (  strlen ($user->email) >0 ) {

            $authUser = User::where('email', $user->email)->first();

            if( $authUser ){
                $authUser->name= $user->name;
                $authUser->provider= $provider;
                $authUser->provider_id= $user->id;
                $authUser->save();

               return $authUser;
            }


        }

         $newuser=User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);

            userregistred($newuser)    ;
            event (new UserRegistered($newuser));

        return $newuser;
    } catch (Exception $exception) {
            Storage::disk ('local')->append ('faceloginerror.txt','facebook');


}

    }


    public function logins(Request $request){$success=200;
    dd($request->toArray());
        $success=array();
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->remember_token;

            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function forgetpassword (Request $request)
    {
        try {


            $today = date ("Ymd");
            $logsfile = "api_forgetpassword" . $today . ".txt";
            $request = Request::capture ();
            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());
            $data = array();


            $data['email'] = Input::get ('email');

            $validator = $this->forgetpasswordvalidator ($data);

            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse ($messages);


                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

                return json_encode ($responce);

            } else {


                $response = Password::sendResetLink ($request->only ('email'), function (Message $message) {
                    $message->subject ($this->getEmailSubject ());

                });

                $response_json = array();
                $response_json['status'] = "1";
                $response_json['email'] = $data['email'];
                $response_json['message'] = "E-mail password rest was sent ";

                return json_encode ($response_json);


            }


        } catch (Exception $exception) {
            return '{"status":"101:","message":"General error","usertoken":""}';

        }

    }


    protected function forgetpasswordvalidator (array $data)
    {
        return Validator::make (
            $data,
            [

                'email' => 'required|string|email|max:255|exists:users,email',


            ], $this->messagevalidation ()
        );


    }


    private function messagevalidation ()
    {

        return $messages = array(


            'email.required' => '101:Empty Email',
            'email.exists' => '101:the Email not exist in our database',
            'password.required' => '101:Empty Password',
            'email.unique' => '101:Email already exist',
            'email.email' => '101:The email must be a valid email address.',
            'password.min' => '101:The password must be at least 6 characters.',
            'provider.required' => '101:Empty provider.',
            'provider_id.required' => '101:Empty provider_id.',
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' => '101:remember_token not correct.',
            'remember_token.max' => '101:remember_token not correct.',
            'language_id.exists' => '101: language id is not existing',
            'country_id.exists' => '101: Country id is not existing',
            'grade_id.numeric' => '101:The grade id must be a number.',
            'language_id.numeric' => '101:The language  id must be a number.',
            'grade_id.exists' => '101: grade id is not existing',
            'gender.in' => '101:gender must be M or F.',
            'dob.date' => '101:dob must be a date',
            'dob.date_format' => '101: bad dob  date format , m/d/Y',
            'phone.max' => '101: you exceed 25 characters for the phone',
            'mobile.max' => '101: you exceed 25 characters for the mobile',
            'devicetype.max' => '101: you exceed 50 characters for the devicetype',
            'devicetype.required' => '101: Missing device type ',
            'uilanguage_id.exists' => '101: language id is not existing',

            'oldpassword.required' => '101:Empty old password',
            'oldpassword.min' => '101:The old password must be at least 6 characters.',

            'newpassword.required' => '101:Empty new password',
            'newpassword.min' => '101:The new password must be at least 6 characters.',


        );


    }
    private function rendererrorresponse ($message)

    {
        $errorid = substr ($message, 0, 3);
        $errortext = substr ($message, 4);
        $response = array();
        $response['status'] = $errorid;
        $response['message'] = $errortext;
        $response['usertoken'] = "";
        return $response;


    }

    private function renderresponse ($data, $message, $user_id, $user_image)

    {
        $response = array();
        $response['status'] = "1";
        $response['id'] = $user_id;
        $response['message'] = $message;
        $response['user_image'] = $user_image;
        $response['usertoken'] = $data;
        return $response;
        // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }

}
