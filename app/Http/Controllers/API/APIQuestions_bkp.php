<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exercisesetbuyer;
use App\Models\Exerciseset;
use App\Models\Userinterest;
use App\Models\Question;
use App\Models\Answeroption;
use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;
use App\Models\Discipline;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp;
use File;
use Mustache_Engine;
use Response;
use Illuminate\Support\Facades\Route;
use App\Mail\ReportQuestionMail;
use Illuminate\Support\Facades\DB;
use App\Models\gamePreference;

class APIQuestions_bkp extends Controller
{
      // getquestions, getfreequestions, getpurchasedquestions
    // single_question, reportquestion,
    // questionvalidator1, topicvalidator1, singlequestionvalidator1, messagevalidation,
    // rendererrorresponse, renderresponse
    // renderquestion, renderanswer, renderquestion1,


    /**
     * filter questions based on parameters. return questions
     * int $topic_id, int $discipline_id=0, int $language_id=0, int $grade_id=0, int $maxtime=0, int $size=0,
     * int $haspassage=0, int $questiontype=0, string $exercise_id_list=''
     */
    public function filterquestions(int $topic_id, int $discipline_id, int $language_id, int $grade_id, int $maxtime, int $size,
        int $haspassage, int $questiontype, string $exercise_id_list='')
    {
        //dd($topic_id, $discipline_id,$language_id,$grade_id, $maxtime, $size,$haspassage, $questiontype,$exercise_id_list);
        //collect all the questions that fulfill the parameters and are free or purchased by the user
        //--TODO add the questions purchased by the user
        //--TODO take the remaining arguments into account: maxtime, size, haspassage, questiontype
        //dd(strlen($exercise_id_list));
        if (strlen($exercise_id_list) > 1) { 
        //$exercise_id_list has some ids, no need to look at any other argument
            $exercise_id = preg_split("/[,]/", $exercise_id_list);
            $exerciseset = Exerciseset::wherein('id', $exercise_id);
        }else {
            
            if ($discipline_id == 0) {
                //discipline is not specified, return all discipline's curricula for this discipline_topic
                $discipline_id_list = Discipline::where('topic_id', '=', $topic_id)->pluck('id')->all();

                if ($discipline_id_list) {

                    //$exerciseset = Exerciseset::wherein('discipline_id', $discipline_id_list)->pluck('id')->all();
                    $exerciseset = Exerciseset::wherein('discipline_id', $discipline_id_list)->get();
                    //dd($exerciseset);
                } else return null; //no disciplines found for this topic
            } else {
                //discipline_id is specified no need to look at the topic argument
                $exerciseset = Exerciseset::where('discipline_id', '=', $discipline_id)->where('price', '=', '0')->get();
                //$purchasedexercises = $user->exercises->where('discipline_id', '=', $data['discipline_id']);
            }
            if ($language_id != 0) $exerciseset = $exerciseset->where('language_id', '=', $language_id);
            if ($grade_id != 0) $exerciseset = $exerciseset->where('grade_id', '=', $grade_id);
            //dd($exerciseset->toArray());
        }

        //$exerciseset = $exerciseset->get();
        //$purchasedexercises = collect($purchasedexercises->all());

        $ids=$exerciseset->pluck('id');
          //dd($ids);
        $questions = Question::wherein('exercise_id', $ids)->inRandomOrder()->get();
        $questions=$questions->unique ();
        //dd($questions->toArray());
        return $questions;
    }
    
    public function retrieveCodeQuestion (){
        $user=User::where('remember_token',Input::get ('user_token'))->first();
        if ($user) {
            $gamePreference =  gamePreference::where ('code' , '=' , Input::get ('code'))->where ('user_id' ,'=', $user->id)->first();
            if (!$gamePreference) {
                $messages= "101: this  codes don't belong to this user";
                $responce = $this->rendererrorresponse($messages);
                return  json_encode ($responce);
            }
            else {
              $topic_id=$gamePreference->topic_id;
              $exercise_id_list=$gamePreference->list_exercise_ids;
              $codeQuestion=  $this->filterquestions($topic_id, $discipline_id=0,$language_id=0,$grade_id=0, $maxtime=0, $size=0,$haspassage=0, $questiontype=0,$exercise_id_list);
              $responce = $this->renderresponse ($codeQuestion, "Success game Preference code  generated ");
              return json_encode ($responce);
          }
      }
      else{
        $messages= '101: user not exist';
        $responce = $this->rendererrorresponse($messages);
        return json_encode ($responce);
    }
}

    /**
     * returns questions and answers for user_token based on the request filters used by the game
     * calls questionvalidator1, rendererrorresponse
     */
    public function getquestions()
    {
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
        $data['exercise_id']=Input::get ('exercise_id');        //optional List
        $data['question_id']=Input::get ('question_id');        //optional List
        $data['params']=0;                                          //optional List
        $data['topic_id']=Input::get ('topic_id');//optional List
        $data['code']=Input::get ('code');

        if(strlen ( $data['nubofquestions'])==0)  $data['nubofquestions']=$defaultmaxnubofquestion;

        $validator = $this->questionvalidator1 ($data,false);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        if ($user) {

            if($data['code'])
            {
                $gamePreference=gamePreference::where ('code' , '=' ,$data['code'])->first();
                if (!$gamePreference) {
                    $messages= "101: The code does not exists.";
                    $responce = $this->rendererrorresponse($messages);
                    return  json_encode ($responce);
                } else {
                    $topic_id = $gamePreference['topic_id'];
                    if(empty($topic_id)){
                     $topic_id=0;
                    }
                    $discipline_id = $gamePreference['discipline_id'];
                    if(empty($discipline_id)){
                     $discipline_id=0;
                    }
                    $language_id = $gamePreference['language_id'];
                    if(empty($language_id)){
                     $language_id=0;
                    }
                    $grade_id = $gamePreference['grade_id'];
                    if(empty($grade_id)){
                     $grade_id=0;
                    }
                    $maxtime = $gamePreference['maxtime'];
                    if(empty($maxtime)){
                     $maxtime=0;
                    }
                    $size = $gamePreference['size'];
                    if(empty($size)){
                     $size=0;
                    }
                    $haspassage = $gamePreference['haspassage'];
                    if(empty($haspassage)){
                     $haspassage=0;
                    }
                    $questiontype = $gamePreference['questiontype'];
                    if(empty($questiontype)){
                     $questiontype=0;
                    }
                    $exercise_id_list = $gamePreference['list_exercise_ids'];
                    if(empty($exercise_id_list)){
                     $exercise_id_list=0;
                    }
                }
            }
            else
            {
                $topic_id = $data['topic_id'];
                if(empty($topic_id)){
                     $topic_id=0;
                }
                $discipline_id = $data['discipline_id'];
                if(empty($discipline_id)){
                     $discipline_id=0;
                }
                $language_id = $data['language_id'];
                if(empty($language_id)){
                     $language_id=0;
                }
                $grade_id = $data['grade_id'];
                if(empty($grade_id)){
                     $grade_id=0;
                }
                $maxtime = $data['maxtime'];
                if(empty($maxtime)){
                     $maxtime=0;
                }
                $size = $data['size'];
                if(empty($size)){
                     $size=0;
                }
                $haspassage = $data['haspassage'];
                if(empty($haspassage)){
                     $haspassage=0;
                }
                $questiontype = $data['questiontype'];
                if(empty($questiontype)){
                     $questiontype=0;
                }
                $exercise_id_list = $data['exercise_id'];
                if(empty($exercise_id_list)){
                     $exercise_id_list=0;
                }

                //$data['nubofquestions'] = Input::get ('nubofquestions');//optional parameter ,	Default number of question 10.
            }
            $output = implode(', ', array_map(
                function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
                $data,
                array_keys($data)
            ));
            Storage::disk('local')->append('AAA.txt', $output);
            //Storage::disk('local')->append('AAA.txt', $gamePreference);

            $questions=  $this->filterquestions($topic_id, $discipline_id,$language_id,$grade_id, $maxtime, $size,$haspassage, $questiontype,$exercise_id_list);

            $codeQuestion = [];
            foreach ($questions as $question)
            {
                $question['url'] = asset('assets/images/output/') ."/Q_" .$question->id .".png";
                $question['json_details']=asset('/api/getquestion_id?id=')  .$question->id ;
                $question['params']=rand(0,5);
                $question['details']='';
                $question->answeroptions=$question->apiansweroptions;
                unset($question->apiansweroptions);
                $answers=$question->answeroptions;
                $j=0;
                if ($question->param<>null) {
                    $excelques=$question->renderQuestion($question->id);
                    $question['details']=$excelques[0];
                }
                $answerid='';
                $al='A';
                foreach($answers as $answer){
                    if ($question->param<>null) {
                        $m = new Mustache_Engine;
                        $answer_details=  $m->render($answer->details, $excelques[1]);
                    }

                    $question->answeroptions[$j]['details']=$al;
                    $question->answeroptions[$j]['url']=asset('assets/images/output/') ."/A_" .$answer->id .".png";

                    $question->answeroptions[$j]['a_url']=asset('api_answer/') ."/" .$answer->id;
                    $answerid.=$answer->id.",";
                    $j++;
                    $al++;
                }

                $answerid=substr($answerid, 0, -1);
                //dd(asset('/api/single_question?user_token='.$data['remember_token'].'&id='.$question->id.'&ans_ids='.$answerid));
                $question['q_url']=asset('/api/single_question?user_token='.$data['remember_token'].'&id='.$question->id.'&ans_ids='.$answerid) ;
                $val=  $answer =$question->answeroptions;
                $codeQuestion[] = $question;
            }
            //dd($codeQuestion);
			  $responce = $this->renderresponse ($codeQuestion, "Success game Preference code  generated ");
			  return json_encode ($responce);
          

            // $gamePreference =  gamePreference::where ('user_id' ,'=', $user->id)->first();
            // if($data['code']){
            //     $gamePreference=gamePreference::where ('code' , '=' ,$data['code'])->first();
            // }
            // else{
            //     $gamePreference=gamePreference::orderBy('id', 'desc')->first();
            // }
            //Storage::disk('local')->append('AAA.txt', $gamePreference);
            // if (!$gamePreference) {
            //     $messages= "101: this  codes don't belong to this user";
            //     $responce = $this->rendererrorresponse($messages);
            //     return  json_encode ($responce);
            // }
        //     else {

        //       $topic_id=$gamePreference->topic_id;
        //        if(empty($topic_id)){
        //             $topic_id=0;
        //        }
        //       $exercise_id_list=$gamePreference->list_exercise_ids;
              
        //       $discipline_id=$gamePreference->discipline_id;
        //       if(empty($discipline_id)){
        //             $discipline_id=0;
        //        }
        //       $language_id=$gamePreference->language_id;
        //        if(empty($language_id)){
        //             $language_id=0;
        //        }
        //       $grade_id=$gamePreference->grade_id;
        //        if(empty($grade_id)){
        //             $grade_id=0;
        //        }
        //       $maxtime=$gamePreference->maxtime;
        //        if(empty($maxtime)){
        //             $maxtime=0;
        //        }
        //       $size=$gamePreference->size;
        //        if(empty($size)){
        //             $size=0;
        //        }
        //       $haspassage=$gamePreference->haspassage;
        //       if(empty($haspassage)){
        //             $haspassage=0;
        //        }
        //       $questiontype=$gamePreference->questiontype;
        //       if(empty($questiontype)){
        //             $questiontype=0;
        //        }

        //        $output = implode(', ', array_map(
        //             function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
        //             $data,
        //             array_keys($data)
        //         ));
        //        Storage::disk('local')->append('AAA.txt', $output);
        //        Storage::disk('local')->append('AAA.txt', $gamePreference);
        //     //    $topic_id = $data['topic_id'];
        //     //    $discipline_id = $data['discipline_id'];
        //     //    $grade_id = $data['grade_id'];

        //     $questions=  $this->filterquestions($topic_id, $discipline_id,$language_id,$grade_id, $maxtime, $size,$haspassage, $questiontype,$exercise_id_list);
            
        //     $codeQuestion = [];
        //     foreach ($questions as $question)
        //     {
        //         $question['url'] = asset('assets/images/output/') ."/Q_" .$question->id .".png";
        //         $question['json_details']=asset('/api/getquestion_id?id=')  .$question->id ;
        //         $question['params']=rand(0,5);
        //         $question['details']='';
        //         $question->answeroptions=$question->apiansweroptions;
        //         unset($question->apiansweroptions);
        //         $answers=$question->answeroptions;
        //         $j=0;
        //         if ($question->param<>null) {
        //             $excelques=$question->renderQuestion($question->id);
        //             $question['details']=$excelques[0];
        //         }
        //         $answerid='';
        //         $al='A';
        //         foreach($answers as $answer){
        //             if ($question->param<>null) {
        //                 $m = new Mustache_Engine;
        //                 $answer_details=  $m->render($answer->details, $excelques[1]);
        //             }

        //             $question->answeroptions[$j]['details']=$al;
        //             $question->answeroptions[$j]['url']=asset('assets/images/output/') ."/A_" .$answer->id .".png";

        //             $question->answeroptions[$j]['a_url']=asset('api_answer/') ."/" .$answer->id;
        //             $answerid.=$answer->id.",";
        //             $j++;
        //             $al++;
        //         }

        //         $answerid=substr($answerid, 0, -1);
        //         $question['q_url']=asset('/api/single_question?user_token='.$data['remember_token'].'&id='.$question->id.'&ans_ids='.$answerid) ;
        //         $val=  $answer =$question->answeroptions;
        //         $codeQuestion[] = $question;
        //     }
                
        //       $responce = $this->renderresponse ($codeQuestion, "Success game Preference code  generated ");
        //       return json_encode ($responce);
        //   }
      }
      else{
        $messages= '101: user not exist';
        $responce = $this->rendererrorresponse($messages);
        return json_encode ($responce);
    }
    }

    /**
     * get the count of questions returned by the parameters. the count is calculated from the count field
     */
    public function getCountOfQuestions()
    {
        //--TODO add the count of the purchased questions
        $defaultmaxtime=5000;
        $data = array();
        $data['remember_token'] = Input::get ('user_token');
        $data['language_id'] = Input::get ('language_id');
        $data['topic_id']=Input::get ('topic_id');              //if discipline_id is not null you don't need the topic_id
        $data['discipline_id'] = Input::get ('discipline_id');  //optional parameter if not exist  select from user interest, if null get the exercises with no curriculum
        $data['grade_id'] = Input::get ('grade_id');            //optional parameter ,can not exist if discipline_id param is not passed, if not exist get from user interest
        $data['exercise_id']=Input::get ('exercise_id');        //optional List, if exist limit the questions to this list

        $data['questiontype'] = Input::get ('questiontype');    //optional parameter
        $data['maxtime'] = Input::get ('maxtime');              //optional parameter
        $data['size']=Input::get ('size');                      //optional parameter
        $data['haspassage']=Input::get ('haspassage');          //optional parameter

        $validator = $this->questionvalidator1 ($data,false);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        if ($user) {
            if (strlen ($data['maxtime']) == 0) $data['maxtime'] = $defaultmaxtime  ;

            $validator = $this->topicvalidator1 ($data);
            if ($validator->fails ()) {
              $messages = $validator->errors ()->first ();
              $responce = $this->rendererrorresponse($messages);
              return  json_encode ($responce);
          }

          $userinterest = Userinterest::where('user_id', '=', $user->id)->where('topic_id', '=', $data['topic_id'])->first();
          if ( strlen($data['discipline_id'])==0 &&$userinterest !=null ) $data['discipline_id']= $userinterest->discipline_id;

            //return the questions that verify the criteria
           $questions=$this->filterquestions(1,0,0,0,0,0,0,0,'');

      }

      $questions=$questions->unique ();
      $count = collect(['count' => $questions->sum('question_count')]);

      if($questions->count()==0) {
        $messages =  '101 :no question  exist';
        $responce = $this->rendererrorresponse($messages);
        return  json_encode ($responce);
    }

    $responce = $this->renderresponse ($count, "Success , Count of questions ");
    return json_encode ($responce);
}

    /**
 * render a question by id , return  an html  for one question
 */
    public function single_question ()
    {
        $data=array();
        $data['id'] =Input::get ('id');
        $data['remember_token'] = Input::get ('user_token');
        $data['ans_ids'] = Input::get ('ans_ids');

        $validator = $this->singlequestionvalidator1($data);
        if ($validator->fails ()) {
            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

        $question = Question::findorfail ( $data['id']);

        $jsonArr = array();

        $ans_ids = explode(",",$data['ans_ids']);
        $user = User::where ('remember_token', '=', $data['remember_token'])->first();
        $jsonArr[] = json_decode($question->paramRenderQuestion($user),TRUE);

        $data = [];

        for($i=0; $i<count($ans_ids); $i++){
            $data[$i] = $this->getOderedAnsware($jsonArr[0]['Questions'][0]['Answers']['Choices'],$ans_ids[$i]);
        }

        $jsonArr[0]['Questions'][0]['Answers']['Choices'] = $data;
       
        // Shuffle Answers
    //     foreach ($jsonArr as $key =>  $val) {
    //       $shuffleAns = $val['Questions'][0]['Answers']['Choices'];
    //       shuffle($shuffleAns);
    //       $jsonArr[$key]['Questions'][0]['Answers']['Choices'] = $shuffleAns;

    //       foreach($val['Questions'][0]['Hints']['HintList'] as $hkey => $hintlist){
    //           $jsonArr[$key]['Questions'][0]['Hints']['HintList'][$hkey]['index'] = ($hkey+1);
    //       }
    //   }

        $question = json_encode($jsonArr,TRUE);
    
        return view ('questions.game_single_question', compact ('question'));
    }


    public function getOderedAnsware($choices,$ans_id){
        
        foreach($choices as $chkey => $choice){

            if($choice['Attributes']['id'] == $ans_id){
                return $choice;
            }
            
        }

    }

    /**
     * user can report questions with problem, Exercise set owner will be sent an e-mail
     */
    public function reportquestion()
    {

        $data = array();
        $datamail = array();
        $data['remember_token'] = Input::get ('remember_token');
        $data['question_id'] = Input::get ('question_id');
        $data['reporttext'] = Input::get ('reporttext');

        $validator = $this->questionvalidator1 ($data,false);
        if ($validator->fails ()) {
            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

        $user = User::select('id','name','email')->where ('remember_token', '=', $data['remember_token'])->first ();
       

        if ($user){

            $question = Question::find($data['question_id']);
            if(isset($question)){
                $email = $question->exercise->owner->email;
            $email = "hass74@gmail.com";
            \Illuminate\Support\Facades\Mail::to($email)->send(new ReportQuestionMail($user, $question, $data['reporttext']));
            
            // Register Sending Operation locally
            Storage::disk ('local')->append('emailing.txt', "Send Mail:\r\nTo:" . $email . " From: APIQuestions_bkp@reportquestion ");
            Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
            


            $datamail['to']=$email;
            $responce=$this->renderresponse($datamail,"Email sent successfully" );
            return json_encode($responce); 
            }
            else{
                $messages= '101: Question id not exist';
        $responce = $this->rendererrorresponse($messages);
        return json_encode ($responce);
            }
            
           
        }
        else{
            $messages= '101: user not exist';
        $responce = $this->rendererrorresponse($messages);
        return json_encode ($responce);
        }
    }

    /**
     * validate the parameters of the getquestions()
     */
    protected function questionvalidator1 (array $data ,$codeReq = true)
    {
        $validator = [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
             //   'topic_id' => 'required|exists:topics,id|numeric|min:1|max:5000',
                'discipline_id'=>'nullable|exists:disciplines,id',
                'maxtime'=>'nullable|numeric|min:1|max:5000',
                'questiontype'=> 'nullable|in:text,image,audio,video,richtext',
                'grade_id'=>'nullable|numeric|exists:grades,id',
                'nubofquestions'=>'nullable|numeric|min:1|max:200',
                'language_id' => 'nullable|exists:languages,id',
                'size'=>'nullable|numeric|min:1|max:5000',
                // 'question_id'=>'required_without:code',
                'question_id'=>'nullable|numeric|min:1|max:5000',
                'reporttext'=>'nullable'
                

            ];
            if($codeReq){
                $validator['code'] = 'required';
            }
        return Validator::make (
            $data,$validator
            , $this->messagevalidation ()
        );
    }

    /**
     * validates if the topic is valid
     */
    protected function topicvalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'topic_id' => 'required|exists:topics,id|numeric|min:1',
            ], $this->messagevalidation ()
        );
    }

    /**
     * validates the data passed to a singlequestion
     */
    protected function singlequestionvalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'id'=>'required|exists:questions,id|numeric|min:1|max:5000',
                'ans_ids' => 'required|string|max:500',

            ], $this->messagevalidation ()
        );
    }

    /**
     * messages returned after validation error
     */
    private function messagevalidation ()
    {

        return $messages = array(
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' =>'101: user not exist',

            'question_id.numeric' =>'101:question_id must be Integer ',
            'question_id.min' =>'101:question_id must be >0 ',
            'reporttext.exists' =>'101: Empty  report text ',

            'discipline_id.exists' =>'101: Discipline not exist',
            'maxtime.numeric' =>'101:maxtime must be Integer ',
            'maxtime.min' =>'101:maxtime must be >0 ',
            'questiontype.in'=>'101:question type must be :text,image,audio,video or richtext',
            'grade_id.exists' =>  '101: grade id is not existing',
            'nubofquestions.min' =>'101 :number  of questions must be >0 ',
            'nubofquestions.max' =>'101 :number  of questions must be <=50 ',
            'language_id.exists' =>  '101: language id is not existing',
            'size.numeric'=>'101: the size must be number between 1  and 5000',
            'size.min'=>'101: the size is less then 1 , it  must be number between 1  and 5000 ',
            'size.max'=>'101: the size has pass the 5000 , it  must be number between 1  and 5000 ',

            'ans_ids.required' => '101:Empty Answers id.',
        );
    }

    /**
     * render an error response for the API
     */
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

   /**
    * render the response to the game API
    */
   private function renderresponse($data , $message)
   {
    $response=array();
    $response['status']="1";
    $response['message']= $message ;
    $response['data']=$data;
        return $response; // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }
    public function codeVerification(){
        $data = array();
        $data['remember_token'] = Input::get ('user_token');
        $data['code'] = Input::get ('code');
        $validator = $this->questionvalidator1 ($data);
        if ($validator->fails ()) {
            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }
        else{
            $user=User::where('remember_token',Input::get ('user_token'))->first();
        if ($user) {
            $gamePreference =  gamePreference::where ('code' , '=' , Input::get ('code'))->first();
            if (!$gamePreference) {
                $messages= "101: Code doesn't exsist.";
                $responce = $this->rendererrorresponse($messages);
                return  json_encode ($responce);
            }
            else {
                $response_json['status'] = "1";
                $response_json['message'] = "code match successfully";
                return json_encode ($response_json);
          }
      }
      else{
        $messages= '101: user not exist';
        $responce = $this->rendererrorresponse($messages);
        return json_encode ($responce);
    }
        }
       
    }
}
