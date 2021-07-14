<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\User;
use App\Models\Userexamscore;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;
use Log;
use Illuminate\Support\Facades\Storage;




class APIScores extends Controller
{
    //setscore, getscore, getuserscores, save,
    // scorevalidator1, getscorevalidator1, messagevalidation, rendererrorresponse
    // renderresponse, renderresponseuser,

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
            $data['topic_id'] = Input::get ('topic_id');
            $data['totaltimespent'] = Input::get ('totaltimespent');

          //  if (strlen ($data['score']) == 0)  $data['score'] =0;
            if (strlen ($data['totaltimespent']) == 0)  $data['totaltimespent'] =0;

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
            $topics = array();
            $imagespath = public_path('/assets/images/profiles/');
            $imagesurl = url('/assets/images/profiles/');

            $topicpath = public_path('/assets/images/');
            $topicurl = url('/assets/images/');

            $data['game_id'] = Input::get('game_id');
            $data['country_id'] = Input::get('country_id');
            $data['topic_id'] = Input::get('topic_id');
            $remember_token = Input::get('user_token');

            $validator = $this->getscorevalidator1($data);

            if ($validator->fails()) {

                $messages = $validator->errors()->first();
                $responce = $this->rendererrorresponse($messages);
                return json_encode($responce);
            }

            $topic = Topic::select('id', 'topic_name','iconurl')->where('id', '=', $data['topic_id'])->first();
            if ($topic->count() > 0) {

                if (strlen($topic->iconurl) > 0 && File::exists($topicpath . "/" . $topic->iconurl)) {
                    $topicimage = $topic->iconurl;
                } else {
                    $topicimage = 'topic_default-test.png';
                }
                $topics['id']=$topic->id;
                $topics['topic_name']=$topic->topic_name;
                $topics['images']=$topicurl . "/" . $topicimage;
            }

            $highscores =Userexamscore::select(DB::raw('userexamscores.user_id,users.name,userexamscores.game_id,users.user_image,users.remember_token,max(score) as score' ))
                    ->join('users', 'users.id', '=', 'userexamscores.user_id')
                    ->where('game_id', '=', $data['game_id'])
                    ->where('topic_id', '=', $data['topic_id']);
            if(Input::get('country_id')){ $highscores =   $highscores->where(['users.country_id' => $data['country_id']]);}
            $highscores =   $highscores->groupBy('user_id','name','game_id','user_image','remember_token')
                    ->orderBy('score', 'desc')
                    ->take(20) ->get();

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

                    $highscore[$i]['score'] = $singlescore->score;
                    $highscore[$i]['rank'] = $i + 1;
                    $highscore[$i]['user_image'] = $imagesurl . "/" . $userimage;

                    if ($singlescore->remember_token == $remember_token && empty($userscore)) {

                        $userscore['user_id'] = $singlescore->user_id;
                        $userscore['name'] = $singlescore->name;
                        $userscore['game_id'] = $singlescore->game_id;
                        $userscore['score'] = $this->getuserscore($singlescore->user_id,$data['game_id'],$data['topic_id']);
                        $userscore['rank'] = $i+1;
                        $userscore['user_image'] = $imagesurl . "/" . $userimage;

                    }
                    $i++;

                }

                if (empty($userscore)) {
                    $userscore['user_id'] = 0;
                    $userscore['name'] = 0;
                    $userscore['game_id'] = 0;
                    $userscore['score'] = 0;
                    $userscore['rank'] = 0;

                    $userscore['user_image'] = $imagesurl . "/userdefaultimg.png";
                }


                $responce = $this->renderresponseuser($highscore, $userscore,$topics, "Success Top 20 highest score ");
                return json_encode($responce);


            } else {
                $messages = "101: Not enough data to display skills mastery level";
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

    function getuserscore($id,$game_id,$topic_id) {
        $score=Userexamscore::where ("user_id",'=',$id)->where('topic_id','=',$topic_id)->where('game_id','=',$game_id)->orderBy('score', 'desc')->first();

        return $score->score;

    }

    protected function save ($data ,$user) {
        $userexamscore=Userexamscore::where('game_id','=', $data['game_id'])->where('user_id','=',$user->id)->where('match_uid','=',$data['match_uid'])->first();

        if  (!$userexamscore) {
            $userexamscore = Userexamscore::create ([
                'user_id' => $user->id,
                'score' => $data['score'],
                'game_id' => $data['game_id'],
                'match_uid' => $data['match_uid'],
                'topic_id' => $data['topic_id'],
                'totaltimespent' => $data['totaltimespent']


            ]);
        }
        else {
            $userexamscore->game_id=$data['game_id'];
            $userexamscore->match_uid=$data['match_uid'];
            $userexamscore->score=$data['score'];
            $userexamscore->totaltimespent=$data['totaltimespent'];
            $userexamscore->user_id=$user->id;
            $userexamscore->topic_id=$data['topic_id'];
            $userexamscore->save();
        }

        return $userexamscore;

    }

    protected function scorevalidator1 (array $data){
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'game_id' => 'required|exists:games,id',
                'topic_id' => 'required|exists:topics,id',
                'score' => 'required|numeric',
                'totaltimespent' => 'nullable|numeric',
                'match_uid'=>'required|numeric',
            ], $this->messagevalidation ()
        );


    }

    protected function getscorevalidator1 (array $data){
        return Validator::make (
            $data,
            [
                'game_id' => 'required|exists:games,id',
                'topic_id' => 'required|exists:topics,id',
                'country_id'=>'nullable|exists:countries,id'

            ], $this->messagevalidation ()
        );


    }

    private function messagevalidation (){
        return $messages = array(
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' =>'101: user not exist',
            'game_id.required' =>  '101: game id is empty',
            'topic_id.required' =>  '101: topic id is empty',
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

    private function rendererrorresponse($message){
        $data=array();
        $errorid=substr($message, 0, 3);
        $errortext=substr($message, 4);
        $response=array();
        $response['status']=$errorid;
        $response['message']=$errortext;
        $response['data']=$data;
        return $response;


    }

    private function renderresponse($data , $message){
        $response=array();
        $response['status']="1";
        $response['message']= $message ;
        $response['data']=$data;

        return $response;
        // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }

    private function renderresponseuser($data,$userscore,$topics , $message){
        $response=array();
        $response['status']="1";
        $response['message']= $message ;
        $response['data']=$data;
        $response['userscore']=$userscore;
        $response['topics']=$topics;
        return $response;    // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }

}
