<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/17/2018
 * Time: 1:01 PM
 */

/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace app\React\API;

use App\Http\Controllers\Controller;
use App\Models\Exercisesetbuyer;
use App\Models\Exerciseset;
use App\Models\Question;
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


class APIQuestions extends Controller





{

    public function question2image(){
        $data = array();
        $data['remember_token'] = Input::get ('user_token');
        $data['question_id'] = Input::get ('question_id');

    }


    public function getquestions() {
        $defaultmaxtime=5000;
        $defaultmaxnubofquestion=200;


        $imagespath=url('/Images');
        $data = array();
        $data['remember_token'] = Input::get ('user_token');
        $data['discipline_id'] = Input::get ('discipline_id');  //optional parameter if not exist  select from user interest
        $data['maxtime'] = Input::get ('maxtime');  //optional parameter
        $data['questiontype'] = Input::get ('questiontype');  //optional parameter
        $data['grade_id'] = Input::get ('grade_id');  //optional parameter ,if not exist select from user profile
        $data['nubofquestions'] = Input::get ('nubofquestions'); //optional parameter ,	Default number of question 10.
        $data['language_id'] = Input::get ('language_id');//optional parameter
        $data['size']=Input::get ('size');//optional parameter
        $data['haspassage']=Input::get ('haspassage');//optional parameter
        $data['exercise_id']=Input::get ('exercise_id');//optional List
        $data['question_id']=Input::get ('question_id');//optional List

        if(strlen ( $data['nubofquestions'])==0)  $data['nubofquestions']=$defaultmaxnubofquestion;

        $validator = $this->questionvalidator1 ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
            //   return $responce;
        }

        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        if ($user) {
            if (strlen ($data['maxtime']) == 0) $data['maxtime'] = $defaultmaxtime  ;
            if (strlen ($data['nubofquestions']) == 0) $data['nubofquestions'] = $defaultmaxnubofquestion  ;
//dd($data['exercise_id']);
            if (strlen($data['exercise_id']>0))
                {
                    $exercise_id= preg_split("/[,]/",$data['exercise_id']);

                $questions=Question::wherein('exercise_id',$exercise_id)->get();
                }

            else if (strlen($data['question_id']>0))
                {
                     $questions=Question::where('id',$data['question_id'])->get();
                }
            else
                {

                $purchasedquestions = $this->getpurchasedquestions($data, $user);
                $freequestions = $this->getfreequestions($data, $user);
                $questions = new Collection;
                $questions = $questions->merge($purchasedquestions);
                $questions = $questions->merge($freequestions);

                }


          //  $questions=$questions->unique ();

            if($questions->count()==0) {
                $messages =  '101 :no question  exist';
                $responce = $this->rendererrorresponse($messages);
                return  json_encode ($responce);
            }
            $questions = $questions->shuffle();
            $questions=$questions->take( $data['nubofquestions']);


            $i=0;

            foreach ($questions as $question)
            {
                $question['url'] = asset('assets/images/output/') ."/Q_" .$question->id .".png";
                $question['json_details']=asset('/api/getquestion_id?id=')  .$question->id ;
                $question['q_url']=asset('/api_question/')."/".$question->id ;
                $question['details']='';
                $answers=$question->answeroptions;
                $j=0;
                if ($question->param<>null) {
                    $excelques=$question->renderQuestion($question->id);
                    $question['details']=$excelques[0];

                }
                $answers=$answers->shuffle();

                foreach($answers as $answer){
                    if ($question->param<>null) {
                        $m = new Mustache_Engine;
                        $answer_details=  $m->render($answer->details, $excelques[1]);
                        $question->answeroptions[$j]['details']=$answer_details; }

                    $question->answeroptions[$j]['url']=asset('assets/images/output/') ."/A_" .$answer->id .".png";
                    $question->answeroptions[$j]['a_url']=asset('api_answer/') ."/" .$answer->id;
                     // $val= $this->renderanswer( $question->answeroptions[$j]['details'] ,"A_" .$answer->id .".png" ,$answer->id);
                    $j++;
                }
               // $this->renderquestion( $question['details'] ,"Q_" .$question->id .".png" ,$question->id);

                $val=  $answer =$question->answeroptions;
                //Storage::disk ('local')->append ('$questionS', json_encode($question));
                //  echo (json_encode($question));
                // array_push ($listofquestions ,);


                $i++;
                if($i <>$questions->count()) {
                    //  echo ",";

                }

            }
            // echo "]";
            $responce = $this->renderresponse ($questions, "Success list of questions ");
            return json_encode ($responce);
            return ;

        }
    }


    protected  function getfreequestions ( $data , $user ){
        $discipline_exsrcieset =new  Collection;
        $discipline_exercises =new Collection;
        if (strlen ($data['grade_id']) <> 0)
        {
            if (strlen ($data['discipline_id']) == 0)  $grade_exsrcieset=Exerciseset::where('grade_id', '=', $data['grade_id'])->where('price','=',0);
            if (strlen ($data['discipline_id']) <> 0)  $grade_exsrcieset=Exerciseset::where('grade_id', '=', $data['grade_id'])->where('discipline_id', '=', $data['discipline_id'])->where('price','=',0);;
        }
        else {
            if (strlen ($data['discipline_id']) == 0)  $grade_exsrcieset=Exerciseset::where('grade_id', '=', $user->grade_id)->where('price','=',0);;
            if (strlen ($data['discipline_id']) <> 0)   $grade_exsrcieset=Exerciseset::where('grade_id', '=', $user->grade_id)->where('discipline_id', '=', $data['discipline_id'])->where('price','=',0);;

        }
        //  $gradequestions=$grade_exsrcieset->question;

        if (strlen ($data['discipline_id']) <> 0) {

            if (strlen ($data['grade_id']) == 0)  $discipline_exsrcieset=Exerciseset::where('discipline_id', '=', $data['discipline_id'])->where('grade_id', '=', $user->grade_id)->where('price','=',0);;
            if (strlen ($data['grade_id']) <> 0) $discipline_exsrcieset=Exerciseset::where('discipline_id', '=', $data['discipline_id'])->where('grade_id', '=', $data['grade_id'])->where('price','=',0);;
            $discipline_exsrcieset=$discipline_exsrcieset->get();
            //   $disciplinequestions=$discipline_exsrcieset->question;

        }
        else {

            $user_disciplines=$user->disciplines;


            foreach($user_disciplines as $user_discipline) {

                if (strlen ($data['grade_id']) == 0)  $discipline_exercise=Exerciseset::where('discipline_id', '=', $user_discipline->id)
                     ->where('price','=',0)->get();
                if (strlen ($data['grade_id']) <> 0)  $discipline_exercise=Exerciseset::where('discipline_id', '=', $user_discipline->id)
                    ->where('grade_id', '=', $data['grade_id'])->where('price','=',0)->get();
                $discipline_exercises=$discipline_exsrcieset ->merge($discipline_exercise);
            }
        }


        if ($discipline_exercises) {
            $freedexsrcieset = $discipline_exercises->merge ($grade_exsrcieset->get ());
        }
        $freedexsrcieset = $freedexsrcieset->unique();


        if(strlen ($data['language_id'])<>0) $freedexsrcieset=$freedexsrcieset->where ('language_id' ,'=',$data['language_id']);
        $freequestions =new Collection;
        foreach($freedexsrcieset as $exercise) {
            $freequestion=$exercise->question;
            $freequestions=  $freequestions->merge($freequestion);
        }


        $freequestions = $freequestions->unique();
        $freequestions=$freequestions->where('maxtime','<=',$data['maxtime']);

        if(strlen ($data['questiontype'])<>0)  {

            $freequestions=$freequestions->where('questiontype','=',$data['questiontype']);
        }

        if(strlen ($data['size'])<>0)  {

            $freequestions=$freequestions->where('size','<=',$data['size']);
        }


        return $freequestions;
    }




    protected  function getpurchasedquestions ( $data , $user ){

        // purchased exercises based Grade id
        if (strlen ($data['grade_id']) <> 0)
        {
            if (strlen ($data['discipline_id']) == 0)   $grade_exsrcieset = $user->exercises->where('grade_id', '=', $data['grade_id']);
            if (strlen ($data['discipline_id']) <> 0)   $grade_exsrcieset = $user->exercises->where('grade_id', '=', $data['grade_id'])->where('discipline_id', '=', $data['discipline_id']);
        }
        else {
            // if no grade id get all from purchased
            if (strlen ($data['discipline_id']) == 0) $grade_exsrcieset = $user->exercises;
            if (strlen ($data['discipline_id']) <> 0) $grade_exsrcieset = $user->exercises->where('discipline_id', '=', $data['discipline_id']);;
        }


        if (strlen ($data['discipline_id']) <> 0)
        {
            if (strlen ($data['grade_id']) == 0)  $discipline_exercises = $user->exercises->where('discipline_id', '=', $data['discipline_id']);
            if (strlen ($data['grade_id']) <> 0)  $discipline_exercises = $user->exercises->where('discipline_id', '=', $data['discipline_id'])->where('grade_id', '=', $data['grade_id']);
        }
        else {
            // will use the discipline interest if not passed by parameter .
            $user_disciplines=$user->disciplines;
            $discipline_exercises =new  Collection;
            foreach($user_disciplines as $user_discipline) {
                if (strlen ($data['grade_id']) == 0)  $discipline_exercise=$user->exercises->where('discipline_id', '=',$user_discipline->discipline_id);
                if (strlen ($data['grade_id']) <> 0)  $discipline_exercise=$user->exercises->where('discipline_id', '=',$user_discipline->discipline_id)->where('grade_id', '=', $data['grade_id']);
                $discipline_exercises=$discipline_exercises ->merge($discipline_exercise);
            }
        }


        $purschedexsrcieset=$discipline_exercises->merge($grade_exsrcieset);
        $purschedexsrcieset = $purschedexsrcieset->unique();

        if(strlen ($data['language_id'])<>0) $purschedexsrcieset=$purschedexsrcieset->where ('language_id' ,'=',$data['language_id']);
        $bquestions =new Collection;
        foreach($purschedexsrcieset as $exercise) {
            $bquestion=$exercise->question;
            $bquestions=  $bquestions->merge($bquestion);
        }

        $bquestions = $bquestions->unique();
        $bquestions=$bquestions->where('maxtime','<=',$data['maxtime']);

        if(strlen ($data['questiontype'])<>0)  {

            $bquestions=$bquestions->where('questiontype','=',$data['questiontype']);
        }
        if(strlen ($data['size'])<>0)  {

            $bquestions=$bquestions->where('size','<=',$data['size']);
        }



        return $bquestions;

    }

    public function reportquestion() {
        $data = array();
        $datamail = array();
        $data['remember_token'] = Input::get ('remember_token');
        $data['question_id'] = Input::get ('question_id');
        $data['reporttext'] = Input::get ('reporttext');

        $validator = $this->questionvalidator1 ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
            //   return $responce;
        }

        $user = User::select('id','name','email')->where ('remember_token', '=', $data['remember_token'])->first ();
        if ($user){
            $question = Question::findOrFail($data['question_id']);
            $email = $question->exercise->owner->email;
            $email = "hass74@gmail.com";
            \Illuminate\Support\Facades\Mail::to($email)->send(new ReportQuestionMail($user, $question, $data['reporttext']));
            Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $email );
            Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');

            $datamail['to']=$email;

            $responce=$this->renderresponse($datamail,"Email sent successfully" );
            return json_encode($responce);
        }
    }

    private function renderquestion($details , $filename ,$id) {


        //  $data['id'] = Input::get ('id');
        // $question=Question::findorfail( $data['id']);
        $client = new GuzzleHttp\Client();
        $details=" <html><body>".$details."</body></html>";

        //   $url="http://localhost:8000/questions/api/". $data['id'];
        //  $url="http://localhost:8000/questions/api/". $data['id'];
        //   $url=route('questions.question.api_question',[ $data['id'],  $htmldata ]);
        $url="http://eduplaycloud.net/api_question/".$id;
        $res = $client->post('http://127.0.0.1:1337/question',[
            'form_params' => [
                'details' => $details,
                'test'=>'value123',
                'url'=>$url,
                'imageid'=>public_path('assets/images/output/'.$filename),
                'width'=>'200',

            ] ]);
        //  echo $res->getStatusCode(); // 200
        //  echo  ($res->getBody());
        //     $imagename=$data['id'].'.jpg';
        //   $path = storage_path('app\output\\' .  $data['id'].'.jpg');
        ///app/output/

        return 1;
        return view('questions.image' ,compact ('imagename') );



    }

    private function renderanswer($details , $filename ,$id) {


        //  $data['id'] = Input::get ('id');
        // $question=Question::findorfail( $data['id']);
        $client = new GuzzleHttp\Client();
        $details=" <html><body>".$details."</body></html>";

        //   $url="http://localhost:8000/questions/api/". $data['id'];
        //  $url="http://localhost:8000/questions/api/". $data['id'];
        //   $url=route('questions.question.api_question',[ $data['id'],  $htmldata ]);
        $url="http://eduplaycloud.net/api_answer/".$id;
        $res = $client->post('http://127.0.0.1:1337/question',[
            'form_params' => [
                'details' => $details,
                'test'=>'value123',
                'url'=>$url,
                'imageid'=>public_path('assets/images/output/'.$filename),
                'width'=>'200',

            ] ]);
        //  echo $res->getStatusCode(); // 200
        //  echo  ($res->getBody());
        //     $imagename=$data['id'].'.jpg';
        //   $path = storage_path('app\output\\' .  $data['id'].'.jpg');
        ///app/output/

        return 1;
        return view('questions.image' ,compact ('imagename') );



    }

    public function renderquestion1() {


        $data['id'] = Input::get ('id');
        $client = new GuzzleHttp\Client();

        $url="http://localhost:8000/questions/api/". $data['id'];
        //  $url="http://localhost:8000/questions/api/". $data['id'];
        //   $url=route('questions.question.api_question',[ $data['id'],  $htmldata ]);

        $res = $client->post('http://127.0.0.1:1337/question',[
            'form_params' => [
                // 'details' => $details,
                'test'=>'value123',
                'url'=>$url,
                'imageid'=> 'test123.jpg',
                'width'=>'200',

            ] ]);
        //  echo $res->getStatusCode(); // 200
        //  echo  ($res->getBody());
        //     $imagename=$data['id'].'.jpg';
        //   $path = storage_path('app\output\\' .  $data['id'].'.jpg');
        ///app/output/

        return 1;
        return view('questions.image' ,compact ('imagename') );



    }



    protected function questionvalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'discipline_id'=>'nullable|exists:disciplines,id',
                'maxtime'=>'nullable|numeric|min:1|max:5000',
                'questiontype'=> 'nullable|in:text,image,audio,video,richtext',
                'grade_id'=>'nullable|numeric|exists:grades,id',
                'nubofquestions'=>'nullable|numeric|min:1|max:200',
                'language_id' => 'nullable|exists:languages,id',
                'size'=>'nullable|numeric|min:1|max:5000',
                'question_id'=>'nullable|numeric|min:1',
                'reporttext'=>'nullable',

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
