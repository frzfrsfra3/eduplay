<?php

namespace App\Http\Controllers\API2;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginActivity;


class RegistrationController extends Controller
{

    public function verifyUser(Request $request)
    {
        try {
            $id = Input::get ('id');
            $confirmation_code = Input::get ('confirmation_code');
            $user = User::where('id' , $id)->first();
            if ( $user )
            {
                if ( $confirmation_code == $user->confirmation_code )
                {
                    $user->is_verified = true;
                    $user->save();
                    return "verified";
                }
                else
                    return "notValid";
            }
            else
                return "notFound";

        } catch (Exception $exception) {
            return "error";
        }
    }

    public function register(Request $request)
    {
        try
        {
            // Handle Input
            $data = array();
            $data['name']           = Request::input('username');
            $data['email']          = Request::input('email');
            $data['password']       = Request::input('password');
            $data['provider']       = Request::input ('provider');
            $data['provider_id']    = Request::input ('provider_id');
            $data['grade_id']       = Request::input ('grade_id');
            $data['language_id']    = Request::input ('language_id');
            $data['mobile']         = Request::input ('mobile');
            $data['phone']          = Request::input ('phone');
            $data['gender']         = Request::input ('gender');
            $data['dob']            = Request::input ('dob');
            $data['devicetype']     = Request::input ('devicetype');
            $data['country_id']     = Request::input ('country_id');
            $data['registeredby']   = 'API';

            // Validate
            $validator = Validator::make (
                $data,
                [
                    'name'          => 'required|string|max:255',
                    'email'         => 'required|string|max:255|unique:users',
                    'password'      => 'required|string|min:6',
                    'grade_id'      => 'nullable|exists:grades,id|numeric',
                    'language_id'   => 'nullable|exists:languages,id|numeric',
                    'country_id'    => 'nullable|exists:countries,id|numeric',
                    'gender'        => 'nullable|in:M,F',
                    'dob'           => 'nullable|date|date_format:m/d/Y',
                    'phone'         => 'nullable|string|max:25',
                    'mobile'        => 'nullable|string|max:25',
                    'devicetype'    => 'required|string|max:50',
                    'uilanguage_id' => 'nullable|exists:languages,id|numeric',
                ], $this->validateMessages ()
            );

            $response = "";

            if ( $validator->fails() )
                $response = $this->renderErrorResponse ($validator->errors ()->first());
            else
            {
                // Remember and verified token generation
                if (strlen (Request::input ('remember_token')) <> 0)
                    $data['remember_token'] = Request::input ('remember_token');
                else
                {
                    $token = base64_encode (random_bytes (64));
                    $token = substr (strtr ($token, '+/', '-_'), 0, 60);
                    $data['remember_token'] = $token;
                }

                // Create new User
                $data['password'] = Hash::make ($data['password']);
                $user = User::create ([
                    'name'              => isset($data['name']) ? $data['name'] : '',
                    'email'             => $data['email'],
                    'password'          => $data['password'],
                    'remember_token'    => $data['remember_token'],
                    'verified_token'    => $data['remember_token'],
                    'provider'          => $data['provider'],
                    'provider_id'       => $data['provider_id'],
                    'registeredby'      => $data['registeredby'],
                    'grade_id'          => isset($data['grade_id']) ? $data['grade_id'] : '',
                    'uilanguage_id'     => isset($data['language_id']) ? $data['language_id'] : '',
                    'mobile'            => isset($data['mobile']) ? $data['mobile'] : '',
                    'phone'             => isset($data['phone']) ? $data['phone'] : '',
                    'country_id'        => isset($data['country_id']) ? $data['country_id'] : '',
                    'gender'            => isset($data['gender']) ? $data['gender'] : '',
                    'devicetype'        => $data['devicetype'],
                    'dob'               => isset($data['dob']) ? $data['dob'] : '',

                ]);

                // Generate confirmation code
                $user->confirmation_code = rand(1000,9999);

                $user->save();

                // SEND AN EMAIL WITH CONFIRMATION CODE
                $message = "Hi " . $user->name . " !";
                $message .= " | Your confirmation code is: "; $user->confirmation_code;
                #########################################

                // Add a role 'Learner'
                $user->roles ()->attach (Role::where ('name', 'Learner')->first ());

                // User Image
                $imagesPath = public_path ('/assets/images/profiles/');
                $imagesURL = url('/assets/images/profiles/');

                if (strlen($user->user_image) > 0 && File::exists ($imagesPath . "/" . $user->user_image))
                    $userImage = $user->user_image;
                else
                    $userImage = 'userdefaultimg.png';

                $userImageToReturn = $imagesURL . "/" . $userImage;
                $countryID = $user->country_id;

                // Render Response
                $response = $this->renderRegisterResponse($data['remember_token'], "SuccessfullyRegister", $user->id, $userImage,$countryID);
            }

            // return response as a json data
            return response()->json($response);

        } catch (Exception $exception) {
            return '-1000: DB Error';
        }
    }

    private function validateMessages ()
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


    // Rendering Responses //


    private function renderErrorResponse($message)
    {
        $errorID = substr($message, 0, 3);
        $errorText = substr($message, 4);
        $response = array();
        $response['status'] = $errorID;
        $response['message'] = $errorText;
        $response['usertoken'] = "";
        return $response;
    }

    private function renderRegisterResponse ($data, $message, $user_id, $user_image,$country_id)
    {
        $response = array();
        $response['status'] = "1";
        $response['id'] = $user_id;
        $response['message'] = $message;
        $response['user_image'] = $user_image;
        $response['country_id'] = $country_id;
        $response['usertoken'] = $data;
        return $response;
    }
}
