<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\React\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginActivity;
use Illuminate\Auth\Passwords\PasswordBroker;


use Log;
use File;
use Illuminate\Support\Facades\Storage;


class APIRegisterUser extends Controller
{

    public function register ()
    {
        try {

            $request = Request::capture ();
            $imagespath = public_path ('/assets/images/profiles/');
            $imagesurl = url ('/assets/images/profiles/');
            Storage::disk ('local')->append ('api.register.txt', $request);
            Storage::disk ('local')->append ('api.register.txt', 'Ip:' . $request->ip ());

            $data = array();
            $data['name'] = Input::get ('username');
            $data['email'] = Input::get ('email');
            $data['password'] = Input::get ('password');
            $data['provider'] = Input::get ('provider');
            $data['provider_id'] = Input::get ('provider_id');

            /* perefrences  */
            $data['grade_id'] = Input::get ('grade_id');
            $data['language_id'] = Input::get ('language_id');


            $data['mobile'] = Input::get ('mobile');
            $data['phone'] = Input::get ('phone');
            $data['gender'] = Input::get ('gender');
            $data['dob'] = Input::get ('dob');
            $data['devicetype'] = Input::get ('devicetype');
            $data['country_id'] = Input::get ('country_id');

            /*****************************/

            $data['registeredby'] = 'API';


            if (strlen (Input::get ('remember_token')) <> 0) {
                $data['remember_token'] = Input::get ('remember_token');
            } else {
                $token = base64_encode (random_bytes (64));
                $token = substr (strtr ($token, '+/', '-_'), 0, 60);
                $data['remember_token'] = $token;
            }


            $validator = $this->validator ($data);

            if ($validator->fails ()) {
                $messages = $validator->errors ()->first ();


                $responce = $this->rendererrorresponse ($messages);


            } else {

                //  return $data;
                $user = $this->create ($data);

                if (strlen ($user->user_image) > 0 && File::exists ($imagespath . "/" . $user->user_image)) {
                    $userimage = $user->user_image;
                } else {


                    $userimage = 'userdefaultimg.png';
                }

                $user_image = $imagesurl . "/" . $userimage;
                $country_id=$user->country_id;
                $responce = $this->renderresponselogin ($data['remember_token'], "SuccessfullyRegister", $user->id, $user_image,$country_id);

            }
            //
            Storage::disk ('local')->append ('api.register.txt', "responce:\r\n" . json_encode ($responce));
            Storage::disk ('local')->append ('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
            //    $responce = str_replace ("\r\n", "<br>", $responce);
            return json_encode ($responce);


        } catch (Exception $exception) {
            return '{"status":"101:","message":"General error","usertoken":""}';

        }
    }


    public function login ()
    {

        try {
            $today = date ("Ymd");
            // dd($today);

            $imagespath = public_path ('/assets/images/profiles/');
            $imagesurl = url ('/assets/images/profiles/');

            $request = Request::capture ();
            Storage::disk ('local')->append ('api.login' . $today . '.txt', $request);
            Storage::disk ('local')->append ('api.login' . $today . '.txt', 'Ip:' . $request->ip ());

            $data = array();
            $data['email'] = Input::get ('email');
            $data['password'] = Input::get ('password');
            $data['devicetype'] = Input::get ('devicetype');
            $validator = $this->loginvalidator ($data);

            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse ($messages);


                Storage::disk ('local')->append ('api.login' . $today . '.txt', "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ('api.login' . $today . '.txt', '------------------------------------------------------------------------------------------------------------------------------------');


                return json_encode ($responce);


            } else {

                $user = User::select ('id', 'name', 'password', 'remember_token', 'user_image','country_id')
                    ->where ('email', '=', $data['email'])->first ();


                if ($user && Hash::check ($data['password'], $user->password)) {


                    // here you know data is valid
                    Storage::disk ('local')->append ('api.login' . $today . '.txt', $user->toJson ());
                    Storage::disk ('local')->append ('api.login' . $today . '.txt', '------------------------------------------------------------------------------------------------------------------------------------');
                    $this->loginactivity ($user->id);
                    $user_id = $user->id;

                    if (strlen ($user->user_image) > 0 && File::exists ($imagespath . "/" . $user->user_image)) {
                        $userimage = $user->user_image;
                    } else {
                        $userimage = 'userdefaultimg.png';
                    }
                    $user_image = $imagesurl . "/" . $userimage;
                    $country_id=$user->country_id;

                    $user = $user->toarray ();
                    unset($user['id']);
                    unset($user['password']);

                    $responce = $this->renderresponselogin ($user['remember_token'], "Successfully Log In", $user_id, $user_image,$country_id);
                    $this->savedivetype ($user_id, $data['devicetype']);
                    return json_encode ($responce);

                } else {

                    $messages = "101: User not exist";
                    $responce = $this->rendererrorresponse ($messages);

                    Storage::disk ('local')->append ('api.login' . $today . '.txt', "responce:\r\n" . json_encode ($responce));
                    Storage::disk ('local')->append ('api.login' . $today . '.txt', '------------------------------------------------------------------------------------------------------------------------------------');

                    return json_encode ($responce);

                }

            }
        } catch (Exception $exception) {
            return '{"status":"101:","message":"General error","usertoken":""}';

        }


    }


    public function loginsocialmedia ()
    {

        try {
            $imagespath = public_path ('/assets/images/profiles/');
            $imagesurl = url ('/assets/images/profiles/');

            $today = date ("Ymd");
            $logsfile = "loginsocialmedia" . $today . ".txt";
            $request = Request::capture ();
            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());
            $data = array();

            $data['email'] = Input::get ('email');
            $data['provider'] = Input::get ('provider');
            $data['provider_id'] = Input::get ('provider_id');
            $data['devicetype'] = Input::get ('devicetype');

            if (strlen (Input::get ('remember_token')) <> 0) {
                $data['remember_token'] = Input::get ('remember_token');
            } else {
                $token = base64_encode (random_bytes (64));
                $token = substr (strtr ($token, '+/', '-_'), 0, 60);
                $data['remember_token'] = $token;
            }
            $data['name'] = Input::get ('username');
            $validator = $this->loginsocialmediavalidator ($data);
            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse ($messages);


                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

                return json_encode ($responce);

            } else {


                $user = User::select ('id', 'name', 'password', 'remember_token')
                    ->where ('email', '=', $data['email'])->first ();
                if ($user) {
                    $this->save ($data, $user->id);
                    $this->loginactivity ($user->id);
                    $user = User::select ('id', 'name', 'remember_token', 'user_image')->findorfail ($user->id);
                    Storage::disk ('local')->append ($logsfile, $user->toJson ());
                    Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                    $this->savedivetype ($user->id, $data['devicetype']);

                    if (strlen ($user->user_image) > 0 && File::exists ($imagespath . "/" . $user->user_image)) {
                        $userimage = $user->user_image;
                    } else {
                        $userimage = 'userdefaultimg.png';
                    }
                    $user_image = $imagesurl . "/" . $userimage;


                    $responce = $this->renderresponse ($user->remember_token, "Successfully Log In", $user->id, $user_image);
                    return json_encode ($responce);
                    //return   ($user->remember_token);
                } else {
                    $user = User::select ('id', 'name', 'password', 'remember_token')
                        ->where ('provider', '=', $data['provider'])
                        ->where ('provider_id', '=', $data['provider_id'])
                        ->first ();
                    if ($user) {
                        $this->save ($data, $user->id);
                        $this->loginactivity ($user->id);
                        $user = User::select ('name', 'remember_token', 'user_image', 'id')->findorfail ($user->id);

                        if (strlen ($user->user_image) > 0 && File::exists ($imagespath . "/" . $user->user_image)) {
                            $userimage = $user->user_image;
                        } else {
                            $userimage = 'userdefaultimg.png';
                        }
                        $user_image = $imagesurl . "/" . $userimage;


                        Storage::disk ('local')->append ($logsfile, $user->toJson ());
                        Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                        $this->savedivetype ($user->id, $data['devicetype']);
                        $responce = $this->renderresponse ($user->remember_token, "Successfully Log In", $user->id, $user_image);
                        return json_encode ($responce);

                    } else {
                        $data['registeredby'] = 'API';
                        $data['password'] = "";
                        $user = $this->create ($data);
                        $user = User::select ('id', 'name', 'remember_token', 'user_image')->findorfail ($user->id);
                        if (strlen ($user->user_image) > 0 && File::exists ($imagespath . "/" . $user->user_image)) {
                            $userimage = $user->user_image;
                        } else {
                            $userimage = 'userdefaultimg.png';
                        }
                        $user_image = $imagesurl . "/" . $userimage;


                        $this->loginactivity ($user->id);
                        Storage::disk ('local')->append ($logsfile, $user->toJson ());
                        Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

                        $responce = $this->renderresponse ($user->remember_token, "Successfully Log In", $user->id, $user_image);
                        $this->savedivetype ($user->id, $data['devicetype']);
                        return json_encode ($responce);
                        //  return   ($user->remember_token);
                    }
                }

            }
        } catch (Exception $exception) {
            return '{"status":"101:","message":"General error","usertoken":""}';

        }
    }

    public function changepassword ()
    {

        try {

            $imagespath = public_path ('/assets/images/profiles/');
            $imagesurl = url ('/assets/images/profiles/');

            $today = date ("Ymd");
            $logsfile = "api_changepassword" . $today . ".txt";
            $request = Request::capture ();
            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());
            $data = array();

            $data['email'] = Input::get ('email');
            $data['remember_token'] = Input::get ('remember_token');
            $data['oldpassword'] = Input::get ('oldpassword');
            $data['newpassword'] = Input::get ('newpassword');

            $validator = $this->changepasswordvalidator ($data);

            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse ($messages);


                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                // $responce = str_replace ("\r\n", "<br>", $responce);
                return json_encode ($responce);

            } else {

                $user = User:: where ('email', '=', $data['email'])->where ('remember_token', '=', $data['remember_token'])->select ('id', 'name', 'password', 'remember_token', 'user_image')
                    ->where ('email', '=', $data['email'])->first ();


                if ($user && Hash::check ($data['oldpassword'], $user->password)) {


                    // here you know data is valid
                    Storage::disk ('local')->append ($logsfile, $user->toJson ());
                    Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

                    $user_id = $user->id;


                    // change password

                    $data['newpassword'] = Hash::make ($data['newpassword']);
                    $user->password = $data['newpassword'];
                    $user->save ();

                    if (strlen ($user->user_image) > 0 && File::exists ($imagespath . "/" . $user->user_image)) {
                        $userimage = $user->user_image;
                    } else {
                        $userimage = 'userdefaultimg.png';
                    }
                    $user_image = $imagesurl . "/" . $userimage;

                    $responce = $this->renderresponse ($user['remember_token'], "Successfully password changed In", $user_id, $user_image);

                    return json_encode ($responce);

                } else {

                    $messages = "101: User not exist or wrong password";
                    $responce = $this->rendererrorresponse ($messages);

                    Storage::disk ('local')->append ('api.login' . $today . '.txt', "responce:\r\n" . json_encode ($responce));
                    Storage::disk ('local')->append ('api.login' . $today . '.txt', '------------------------------------------------------------------------------------------------------------------------------------');

                    return json_encode ($responce);

                }

            }


        } catch (Exception $exception) {
            return '{"status":"101:","message":"General error","usertoken":""}';

        }


    }

    public function forgetpassword ()
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

    protected function savedivetype ($user_id, $devicetype)
    {

        $user = User::findorfail ($user_id);
        $user->devicetype = $devicetype;
        $user->save ();
        return;

    }


    protected function validator (array $data)
    {
        return Validator::make (
            $data,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'grade_id' => 'nullable|exists:grades,id|numeric',
                'language_id' => 'nullable|exists:languages,id|numeric',
                'country_id' => 'nullable|exists:countries,id|numeric',
                'gender' => 'nullable|in:M,F',
                'dob' => 'nullable|date|date_format:m/d/Y',
                'phone' => 'nullable|string|max:25',
                'mobile' => 'nullable|string|max:25',
                'devicetype' => 'required|string|max:50',
                'uilanguage_id' => 'nullable|exists:languages,id|numeric',


            ], $this->messagevalidation ()
        );


    }

    protected function changepasswordvalidator (array $data)
    {
        return Validator::make (
            $data,
            [
                'email' => 'required|string|email|max:255|exists:users,email',
                'oldpassword' => 'required|string|min:6',
                'newpassword' => 'required|string|min:6',
                'remember_token' => 'required|exists:users,remember_token|string|max:500',


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


    protected function loginvalidator (array $data)
    {
        return Validator::make (
            $data,
            [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
                'devicetype' => 'required|string|max:50',

            ], $this->messagevalidation ()
        );


    }

    protected function loginsocialmediavalidator (array $data)
    {
        return Validator::make (
            $data,
            [
                'provider' => 'required|string|max:255',
                'provider_id' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'devicetype' => 'required|string|max:50'


            ], $this->messagevalidation ()
        );


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

    protected function create (array $data)
    {

        try {
            if (strlen ($data['password']) <> 0) $data['password'] = Hash::make ($data['password']);

            $user = User::create ([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'remember_token' => $data['remember_token'],
                'provider' => $data['provider'],
                'provider_id' => $data['provider_id'],
                'registeredby' => $data['registeredby'],

                'grade_id' => $data['grade_id'],
                'uilanguage_id' => $data['language_id'],
                'mobile' => $data['mobile'],
                'phone' => $data['phone'],
                'country_id' => $data['country_id'],
                'gender' => $data['gender'],
                'devicetype' => $data['devicetype'],
                'dob' => $data['dob'],


            ]);
            $user->roles ()->attach (Role::where ('name', 'Learner')->first ());
            return $user;
        } catch (Exception $exception) {
            return '-1000: database  error';

        }
    }

    protected function save (array $data, $id)
    {
        try {

            $user = User::findorfail ($id);
            if ($user) {
                if (strlen ($data['name']) <> 0) $user->name = $data['name'];
                if (strlen ($data['email']) <> 0) $user->email = $data['email'];
                if (strlen ($data['remember_token']) <> 0) $user->remember_token = $data['remember_token'];
                $user->provider = $data['provider'];
                $user->provider_id = $data['provider_id'];
                $user->save ();

            }
            return $user;
        } catch (Exception $exception) {
            return '-1000: database  error';

        }
    }


    public function loginactivity ($id)
    {

        LoginActivity::create ([
            'user_id' => $id,
            'user_agent' => \Illuminate\Support\Facades\Request::header ('User-Agent'),
            'ip_address' => \Illuminate\Support\Facades\Request::ip ()
        ]);
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

    private function renderresponselogin ($data, $message, $user_id, $user_image,$country_id)

    {
        $response = array();
        $response['status'] = "1";
        $response['id'] = $user_id;
        $response['message'] = $message;
        $response['user_image'] = $user_image;
        $response['country_id'] = $country_id;
        $response['usertoken'] = $data;

        return $response;
        // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }
}