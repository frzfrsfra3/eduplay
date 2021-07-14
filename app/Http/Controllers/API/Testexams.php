<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\Setskillmasterylevels;
use App\Models\Question;
use App\Models\School;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



use Log;
use Illuminate\Support\Facades\Storage;


class Testexams extends Controller
{
    use Setskillmasterylevels;

    public function setmastry() {



            $today = date ("Ymd");
            $logsfile = "api.test_mastry" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['$user_id'] = Input::get ('user_id');
            $data['$classexam_id'] = Input::get ('classexam_id');
            $data['$question_id'] = Input::get ('question_id');


            $val=$this->setskillmasterylevels_for_exam (  $data['$user_id'] , $data['$classexam_id'] , $data['$question_id']);
            return $val;
//        return json_encode($schools);


    }

    public function setpraticemastry() {



        $today = date ("Ymd");
        $logsfile = "api.test_mastry_pratice" . $today . ".txt";
        $data = array();
        $request = Request::capture ();
        $data['$user_id'] = Input::get ('user_id');
       // $data['$classexam_id'] = Input::get ('classexam_id');
        $data['$question_id'] = Input::get ('question_id');


        $val=$this->setskillmasterylevels_for_practice (  $data['$user_id']  , $data['$question_id']);
        return $val;
//        return json_encode($schools);


    }

    public function updatequetion (){

        $quetion=Question::where('id','=',3)->first();
        if(isset($quetion)){
           $val=           ( '{ "Question": [ { "sectionType": "text", "value": "Which number is missing from this sequence?" }, { "sectionType": "plugin", "plugin": "katex", "value": "\n\n \\\oint_C x^3\\\, dx + 4y^2\\\, dy2 = \\\left(\n \\\frac{\\\left(3-x\\\right) \\\times 2}{3-x}\n \\\right) \n" }, { "sectionType": "text", "value": "" }, { "sectionType": "plugin", "plugin": "clock", "value": "{\"Hours\":12,\"Minutes\":5,\"Seconds\":15}" }, { "sectionType": "text", "value": "" }, { "sectionType": "plugin", "plugin": "music", "value": "X: 24" }, { "sectionType": "text", "value": "" } ], "Answers": [ { "Attributes": { "C": "1" }, "Content": [ { "sectionType": "text", "value": "Hello {{name}} from {{city}} You have just won {{b}} dollars !" } ] }, { "Attributes": {}, "Content": [ { "sectionType": "text", "value": "a = {{a}}" } ] }, { "Attributes": {}, "Content": [ { "sectionType": "text", "value": "c= {{c}}" } ] }, { "Attributes": {}, "Content": [ { "sectionType": "text", "value": "answer option 4" } ] } ], "Hint": [ { "sectionType": "text", "value": "here you type the hint for the answers of this exercise" } ] }' );
        $quetion->json_details=$val;
//echo  htmlspecialchars($val);

        $quetion->save();
        return $val; 
        }
        else{
             $messages = '101: Question id not found';
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);
        }
        


    }








    protected function validator (array $data)
    {
        return Validator::make (
            $data,
            [
                'school_id' => 'required|exists:schools,id',

            ], $this->messagevalidation ()
        );


    }

    private function messagevalidation ()
    {

        return $messages = array(
            'school_id.required' =>  '101: school id is empty',
            'school_id.exists' =>  '101: school id is not existing',

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

