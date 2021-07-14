<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 4/11/2018
 * Time: 11:31 AM
 */

namespace app\React\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Userexamscore;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use File;
use Log;
use Illuminate\Support\Facades\Storage;



class APIScores extends Controller
{

    public function setscore (){

        try {
            $today = date ("Ymd");
            $logsfile = "api.setscore" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['remember_token'] = Input::get ('user_token');
            $data['game_id'] = Input::get ('game_id');
            $data['match_uid'] = Input::get ('match_uid');
            $data['score'] = Input::get ('score');
            $data['totaltimespent'] = Input::get ('totaltimespent');

          //  if (strlen ($data['score']) == 0)  $data['score'] =0;
            if (strlen ($data['totaltimespent']) == 0)  $data['totaltimespent'] =0;

        //    dd($data);

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

            $validator = $this->scorevalidator1 ($data);
            if ($validator->fails ()) {

              /*  $messages = $validator->errors ()->all ();
                $responce = "";
                foreach ($messages as $key => $error) {
                    $responce = $responce . $error . "\r\n";
                }*/
                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse($messages);
                Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode ( $responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

                return json_encode ( $responce);
            }
            $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
            $userexamscore=   $this->save($data , $user) ;
            $responce = $this->renderresponse ($userexamscore, "Successfully User Score added , user score Data ");
            return json_encode ($responce);


        //    return json_encode($userexamscore);


        }
          catch (Exception $exception) {
              $messages = '101: database error';
              $responce = $this->rendererrorresponse($messages);
              return  json_encode ($responce);

}
    }


    public function getscore(){

        try {
            $data = array();
            $userscore = array();
            $highscore = array();
            $imagespath = public_path('/assets/images/profiles/');
            $imagesurl = url('/assets/images/profiles/');
            $data['game_id'] = Input::get('game_id');
            $data['country_id'] = Input::get('country_id');
            $remember_token = Input::get('user_token');
            if ($remember_token) {

                $latestuserexamscores = DB::table('userexamscores')->select('userexamscores.user_id', 'users.name', 'userexamscores.game_id',  'users.user_image', 'users.remember_token')
                    ->join('users', 'users.id', '=', 'userexamscores.user_id')
                ->where('game_id', '=', $data['game_id']);
                     if(Input::get('country_id')){ $latestuserexamscores =   $latestuserexamscores->where(['users.country_id' => $data['country_id']]);}
                $latestuserexamscores = $latestuserexamscores->orderBy('userexamscores.created_at', 'desc')

                    ->distinct()->take(100)->get();

                $j = 0;
                foreach ($latestuserexamscores as $latestuserexamscore) {
                    $j++;
                    if ($latestuserexamscore->remember_token == $remember_token && empty($userscore)) {
                        if (strlen($latestuserexamscore->user_image) > 0 && File::exists($imagespath . "/" . $latestuserexamscore->user_image)) {
                            $userimage = $latestuserexamscore->user_image;
                        } else {
                            $userimage = 'userdefaultimg.png';
                        }

                        $userscore['user_id'] = $latestuserexamscore->user_id;
                        $userscore['name'] = $latestuserexamscore->name;
                        $userscore['game_id'] = $latestuserexamscore->game_id;
                        $userscore['score'] = $this->getuserscore($latestuserexamscore->user_id,'created_at');
                        $userscore['rank'] = $j;
                        $userscore['user_image'] = $imagesurl . "/" . $userimage;
                        break;
                    }
                }
            }
            if (empty($userscore)) {
                $userscore['user_id'] = 0;
                $userscore['name'] = 0;
                $userscore['game_id'] = 0;
                $userscore['score'] = 0;
                $userscore['rank'] = 0;
                $userscore['user_image'] = $imagesurl . "/userdefaultimg.png";
            }



            $validator = $this->getscorevalidator1($data);
            if ($validator->fails()) {

                $messages = $validator->errors()->first();
                $responce = $this->rendererrorresponse($messages);
                return json_encode($responce);
            }

                $highscores = DB::table('userexamscores')->select('userexamscores.user_id', 'users.name', 'userexamscores.game_id',  'users.user_image', 'users.remember_token')
                    ->join('users', 'users.id', '=', 'userexamscores.user_id')
                    ->where('game_id', '=', $data['game_id']);
                     if(Input::get('country_id')){ $highscores =   $highscores->where(['users.country_id' => $data['country_id']]);}
                $highscores =  $highscores->orderBy('score', 'desc')->distinct()->take(20)->get();


            if ($highscores->count() <> 0) {
                $i = 0;
                foreach ($highscores as $singlescore) {


                    if (strlen($singlescore->user_image) > 0 && File::exists($imagespath . "/" . $singlescore->user_image)) {
                        $userimage = $singlescore->user_image;
                    } else {
                        $userimage = 'userdefaultimg.png';
                    }
                    $highscore[$i]['user_id'] = $singlescore->user_id;
                    $highscore[$i]['name'] = $singlescore->name;
                    $highscore[$i]['game_id'] = $singlescore->game_id;
                    $highscore[$i]['score'] = $this->getuserscore($singlescore->user_id,'score');
                    $highscore[$i]['rank'] = $i + 1;
                    $highscore[$i]['user_image'] = $imagesurl . "/" . $userimage;
                    if ($singlescore->remember_token == $remember_token && !empty($userscore) && $userscore['score']==$highscore[$i]['score'] )
                    {$userscore['rank']= $i + 1;}
                    $i++;

                }

                $responce = $this->renderresponseuser($highscore, $userscore, "Success Top 20 highest score ");
                return json_encode($responce);


            } else {
                $messages = "101: no data";
                $responce = $this->rendererrorresponse($messages);
                return json_encode($responce);
            }
        }


        catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }
    }

    function getuserscore($id,$ord) {

        $score=Userexamscore::where ("user_id",'=',$id)->orderBy($ord, 'desc')->take(1)->get();

return $score[0]->score;

    }


    protected function save ($data ,$user) {

        $userexamscore=Userexamscore::where('game_id','=', $data['game_id'])->where('user_id','=',$user->id)->where('match_uid','=',$data['match_uid'])->first();

        if  (!$userexamscore) {

            $userexamscore = Userexamscore::create ([
                'user_id' => $user->id,
                'score' => $data['score'],
                'game_id' => $data['game_id'],
                'match_uid' => $data['match_uid'],
                'totaltimespent' => $data['totaltimespent']


            ]);
        }
        else {
            $userexamscore->game_id=$data['game_id'];
            $userexamscore->match_uid=$data['match_uid'];
            $userexamscore->score=$data['score'];
            $userexamscore->totaltimespent=$data['totaltimespent'];
            $userexamscore->user_id=$user->id;
            $userexamscore->save();

        }

        return $userexamscore;

    }




    protected function scorevalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'game_id' => 'required|exists:games,id',
                'score' => 'required|numeric|min:0|max:10000000',
                'totaltimespent' => 'nullable|numeric|min:0|max:10000',
                'match_uid'=>'required|numeric|min:0|max:10000',

            ], $this->messagevalidation ()
        );


    }

    protected function getscorevalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [

                'game_id' => 'required|exists:games,id',
                'country_id'=>'nullable|exists:countries,id'

            ], $this->messagevalidation ()
        );


    }




    private function messagevalidation ()
    {

        return $messages = array(
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' =>'101: user not exist',
            'game_id.required' =>  '101: game id is empty',
            'game_id.exists' =>  '101: game id is not existing',
            'score.numeric' =>  '101: score must be numeric ',
            'score.min' =>  '101: score must be postive number ',
            'score.max' =>  '101: score must be less than 10000000',
            'totaltimespent.numeric' =>  '101: totaltimespent must be numeric ',
            'totaltimespent.min' =>  '101: totaltimespent be postive number ',
            'totaltimespent.max' =>  '101: totaltimespent  be less than 10000',
            'match_uid.required' =>  '101: match_uid is empty',
            'match_uid.numeric' =>  '101: match_uid must be numeric',
            'match_uid.min' =>  '101: match_uid must be postive number',
            'match_uid.max' =>  '101: match_uid must be less than 1000',
            'score.required'=>'101:Empty score',
            'score.country_id'=>'101:Country not exist',
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
    private function renderresponseuser($data,$userscore , $message)

    {
        $response=array();
        $response['status']="1";
        $response['message']= $message ;
        $response['data']=$data;
        $response['userscore']=$userscore;
        return $response;
        // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }

}
