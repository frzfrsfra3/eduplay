<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace app\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



use Log;
use Illuminate\Support\Facades\Storage;


class APIGrades extends Controller
{

    public function getallgrades() {

        $grades=Grade::select('id', 'grade_name')->get();

        if ($grades->count()==0) {

            $messages = "101: Grade  table is empty";
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);


         }
        $responce = $this->renderresponse ($grades, "Success list of grades");
        return json_encode ($responce);

    //   return json_encode($grades);
    }

    public function getgrade() {


        $data = array();
        $data['grade_id'] = Input::get ('grade_id');
        $validator = $this->gradevalidator1 ($data);
        if ($validator->fails ()) {


            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }

        $grade=Grade::select('id', 'grade_name')->findorfail( $data['grade_id']);

        if ($grade) {

            $responce = $this->renderresponse ($grade, "Success grade name");
            return json_encode ($responce);




        }




    }

    protected function gradevalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'grade_id' => 'required|exists:grades,id',

            ], $this->messagevalidation ()
        );


    }

    private function messagevalidation ()
    {

        return $messages = array(
            'grade_id.required' =>  '101: grade id is empty',
            'grade_id.exists' =>  '101: grade id is not existing',

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

    }

}

