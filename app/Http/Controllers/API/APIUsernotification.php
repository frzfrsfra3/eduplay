<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Models\Usernotification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Log;
use Illuminate\Support\Facades\Storage;


class APIUsernotification extends Controller
{

    public function getusernotifications() {

        $data = array();
        $data['remember_token'] = Input::get ('user_token');

        $validator = $this->uservalidator1 ($data);
        if ($validator->fails ()) {


            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);


        }
        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
                $usernotifications = DB::table('usernotifications')
                    ->join('users', 'usernotifications.sender_userid', '=', 'users.id')
                    ->where ('receiver_userid' , '=' , $user->id)
                    ->select('usernotifications.*', 'users.name as sendername')->get();

        if ($usernotifications->count() <> 0 ) {

            $responce = $this->renderresponse ($usernotifications, "Success  List of User notifications ");
            return json_encode ($responce);


        }
        else        {

            $messages = '101 You have no notifications ! ';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

    }


    public function setnotificationstatus (){

        try {
            $today = date ("Ymd");

            $data = array();
            $request = Request::capture ();
            $data['remember_token'] = Input::get ('user_token');
            $data['id'] = Input::get ('id');
            $data['status'] = Input::get ('status');


            //  if (strlen ($data['score']) == 0)  $data['score'] =0;



            $validator = $this->uservalidator1 ($data);
            if ($validator->fails ()) {


                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse($messages);
                return  json_encode ($responce);

            }

            $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
            if($user){
                $usernotifications = Usernotification::where ('id', '=', $data['id'])->where('receiver_userid','=',$user->id)->first ();


                if ($usernotifications) {
                    $usernotifications['status']=$data['status'];
                    $usernotifications->update ();

                    $responce = $this->renderresponse ($usernotifications, "Success  update of notifications status");
                    return json_encode ($responce);


                }
                else        {

                    $messages = '101 , no notification for this user ';
                    $responce = $this->rendererrorresponse($messages);
                    return  json_encode ($responce);
                }


        }

            //    return json_encode($userexamscore);


        }
        catch (Exception $exception) {
            $messages = '101: database error';
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

            ], $this->messagevalidation ()
        );


    }



    private function messagevalidation ()
    {

        return $messages = array(
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' =>'101: user not exist',
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

