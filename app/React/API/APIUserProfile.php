<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\React\API;

use App\Http\Controllers\Controller;
use App\Models\Discipline;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Userinterest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use File;
use Log;
use Illuminate\Support\Facades\Storage;


class APIUserProfile extends Controller
{


    public function setuserprofile ()
    {

        try {


            $imagespath = url ('/Images');

            $today = date ("Ymd");
            $logsfile = "api.setuserprofile" . $today . ".txt";
            $data = array();
            $request = Request::capture ();

            $data['remember_token'] = Input::get ('user_token');
            $data['name'] = Input::get ('name');
            $data['password'] = Input::get ('password');
            $data['mobile'] = Input::get ('mobile');
            $data['phone'] = Input::get ('phone');
            $data['gender'] = Input::get ('gender');
            $data['country_id'] = Input::get ('country_id');
            $data['dob'] = Input::get ('dob');
            $data['parentmail'] = Input::get ('parentmail');


            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());
            $validator = $this->uservalidator1 ($data);
            if ($validator->fails ()) {


                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse($messages);

                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ( $responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                $responce = str_replace ("\r\n", "<br>", $responce);
                return $responce;
            }

            $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
            if ($user) {

                if (strlen ($data['name']) <> 0) $user->name = $data['name'];
                if (strlen ($data['password']) <> 0) $user->password =Hash::make ($data['password']);
                if (strlen ($data['mobile']) <> 0) $user->mobile = $data['mobile'];
                if (strlen ($data['phone']) <> 0) $user->phone = $data['phone'];
                if (strlen ($data['gender']) <> 0) $user->gender = $data['gender'];
                if (strlen ($data['country_id']) <> 0) $user->country_id = $data['country_id'];
                if (strlen ($data['dob']) <> 0) $user->dob = $data['dob'];
                if (strlen ($data['parentmail']) <> 0) $user->parentmail = $data['parentmail'];

                $user->save ();
                $user = User::select ('id', 'name', 'email', 'mobile', 'gender', 'user_image', 'country_id', 'dob', 'phone', 'parentmail')
                    ->findorfail ($user->id);

                if (strlen ($user['user_image']) <> 0) {
                    $user['user_image'] = $imagespath . "/" . $user["user_image"];;
                }


                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($user));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

                $responce = $this->renderresponse ($user, "Success User profile updated");
                return json_encode ($responce);
                //return json_encode ($user);
            }

        } catch (Exception $exception) {

            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }
    }

    public function userinfo (){
        try {


        }
        catch (Exception $e) {


            $messages = '101:Not received any file';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }
    }


    public function setuserimage ()
    {
        // unused right now
        try {
            $today = date ("Ymd");
            $logsfile = "api.setuserimage" . $today . ".txt";
            // this code is taken from :https://www.androidhive.info/2014/12/android-uploading-camera-image-video-to-server-with-progress-bar/

            // Path to move uploaded files
            $target_path = "uploads/";
            $file_upload_url = url ('Images/MobileFileUpload/uploads/');

            // array for final json respone
            $response = array();

            if (isset($_FILES['image']['name'])) {
                $target_path = $target_path . basename ($_FILES['image']['name']);

                // reading other post parameters
                $data = array();
                $request = Request::capture ();
                $data['remember_token'] = isset($_POST['email']);
                $response['file_name'] = basename ($_FILES['image']['name']);

                Storage::disk ('local')->append ($logsfile, $request);
                Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());
                $validator = $this->uservalidator1 ($data);
                if ($validator->fails ()) {

                    $messages = $validator->errors ()->all ();
                    $responcevalidation = "";
                    foreach ($messages as $key => $error) {
                        $responcevalidation = $responcevalidation . $error . "\r\n";
                    }
                    Storage::disk ('local')->append ($logsfile, "responce:\r\n" . $responcevalidation);
                    Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                    $responcevalidation = str_replace ("\r\n", "<br>", $responcevalidation);
                    return $responcevalidation;
                }

                $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
                if ($user) {


                    try {
                        // Throws exception incase file is not being moved
                        if (!move_uploaded_file ($_FILES['image']['tmp_name'], $target_path)) {
                            // make error flag true
                            $response['error'] = true;
                            $response['message'] = '101:Could not move the file!';
                        }

                        $user->user_image =

                            // File successfully uploaded
                        $response['message'] = '1  :File uploaded successfully!';

                        $user->user_image = $file_upload_url . basename ($_FILES['image']['name']);
                        $user->save ();
                    } catch (Exception $e) {
                        // Exception occurred. Make error flag true
                        $response['error'] = true;
                        $response['message'] = '101: ' . $e->getMessage ();
                    }
                }


            } else {
                // File parameter is missing
                $response['error'] = true;
                $response['message'] = '101:Not received any file';
            }

            // Echo final json response to client
            $responce1 = $this->rendererrorresponse($response['message']);
            return  json_encode ($responce1);
           // echo json_encode ($response['message']);
        }
        catch (Exception $e) {

           // echo '101:Not received any file';
            $messages = '101:Not received any file';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

    }

    public function setuserimage64 ()
    {
        try {
            $today = date ("Ymd");
            $logsfile = "api.setuserimage64" . $today . ".txt";
            $imagespath =public_path ('/assets/images/profiles/');
            $imagesurl=url('/assets/images/profiles/');

            $today = date ("Ymd");
            $logsfile = "api.setuserimage64" . $today . ".txt";
            $data = array();
            $request = Request::capture ();

            $data['remember_token'] = Input::get ('user_token');
            $data['encodeddata'] = Input::get ('encodeddata');
            $data['imagetype'] = Input::get ('imagetype');
            $data['filename'] = Input::get ('filename');

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());
            $validator = $this->image64validator1 ($data);
            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse($messages);

                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ( $responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                $responce = str_replace ("\r\n", "<br>", $responce);
                return $responce;
            }

            $user = User::where ('remember_token', '=', $data['remember_token'])->select('id','name' ,'email' ,'user_image' ,'remember_token')->first ();
            if ($user) {

                $dataimage = base64_decode($data['encodeddata']);
                //$data['filename']=rand(10000, 99999).$data['filename'];

               $imagefinalurl= $imagesurl."/".$data['filename'];
                $user->user_image=  $data['filename'];
                $user->save();

                $user['user_image']=$imagefinalurl;
                file_put_contents($imagespath. $data['filename'], $dataimage);
                $responce = $this->renderresponse ($user, "Success User image updated");
                return json_encode ($responce);
            }



        }
        catch (Exception $e) {

            // echo '101:Not received any file';
            $messages = '101:Not received any file';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

    }

    public function getuserimage ()
    {
        try {
            $today = date ("Ymd");
            $logsfile = "api.getuserimage" . $today . ".txt";
            $imagespath =public_path ('/assets/images/profiles/');
            $imagesurl=url('/assets/images/profiles/');


            $data = array();
            $request = Request::capture ();

            $data['remember_token'] = Input::get ('user_token');

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());
            $validator = $this->getimagevalidator1 ($data);
            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse($messages);

                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ( $responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                $responce = str_replace ("\r\n", "<br>", $responce);
                return $responce;
            }

            $user = User::where ('remember_token', '=', $data['remember_token'])->select('id','name' ,'email' ,'user_image' ,'remember_token')->first ();
            if ($user) {

                if (strlen($user->user_image) >0 && File::exists($imagespath."/".$user->user_image)) {$userimage= $user->user_image;}
                else {


                    $userimage = 'userdefaultimg.png';
                }

                $user['user_image']=$imagesurl."/". $userimage;
                $responce = $this->renderresponse ($user, "Successflly get User image");
                return json_encode ($responce);
            }



        }
        catch (Exception $e) {

            // echo '101:Not received any file';
            $messages = '101:Not received any file';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

    }




    protected function uservalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'gender' => 'nullable|in:M,F',
                'dob' => 'nullable|date|date_format:m/d/Y',
                'country_id' => 'nullable|exists:countries,id',
                'parentmail' => 'nullable|string|email|max:255',
                'phone' => 'nullable|string|max:25',
                'mobile' => 'nullable|string|max:25'
            ], $this->messagevalidation ()
        );


    }

    private function messagevalidation ()
    {

        return $messages = array(
            'parentmail.email' => '101:The email must be a valid email address.',
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' => '101: user not exist',
            'gender.in' => '101:gender must be M or F.',
            'dob.date' => '101:dob must be a date',
            'country_id.exists' => '101:this country id not exist',
            'dob.date_format' => '101: bad dob  date format , m/d/Y',
            'phone.max' => '101: you exceed 25 characters for the phone',
            'mobile.max' => '101: you exceed 25 characters for the mobile',
            'encodeddata.required' => '101: Empty Image data.',
            'imagetype.required' => '101: Empty Image type.',
            'imagetype.in' => '101: Empty Image type must be:image/png',
            'imagetype.filename' => '101: Empty Image file name.',
            'imagetype.max' => '101: you exceed 250 characters for the Image file name.',
        );


    }

    protected function image64validator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'encodeddata'=>'required',
                'imagetype'=>'required|in:image/png',
                'filename'=>'required|string|max:250',


            ], $this->messagevalidation ()
        );


    }


    protected function getimagevalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',



            ], $this->messagevalidation ()
        );


    }

    private function rendererrorresponse($message)

    {
        $data=array();
        $errorid=substr($message, 0, 3);
        $errortext=substr($message, 4);
        $response=array();
        $response['status']=$errorid;
        $response['message']=$errortext;
        $response['data']=$data;
        return $response;
    }

    private function renderresponse($data , $message)

    {
        $response=array();
        $response['status']="1";
        $response['message']= $message ;
        $response['data']=$data;
        return $response;
        // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }


}