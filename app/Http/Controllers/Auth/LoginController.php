<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use Log;
use Illuminate\Support\Facades\Storage;
use Response;
use Illuminate\Support\Facades\Lang;
use File;

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
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/exercisesets/private';

    /**
     * Create a new controller instance.
     *
     * return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Socialite redirect
     *
     * param [type] $provider
     * return void
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Login user
     *
     * param Request $request
     * return void
     */
    public function login(Request $request)
    {
        $user = User::where('email','=',$request->email)->first();
        if(!is_null($user))
        {

            // Check for the uploads folder.
            $uploadFolder =  public_path('assets/eduplaycloud/upload');
            if(!is_dir($uploadFolder)) { 
                File::makeDirectory('assets/eduplaycloud', 0777, true, true);
                File::makeDirectory('assets/eduplaycloud/upload', 0777, true, true);
            }

            // Create Assets folder for exsting user.
            $path = public_path('assets/eduplaycloud/upload/exercisesset/user-'.$user->id);
            if(!is_dir($path)) {
                File::makeDirectory($path, 0777, true, true);
                File::makeDirectory($path.'/image',$mode = 0777, true, true);
                File::makeDirectory($path.'/audio', $mode = 0777, true, true);
                File::makeDirectory($path.'/csv', $mode = 0777, true, true);
            }

            // If user found then
            if($user->is_email_active == '1'  ){
                // If user is_email_active 1 then login process start.
                $credentials = $request->only($this->username(), 'password');
                //dd($credentials);
                //$authSuccess = Auth::attempt($credentials, $request->has('remember'));
                $authSuccess = Auth::attempt(['email' => $request->email, 'password' => $request->password,'isapproved_byparent' => 1]);
                
                if ($authSuccess) {
                    return response([
                          'success' => true,
                          'role' => auth()->user()->roles()->first()->name
                          ]);
                }
                
                return response([
                'success' => false,
                'messages' => Lang::get('controller.email_not_active'),
                //'msg' => $authSuccess,
                //'email' => $request->email,
                //'password' => $request->password
                ]);

            } 
            else 
            {
                // If user is_email_active 0 then activation require
                return response([
                'success' => false,
                'messages' => Lang::get('controller.email_active_require'),
                //'msg' => 'email_active_require'
                ]);
            }

        } else {
            // If user not found then
            return response([
                'success' => false,
                'messages' => Lang::get('controller.email_not_active'),
                //'msg' => 'not found'
            ]);
        }
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * return Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }

        $user = Socialite::driver($provider)->stateless()->user();

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

            if (isset($user->avatar) && !empty($user->avatar)) {
                $picture = $user->avatar;
            } else {
                $picture = 'profile_img.jpg';
            }

            if (strlen($user->email) > 0) {
                $authUser = User::where('email', $user->email)->first();

                if ($authUser) {
                    $authUser->name = $user->name;
                    $authUser->provider = $provider;
                    $authUser->provider_id = $user->id;
                    $authUser->user_image = $picture;
                    $authUser->save();

                    return $authUser;
                }
            }

            $newuser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'provider' => $provider,
                'provider_id' => $user->id,
                'user_image' => $picture,
            ]);

            userregistred($newuser);
            event(new UserRegistered($newuser));

            return $newuser;
        } catch (Exception $exception) {
            Storage::disk('local')->append('faceloginerror.txt', 'facebook');
        }
    }

    /**
     * Show the application's login form.
     *
     * return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        \Redirect::to('welcome')->send();
    }
}
