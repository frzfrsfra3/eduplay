<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\React\API;

use App\Http\Controllers\Controller;

use App\Models\Userexamscore;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\User;
//use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Models\Role_user;



use Log;
use Illuminate\Support\Facades\Storage;


class APIPoints extends Controller
{

public  function  setuserpoints () {

    try {

        $today = date ("Ymd");
        $logsfile = "api.setpoints" . $today . ".txt";
        $data = array();
        $request = Request::capture ();
        $data['remember_token'] = Input::get ('user_token');
        $data['score'] = Input::get ('score');
        $data['match_uid'] = Input::get ('match_uid');
        $data['game_id'] = Input::get ('game_id');



        Storage::disk ('local')->append ($logsfile, $request);
        Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

        $validator = $this->setuserpointvalidator ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);

            Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

            return json_encode ($responce);
        }
        else  {

            $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
            if ($user) {
                $userexamscore =Userexamscore::where('user_id','=' ,$user->id)->where('game_id','=' ,$data['game_id'])
                    ->where('match_uid' ,'=' ,$data['game_id'])->select('user_id' ,'match_uid','game_id','score')->first();
                if (!$userexamscore) $userexamscore= new Userexamscore ;
                $userexamscore->user_id=$user->id;
                $userexamscore->match_uid=$data['match_uid'];
                $userexamscore->game_id=$data['game_id'];
                $userexamscore->score=$data['score'];
                $userexamscore->save();
                $responce=$this->renderresponse($userexamscore ,"Success  User score added " );
                return json_encode($responce);


            }
        }

        }
    catch (Exception $exception) {

$messages = '101: database error';
$responce = $this->rendererrorresponse($messages);
return  json_encode ($responce);

}
}


    protected function setuserpointvalidator (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'game_id' => 'required|exists:games,id|numeric|max:500',
                'match_uid'=>'required|numeric|max:500',
                'score'=>'required|numeric|max:10000',


            ], $this->messagevalidation ()
        );


    }



    private function messagevalidation ()
    {

        return $messages = array(


            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' =>'101: user not exist',


            'game_id.required' => '101:Empty Game id.',
            'game_id.exists' => '101: Game id  not exist.',
            'game_id.numeric' =>'101:The Game id must be a number.',

            'match_uid.required' => '101:Empty match_uid.',
            'match_uid.numeric' =>'101:The match_uid must be a number.',

            'score.required' => '101:Empty score.',
            'score.numeric' =>'101:The score must be a number.',
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