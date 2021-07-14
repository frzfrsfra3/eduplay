<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\React\API;

use App\Http\Controllers\Controller;
use App\Models\Answeroption;
use App\Models\Badge;
use App\Models\Question;
use App\Models\User;
use App\Models\Userexamanswer;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use Log;
use Illuminate\Support\Facades\Storage;


class APIuseranswers extends Controller
{


    public function saveuseranswer(){

        try {

            $today = date ("Ymd");
            $logsfile = "api.saveuseranswer" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['remember_token'] = Input::get ('user_token');
            $data['gameid'] = Input::get ('gameid');
            $data['question_id'] = Input::get ('question_id');
            $data['answer_id'] = Input::get ('answer_id');
            $data['timespent'] = Input::get ('timespent');
            $data['answerdate'] = Input::get ('answerdate');

            $data['match_uid'] = Input::get ('match_uid');
            $data['match_datetime'] = Input::get ('match_datetime');

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());
            $validator = $this->validator1 ($data);
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

                $useranswer=Userexamanswer::where('user_id','=' ,$user->id)->where('gameid','=', $data['gameid'])
                                            ->where('question_id','=' , $data['question_id'])->where('answer_id','=' , $data['answer_id'])
                                             ->where('match_uid','=' , $data['match_uid'])
                                             ->where('match_datetime','=' , $data['match_datetime'])
                                            ->where('answerdate','=' , $data['answerdate'])->first();

                if ($useranswer) {
                    $messages = '101: this  records is already insert';
                    $responce = $this->rendererrorresponse ($messages);
                    return json_encode ($responce);

                }
                else {
                    $useranswer=$this->save($data , $user);
                    $responce = $this->renderresponse ($useranswer, "Success  user answer saved");
                    return json_encode ($responce);
                }
            }

        }
        catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);
        }
        }


    public function saveuseranswers_json(){

        try {

            $today = date ("Ymd");
            $logsfile = "api.saveuseranswers_json" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['remember_token'] = Input::get ('user_token');
            $data['gameid'] = Input::get ('gameid');
            $data['match_uid'] = Input::get ('match_uid');
            $data['match_datetime'] = Input::get ('match_datetime');
            $data['json_data'] = Input::get ('json_data');

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());
            $validator = $this->jsonvalidator1 ($data);
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

                $useranswers = json_decode(  $data['json_data'], true );


                 if (!$useranswers)
                 {
                     $messages = '101: invalid json data';
                     $responce = $this->rendererrorresponse ($messages);
                     return json_encode ($responce);

                 }
                 else
                {
                   $count_of_fails=0;
                   $count_saved=0;

                    foreach($useranswers as $answer) {
                        $answer_data= array_merge($data, $answer);

                        $validator = $this->validator1 ($answer_data);
                        if ($validator->fails ()) {
                            $count_of_fails=$count_of_fails+1;

                        }
                        else {
                            $useranswer=Userexamanswer::where('user_id','=' ,$user->id)->where('gameid','=', $answer_data['gameid'])
                                ->where('question_id','=' , $answer_data['question_id'])->where('answer_id','=' , $answer_data['answer_id'])
                                ->where('match_uid','=' , $answer_data['match_uid'])
                                ->where('match_datetime','=' , $answer_data['match_datetime'])
                                ->where('answerdate','=' , $answer_data['answerdate'])->first();

                            if ($useranswer) {
                            }
                            else {
                                $useranswer=$this->save($answer_data , $user);
                                $count_saved=$count_saved+1;

                            }

                        }

                    }
                }
                $useranswers=Userexamanswer::where('user_id','=' ,$user->id)->where('gameid','=', $answer_data['gameid'])
                                            ->where('match_uid','=' , $answer_data['match_uid'])
                                            ->where('match_datetime','=' , $answer_data['match_datetime'])
                                            ->get();

                 if ($useranswers->count()==0) {

                     $messages = '101: no result data saved ';
                     $responce = $this->rendererrorresponse ($messages);
                     return json_encode ($responce);
                 }
                 else {
                     $responce = $this->renderresponse ($useranswers, "Success  user answers :");
                     return json_encode ($responce);
                 }

            }

        }
        catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);
        }
    }


        private function save($data , $user){
            // create a new user  answer
            $question=Question::where('id','=',$data['question_id'])->first();
            $answer=Answeroption::where('id','=',$data['answer_id'])->first();
            $useranswer=new Userexamanswer;
            $useranswer->answerdate=$data['answerdate'];
            $useranswer->user_id=$user->id;
            $useranswer->attempt_number=1;
            $useranswer->question_id=$data['question_id'];
            $useranswer->answer_id=$data['answer_id'];
            $useranswer->timespent=$data['timespent'];
            $useranswer->iscorrect=$answer->iscorrect;
            $useranswer->teachermark=$question->mark;
            $useranswer->gameid=$data['gameid'];
            $useranswer->match_uid=$data['match_uid'];
            $useranswer->match_datetime=$data['match_datetime'];
            $useranswer->save();
            return $useranswer ;



        }

    private function rendererrorresponse ($message)

    {
        $data = array();
        $errorid = substr ($message, 0, 3);
        $errortext = substr ($message, 4);
        $response = array();
        $response['status'] = $errorid;
        $response['message'] = $errortext;
        $response['data'] = $data;
        return $response;


    }

    private function renderresponse ($data, $message)

    {
        $response = array();
        $response['status'] = "1";
        $response['message'] = $message;
        $response['data'] = $data;
        return $response;

    }



    protected function validator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'gameid' => 'required|exists:games,id|numeric|max:100000',
                'question_id' => 'required|exists:questions,id|numeric',
                'answer_id' => 'required|exists:answeroptions,id|numeric',
                'timespent' => 'required|numeric',
                'match_uid' => 'required|numeric',
                'match_datetime' => 'required|date',
                'answerdate'=> 'required|date',
            ], $this->messagevalidation ()
        );


    }


    protected function jsonvalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'gameid' => 'required|exists:games,id|numeric|max:100000',
                'match_uid' => 'required|numeric',
                'match_datetime' => 'required|date',
                'json_data'=> 'required|string',
            ], $this->messagevalidation ()
        );


    }


    private function messagevalidation ()
    {

        return $messages = array(
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' => '101: user not exist',

            'gameid.required' => '101: game id is empty',
            'gameid.exists' => '101: game id not exist',
            'gameid.numeric' => '101: game id should be numeric',
            'gameid.max' => '101: game id must be less then 100000',

            'question_id.required' => '101: question id is empty',
            'question_id.exists' => '101: question id not exist',
            'question_id.numeric' => '101: question id should be numeric',

            'answer_id.required' => '101: answer id is empty',
            'answer_id.exists' => '101: answer id not exist',
            'answer_id.numeric' => '101: answer id should be numeric',

            'timespent.required' => '101: timespent is empty',
            'timespent.numeric' => '101: timespent should be numeric',

            'match_uid.required' => '101: match_uid is empty',
            'match_uid.numeric' => '101: match_uid should be numeric',

            'match_datetime.required' => '101: match_datetime is empty',
            'match_datetime.date' => '101: match_datetime should be date',


            'answerdate.required' => '101: answerdate is empty',
            'answerdate.date' => '101: answerdate should be date',

            'json_data.required' => '101: json_data is empty',


        );


    }


}

