<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Discipline;
use App\Models\Topic;
use App\Models\Exerciseset;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Userinterest;
use Illuminate\Support\Facades\Validator;


use Log;
use Illuminate\Support\Facades\Storage;


class APIDisciplines extends Controller
{


    public function disciplines ()
    {

        $defaultimgpath = url ('/assets/images/dilsplineclass.jpg');
        $imagespath = url ('/assets/images');

        $getval = Input::get ('get');
        $topic_id = Input::get ('topic_id');

        $request = Request::capture ();
        $data['topic_id'] = Input::get ('topic_id');

        $validator = $this->disciplinevalidation ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);


            return json_encode ($responce);
        }


        if ($getval == "new") {
            $disciplines = Discipline::select ('id', 'discipline_name', 'description', 'iconurl', 'topic_id', 'created_at')->
            where ('approve_status', '=', 'approved')->where ('publish_status', '=', 'published')->where ('topic_id', '=', $data['topic_id'])
                ->orderBy ("created_at", "desc")->get ()->take (5);
            $disciplines = $disciplines->toArray ();

        } else {
            $disciplines = Discipline::select ('id', 'discipline_name', 'description', 'iconurl', 'topic_id', 'created_at')->where ('topic_id', '=', $data['topic_id'])->
            where ('approve_status', '=', 'approved')->where ('publish_status', '=', 'published')->get ();
            $disciplines = $disciplines->toArray ();

        }

        foreach ($disciplines as &$discipline) {
            if (strlen ($discipline['iconurl']) == 0) {
                $discipline['iconurl'] = $defaultimgpath;
            } else {
                $discipline['iconurl'] = $imagespath . "/" . $discipline["iconurl"];
            }
        }
        if (empty ($disciplines)) {
            $messages = '101:No Disciplines for this Topics id';
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);


        } else {
            $responce = $this->renderresponse ($disciplines, "Success All Disciplines Data");
            return json_encode ($responce);

        }

    }

    protected function disciplinevalidation (array $data)
    {
        return Validator::make (
            $data,
            [
                'topic_id' => 'required|exists:topics,id',

            ], $this->messagevalidation ()
        );
    }

    private function messagevalidation ()
    {

        return $messages = array(

            'user_token.required' => '101:Empty remember_token.',
            'discipline_id.required' => '101:Empty discipline id.',
            'discipline_id.exists' => '101: discipline_id id is not exist',
            'userselection.required' => '101:Empty user selection.',
            'grade_id.exists' => '101: grade id is not exist',
            'language_id.exists' => '101: language id is not existing',
            'exercise_type.in' => '101:exercise_type must be 1 or 2.',
            'topic_id.required' => '101:Empty topic id.',
            'topic_id.exists' => '101: topic_id is not exist',

        );


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
        // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }

    public function getlistoftopics ()
    {

        $defaultimgpath = url ('/assets/images/topic_default-test.png');
        $imagespath = url ('/assets/images');

        $getval = Input::get ('get');


        if ($getval == "new") {
            $topics = Topic::where ('approve_status', '=', 'approved')->select ('id', 'topic_name', 'iconurl', 'created_at')->orderBy ("created_at", "desc")->get ()->take (5);
            $topics = $topics->toArray ();
        } else {

            $topics = Topic::where ('approve_status', '=', 'approved')->select ('id', 'topic_name', 'iconurl', 'created_at')->get ();
            $topics = $topics->toArray ();
        }

        foreach ($topics as &$topic) {
            $curricul=Discipline::where('topic_id','=',$topic['id'])->count();
            $topic['curricula']=$curricul;


            $follower=Userinterest::where('topic_id','=',$topic['id'])->count();
            $topic['followers']=$follower;


            $curricul=Discipline::where('topic_id','=',$topic['id'])->pluck('id')->all();
            if($curricul) {
                $exercise = Exerciseset::wherein('discipline_id', $curricul)->count();
                $topic['nbexercises'] = $exercise;
            }
            else { $topic['nbexercises'] = 0;}


            if (strlen ($topic['iconurl']) == 0) {
                $topic['iconurl'] = $defaultimgpath;
            } else {
                $topic['iconurl'] = $imagespath . "/" . $topic["iconurl"];
            }
        }





        $responce = $this->renderresponse ($topics, "Success All Topics Data");
        return json_encode ($responce);

    }

    public function topicstats ()
    {
        $topic = array();
        $data['topic_id'] = Input::get ('topic_id');

        $validator = $this->disciplinevalidation ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);


            return json_encode ($responce);
        }

        $curricul=Discipline::where('topic_id','=',$data['topic_id'])->count();
        $topic['curricula']=$curricul;


        $follower=Userinterest::where('topic_id','=',$data['topic_id'])->count();
        $topic['followers']=$follower;


        $discipline=Discipline::where('topic_id','=',$data['topic_id'])->pluck('id')->all();
        if($discipline) {
            $exercise = Exerciseset::wherein('discipline_id', $discipline)->count();
            $topic['nbexercises'] = $exercise;
        }
        else { $topic['nbexercises'] = 0;}


        $responce = $this->renderresponse ($topic, "Success  Topic Statistic");
        return json_encode ($responce);

    }


    public function setuserinterests ()
    {

        try {

            $today = date ("Ymd");
            $logsfile = "api.setuserinterests" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['user_token'] = Input::get ('user_token');
            $data['userselection'] = Input::get ('userselection');

            $validator = $this->userinterestsvalidator ($data);

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse ($messages);

                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                $responce = str_replace ("\r\n", "<br>", $responce);
                return json_encode ($responce);
            }

            $user = User::where ('remember_token', '=', $data['user_token'])->first ();

            if (!$user) {
                $messages = '101: user not exist';
                $responce = $this->rendererrorresponse ($messages);
                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                return json_encode ($responce);
            }


            $userinterests = $this->save ($data, $user->id);
            Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($userinterests));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
            $responce = $this->renderresponse ($userinterests, "Successfully   Discipline added ");
            return json_encode ($responce);


        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);

        }
    }

    protected function userinterestsvalidator (array $data)
    {
        return Validator::make (
            $data,
            [
                'user_token' => 'required|string|max:500',
                'userselection' => 'required|string',


            ], $this->messagevalidation ()
        );


    }

    private function save ($data, $user_id)
    {


        $userselection = json_decode ($data['userselection'], true);;



        foreach ($userselection['data'] as $data) {
           //    if(isset($data['discipline_id']) && strlen($data['discipline_id'])==0){  unset($data['discipline_id']);};
//
            $validator = $this->jsonvalidation ($data);
            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse ($messages);
                echo json_encode ($responce);
                dd ();

            }

            if (array_key_exists ('discipline_id', $data)) {
                if( !empty($data['discipline_id'])  && $data['discipline_id'] > 0) {
                    $validator = $this->discipline_id_validation($data);
                    if ($validator->fails ()) {
                        $messages2 = $validator->errors ()->first ();
                        $responce2= $this->rendererrorresponse ($messages2);
                        echo json_encode ($responce2);
                        dd ();
                    }
                }
                else {$data['discipline_id']=0;}
            }

            if (array_key_exists ('grade_id', $data)) {
                if( !empty($data['grade_id'])  && $data['grade_id'] > 0) {
                    $validator = $this->gradevalidation($data);
                    if ($validator->fails ()) {
                        $messages = $validator->errors ()->first ();
                        $responce= $this->rendererrorresponse ($messages);
                        echo json_encode ($responce);
                        dd ();
                    }
                }
                else {$data['grade_id']=0;}
            }

            if (array_key_exists ('language_id', $data)) {
                if( !empty($data['language_id'])  && $data['language_id'] > 0) {
                    $validator = $this->languagevalidation($data);
                    if ($validator->fails ()) {
                        $messages = 'grade test';
                        $responce= $this->rendererrorresponse ($messages);
                        echo json_encode ($responce);
                        dd ();
                    }
                }
                else {$data['language_id']=0;}
            }



            $data['user_id'] = $user_id;

            $userinterest = Userinterest::where ('user_id', '=', $user_id)->where ('topic_id', '=', $data['topic_id'])->first ();

            if ($userinterest) {

                $userinterest->delete ();
            }
                if($data['language_id']=="") $data['language_id']=0;
             //   if($data['grade_id']=="") $data['grade_id']=0;


                $userinterest = Userinterest::create ($data);




        }

        $userinterests = Userinterest::where ('user_id', '=', $user_id)->get ();
        return $userinterests;

    }

    protected function jsonvalidation (array $data)
    {
        return Validator::make (
            $data,
            [
              //  'grade_id' => 'nullable|exists:grades,id',
              //  'language_id' => 'nullable|exists:languages,id',
                'exercise_type' => 'nullable|in:1,2',
              //  'discipline_id' => 'nullable|exists:disciplines,id',
                'exercises_id' => 'nullable|string|max:800',
                'topic_id' => 'required|exists:topics,id',

            ], $this->messagevalidation ()
        );
    }

    protected function discipline_id_validation (array $data)
    {
        return Validator::make (
            $data,
            [
               'discipline_id' => 'nullable|exists:disciplines,id',


            ], $this->messagevalidation ()
        );
    }

    protected function gradevalidation (array $data)
    {
        return Validator::make (
            $data,
            [
                'grade_id' => 'nullable|exists:grades,id',


            ], $this->messagevalidation ()
        );
    }

    protected function languagevalidation (array $data)
    {
        return Validator::make (
            $data,
            [
                'language_id' => 'nullable|exists:languages,id',


            ], $this->messagevalidation ()
        );
    }

    public function unsetuserinterests ()
    {

        try {

            $today = date ("Ymd");
            $logsfile = "api.unsetuserinterests" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['user_token'] = Input::get ('user_token');
            $data['userselection'] = Input::get ('userselection');
            $validator = $this->userinterestsvalidator ($data);

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse ($messages);

                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                $responce = str_replace ("\r\n", "<br>", $responce);
                return json_encode ($responce);
            }

            $user = User::where ('remember_token', '=', $data['user_token'])->first ();

            if (!$user) {
                $messages = '101: user not exist';
                $responce = $this->rendererrorresponse ($messages);
                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                return json_encode ($responce);
            }
            $userinterests = $this->delete ($data, $user->id);
            Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($userinterests));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
            $responce = $this->renderresponse ($userinterests, "Successfully   Interested removed  ");
            return json_encode ($responce);
            //  return json_encode ($userinterests);

        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);

        }
    }

    private function delete ($data, $user_id)
    {
        $userselection = json_decode ($data['userselection'], true);;
        foreach ($userselection['data'] as $data) {
            $validator = $this->jsonvalidation ($data);
            if ($validator->fails ()) {

                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse ($messages);

                echo json_encode ($responce);
                dd ();

            }
            $data['user_id'] = $user_id;
            $userinterest = Userinterest::where ('user_id', '=', $user_id)->where ('topic_id', '=', $data['topic_id'])->first ();
            if ($userinterest) {
                $userinterest->delete ();
            }
        }

        $userinterests = Userinterest::where ('user_id', '=', $user_id)->get ();
        return $userinterests;

    }

    public function getuserinterests ()
    {

        try {
            //     $data['discipline_id'] = Input::get ('discipline_id');

            $today = date ("Ymd");
            $logsfile = "api.getuserinterests" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['user_token'] = Input::get ('user_token');
            $data['topic_id'] = Input::get ('topic_id');
            $validator = $this->uservalidator1 ($data);

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

            if ($validator->fails ()) {


                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse ($messages);
                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                $responce = str_replace ("\r\n", "<br>", json_encode ($responce));

                return json_encode ($responce);
            }

            $user = User::where ('remember_token', '=', $data['user_token'])->first ();

            if (!$user) {
                $messages = '101: user not exist';

                $responce = $this->rendererrorresponse ($messages);
                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                return json_encode ($responce);
            }

            $userinterests = Userinterest::where ('user_id', '=', $user->id);
                if(strlen($data['topic_id'])>0){$userinterests=$userinterests->where ('topic_id', '=', $data['topic_id']);}

            $userinterests=$userinterests->get ();

            if ($userinterests->count () == 0) {
                $messages = '101: NO interest  for this user';
                $responce = $this->rendererrorresponse ($messages);
                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                return json_encode ($responce);

            }

            Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($userinterests));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
            $responce = $this->renderresponse ($userinterests, "Success User   Interests Data ");
            return json_encode ($responce);

            return json_encode ($responce);

        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);
        }
    }

    protected function uservalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'user_token' => 'required|string|max:500',

            ], $this->messagevalidation ()
        );


    }


}