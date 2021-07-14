<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\React\API;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



use Log;
use Illuminate\Support\Facades\Storage;


class APISchool extends Controller
{

    public function getallschools() {

        $schools=School::select('id', 'school_name')->get();

        if ($schools->count()==0) {

            $messages= "101: School  table is empty";
           $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }

        $responce = $this->renderresponse ($schools, "Success List of schools ");
        return json_encode ($responce);



    }

    public function getschool() {


        $data = array();
        $data['school_id'] = Input::get ('school_id');
        $validator = $this->schoolvalidator1 ($data);
        if ($validator->fails ()) {


            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }

        $school=School::select('id', 'school_name')->findorfail( $data['school_id']);

        if ($school) {

            $responce = $this->renderresponse ($school, "Success School data ");
            return json_encode ($responce);

        }

    }

    protected function schoolvalidator1 (array $data)
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

