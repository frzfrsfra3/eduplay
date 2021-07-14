<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13/03/2019
 * Time: 12:25 PM
 */

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\gamePreference;
use App\Models\User;
use App\Models\Exerciseset;
use App\Models\Skill;
use App\Models\Skillcategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Log;
use Illuminate\Support\Facades\Storage;




class APIgamePreference
{

    public  function  setGamePreference (){

        $defaultmaxtime=5000;
        $defaultmaxnubofquestion=10;


        $data = array();
        $data['remember_token'] = Input::get ('user_token');
        $data['discipline_id'] = Input::get ('discipline_id');  //optional parameter if not exist  select from user interest
        $data['maxtime'] = Input::get ('maxtime');              //optional parameter
        $data['questiontype'] = Input::get ('questiontype');    //optional parameter
        $data['grade_id'] = Input::get ('grade_id');            //optional parameter ,if not exist select from user profile
        $data['nubofquestions'] = Input::get ('nubofquestions');//optional parameter ,	Default number of question 10.
        $data['language_id'] = Input::get ('language_id');      //optional parameter
        $data['size']=Input::get ('size');                      //optional parameter
        $data['haspassage']=Input::get ('haspassage');          //optional parameter
        $data['list_exercise_ids']=Input::get ('exercise_id');        //optional List
        $data['question_id']=Input::get ('question_id');        //optional List
        $data['topic_id']=Input::get ('topic_id');//optional List
        $data['skill_category_id']=Input::get ('skill_category_id');//optional List
        $data['skill_id']=Input::get ('skill_id');//optional List

        $validator = $this->validator ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        if ($user) {

            if (strlen ($data['maxtime']) == 0) $data['maxtime'] = $defaultmaxtime  ;
            if (strlen ($data['nubofquestions']) == 0) $data['nubofquestions'] = $defaultmaxnubofquestion  ;
        }
        $data['user_id']=$user->id;
        $data['code']=$this->generateCode();
        $gamePreference =  gamePreference::create ($data);
        $responce = $this->renderresponse ($gamePreference, "Success game Preference code  generated ");
        return json_encode ($responce);

    }

    public function listOfCodes ()
    {
        $data = array();
        $data['remember_token'] = Input::get ('user_token');


        $validator = $this->tokenValidator ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        if ($user) {
            $gamePreferencesdata=[];		
            $gamePreferences =  gamePreference::with('topic','user.grade.curriculum_gradelist','user.exercises')->where ('user_id' , '=' , $user->id)->get();


            if ($gamePreferences->count()==0) {

                $messages= "101: no codes exist for this user";
                $responce = $this->rendererrorresponse($messages);
                return  json_encode ($responce);

            }
            else {
                foreach ($gamePreferences as $key=>$game) {	
                $responce = $this->renderresponse ($gamePreferences, "Success list of codes ");
                    $gamePreferencesdata[$key]['code']=$game->code;     
                    $gamePreferencesdata[$key]['topic']=$game->topic->topic_name;
                    $gamePreferencesdata[$key]['curriculum']='';
                    $gamePreferencesdata[$key]['grade']=''; 
                    $gamePreferencesdata[$key]['exercises']=[];  

                    // get skill categories
                    $skillCatsIds = explode(',', $game->skill_category_id);
                    $skillCategories = [];
                    foreach ( $skillCatsIds as $skillCatId )
                    {
                        $skillCategory = Skillcategory::find($skillCatId);
                        if ( $skillCategory )
                        {
                            $skillCategories[] = $skillCategory->skill_category_name;
                        }
                    }
                    $gamePreferencesdata[$key]['skill_categories'] = $skillCategories;
                    
                    // get skills 
                    $skillIds = explode(',', $game->skill_id);
                    $skills = [];
                    foreach ( $skillIds as $skillId )
                    {
                        $skill = Skill::find($skillId);
                        if ( $skill )
                        {
                            $skills[] = $skill->skill_name;
                        }
                    }
                    $gamePreferencesdata[$key]['skills'] = $skills;

                if(isset($game->list_exercise_ids) && !empty($game->list_exercise_ids)){
              $Exerciseset_list=Exerciseset::whereIn('id',explode(',', $game->list_exercise_ids))->get();
                     foreach ($Exerciseset_list as $subkey => $exercises) {
                                $gamePreferencesdata[$key]['exercises'][$subkey]['id'] = $exercises->id;
                                $gamePreferencesdata[$key]['exercises'][$subkey]['title'] = $exercises->title;
                            }
          
                    }
                    if(isset($game->discipline) || !empty($game->discipline)){		
                      	
                          $gamePreferencesdata[$key]['curriculum']=$game->discipline->discipline_name;	
                    }	
                    if(isset($game->grade) || !empty($game->grade))	{
                        $gamePreferencesdata[$key]['grade']=$game->grade->grade_name;
                    }
                }		
                $responce = $this->renderresponse ($gamePreferencesdata, "List of Code response");		
                return json_encode ($responce);
            }
        }
    }

    public function deleteCodes ()
    {
        $data = array();
        $data['remember_token'] = Input::get ('user_token');
        $data['code'] = Input::get ('code');


        $validator = $this->deletecodeValidator ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        if ($user) {

            $gamePreference =  gamePreference::where ('code' , '=' , $data['code'])->where ('user_id' ,'=', $user->id)->first();


            if (!$gamePreference) {

                $messages= "101: Code doesn't exsist.";
                $responce = $this->rendererrorresponse($messages);
                return  json_encode ($responce);

            }
            else {
                $gamePreference->delete();
                $response_json['status'] = "1";
                $response_json['message'] = "Code deleted successfully.";
                return json_encode ($response_json);
            }
        }
    }

    protected  function generateCode ()
    {
        $codeLength =8;


        $codeExist=true;

        while (  $codeExist ) {
            $code =substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $codeLength);
            $gamePreference =gamePreference::where ('code' , '=' ,$code)->first();

            if  ( $gamePreference )  $codeExist=true;
            else  $codeExist=false;

        }

        return  $code;


    }



    protected function validator (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'discipline_id'=>'nullable|exists:disciplines,id',
                'questiontype'=> 'nullable|in:text,image,audio,video,richtext',
                'maxtime'=>'nullable|numeric|min:1|max:5000',
                'grade_id'=>'nullable|numeric|exists:grades,id',
                'nubofquestions'=>'nullable|numeric|min:1|max:200',
                'language_id' => 'nullable|exists:languages,id',
                'size'=>'nullable|numeric|min:1|max:5000',
                'question_id'=>'nullable|numeric|min:1',
                'topic_id' => 'required|exists:topics,id|numeric|min:1|max:5000',
                'skill_category_id' => 'nullable',
                'skill_id' => 'nullable',
           ], $this->messagevalidation ()
        );

    }


    protected function tokenValidator (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',

            ], $this->messagevalidation ()
        );

    }


    protected function deletecodeValidator (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'code' => 'required|exists:game_preferences,code',

            ], $this->messagevalidation ()
        );

    }

    private function messagevalidation ()
    {

        return $messages = array(
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' =>'101: user not exist',

            'question_id.numeric' =>'101:question_id must be Integer ',
            'question_id.min' =>'101:question_id must be >0 ',


            'discipline_id.exists' =>'101: Discipline not exist',
            'maxtime.numeric' =>'101: maxtime must be Integer ',
            'maxtime.min' =>'101:maxtime must be >0 ',
            'maxtime.max' =>'101:maxtime must be <5000 ',
            'questiontype.in'=>'101:question type must be :text,image,audio,video or richtext',
            'grade_id.exists' =>  '101: grade id is not existing',
            'nubofquestions.min' =>'101 :number  of questions must be >0 ',
            'nubofquestions.max' =>'101 :number  of questions must be <=200 ',
            'language_id.exists' =>  '101: language id is not existing',
            'size.numeric'=>'101: the size must be number between 1  and 5000',
            'size.min'=>'101: the size is less then 1 , it  must be number between 1  and 5000 ',
            'size.max'=>'101: the size has pass the 5000 , it  must be number between 1  and 5000 ',

            'topic_id.exists' =>'101: Topic Id not exist',
            'topic_id.numeric' =>'101: Topic Id must be Number',
            'code.required' =>'101: code is missing',
            'code.exists' =>'101: this code not exist',
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
        return $response; // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }

}