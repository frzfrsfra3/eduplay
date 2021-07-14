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
use App\Models\Courseclass;
use App\Models\Exercisesetbuyer;
use App\Models\Exerciseset;
use App\Models\Question;
use App\Models\User;
use App\Models\Userinterest;
use Illuminate\Support\Collection;
use App\Models\Discipline;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp;
use File;
use Mustache_Engine;
use Response;
use Illuminate\Support\Facades\Route;

class APIExercises extends Controller





{

    public function getexersises  ()
    {


        $data = array();
        $data['language_id'] = Input::get ('language_id');
        $data['discipline_id'] = Input::get ('discipline_id');
        $data['grade_id'] = Input::get ('grade_id');
        $data['teachername'] = Input::get ('teachername');  //optional parameter
        $data['classname'] = Input::get ('classname');  //optional parameter

        $validator = $this->exersisevalidator1 ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);

        }
        if (strlen ($data['teachername']) == 0 && strlen ($data['classname']) == 0) {

            echo $this->getlist ($data, 1);

            return;
        }

        if (strlen ($data['teachername']) != 0 && strlen ($data['classname']) == 0) {
            $teacher = User::where ('name', '=', $data['teachername'])->first ();
            if ($teacher) {
                $exersiseset = Exerciseset::where ('discipline_id', '=', $data['discipline_id'])->where ('grade_id', '=', $data['grade_id'])
                    ->where ('language_id', '=', $data['language_id'])->where ('price', '=', 0)->where ('publish_status', '=', 'public')->where ('createdby', '=', $teacher->id)
                    ->get ();

                if ($exersiseset->count () == 0) {
                    echo $this->getlist ($data, 2);

                    return;


                } else {

                    foreach ($exersiseset as $exersise) {
                        $this->addteachername ($exersise);
                    }
                    $this->addteachername($exersiseset);
                    $responce = $this->renderresponse ($exersiseset, "Success list of exercises ");

                    return json_encode ($responce);

                }

            } else {
                echo $this->getlist ($data, 3);

                return;

            }


        }

        if (strlen ($data['teachername']) == 0 && strlen ($data['classname']) != 0) {

            $class = Courseclass::where ('class_name', '=', $data['classname'])->first ();

            if ($class) {
                $exersiseset = $class->exercises ()->get ();
                $exersiseset = $exersiseset->where ('discipline_id', '=', $data['discipline_id'])->where ('grade_id', '=', $data['grade_id'])
                    ->where ('language_id', '=', $data['language_id'])->where ('price', '=', 0);


                foreach ($exersiseset as $exersise) {
                    $this->addteachername ($exersise);
                }

                $responce = $this->renderresponse ($exersiseset, "Success list of exercises ");
                return json_encode ($responce);
            } else {
                echo $this->getlist ($data, 4);

                return;
            }

        }

        if (strlen ($data['teachername']) != 0 && strlen ($data['classname']) != 0) {

            $class = Courseclass::where ('class_name', '=', $data['classname'])->first ();

            if ($class) {

                $exersiseset = $class->exercises ()->get ();
                $exersiseset = $exersiseset->where ('discipline_id', '=', $data['discipline_id'])->where ('grade_id', '=', $data['grade_id'])
                    ->where ('language_id', '=', $data['language_id'])->where ('price', '=', 0);

                $teacher = User::where ('name', '=', $data['teachername'])->first ();

                if ($teacher) {
                    $exersiseset = $exersiseset->where ('createdby', '=', $teacher->id);


                    if ($exersiseset->count()<>0) {
                        foreach ($exersiseset as $exersise) {
                            $this->addteachername ($exersise);
                        }
                    $responce = $this->renderresponse ($exersiseset, "Success list of exercises ");
                    return json_encode ($responce);
                    }
                }
                    else {
                        if ($exersiseset->count()<>0) {
                            foreach ($exersiseset as $exersise) {
                                $this->addteachername ($exersise);
                            }
                            $responce = $this->renderresponse_partofselection ($exersiseset, "Teacher name not found ,   list of exercises for the class : ".$class->class_name);
                            return json_encode ($responce);
                        }
                        else {
                        echo $this->getlist ($data, 5);

                        return;

                    }
                }
                } else {
                    echo $this->getlist ($data, 4);

                    return;
                }

            }


    }




    private function addteachername(Exerciseset $exersise ){

        $userid=$exersise->createdby;
        $user=User::where('id' , '=' ,$userid)->first();
        $exersise['teachername']=$user->name;

      return;

    }

    private function getlist ($data , $type ) {

        $exersiseset=Exerciseset::where('discipline_id' , '=' ,  $data['discipline_id'])->where('grade_id','=', $data['grade_id'] )
            ->where('language_id' , '=' ,$data['language_id'])->where('price' ,  '=' ,0) ->where ('publish_status','=' ,'public')
           ->get();

        if ($exersiseset->count()==0) {
            $messages = '101, no exercises for your selection';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }
        else
        {

            foreach ($exersiseset as $exersise) {
                $this->addteachername($exersise);
            }
            if ($type==1) {
                $responce = $this->renderresponse ($exersiseset ,"Success list of exercises");
            }
            elseif ($type==2) {
                $responce = $this->renderresponse_partofselection ($exersiseset ,"Teacher name not found ,  proposed exercises :");

            }
            elseif ($type==3) {
                $responce = $this->renderresponse_partofselection ($exersiseset ,"Teacher name not found ,   proposed exercises : ");

            }

            elseif ($type==4) {
                $responce = $this->renderresponse_partofselection ($exersiseset ,"Class name not found ,  proposed exercises :");

            }

            elseif ($type==5) {
                $responce = $this->renderresponse_partofselection ($exersiseset ,"Teacher or Class name name not found ,   proposed exercises : ");

            }

            return json_encode( $responce);

        }
    }



    protected function exersisevalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'discipline_id'=>'required|exists:disciplines,id',
                'grade_id'=>'required|numeric|exists:grades,id',
                'language_id' => 'required|exists:languages,id',
                'teachername'=>'nullable|string|min:1|max:500',
                'classname'=>'nullable|string|min:1|max:500',




            ], $this->messagevalidation ()
        );


    }

    private function messagevalidation ()
    {

        return $messages = array(
            'discipline_id.required' => '101:Empty discipline id.',
            'discipline_id.exists' =>'101: Discipline not exist',
            'grade_id.required' => '101:Empty grade id.',
            'grade_id.exists' =>  '101: grade id is not existing',
            'language_id.required' => '101:Empty language id.',
            'language_id.exists' =>  '101: language id is not existing',
            'teachername.max'=>'101:the teacher name passed 500 characters ',
            'classname.max'=>'101:the class name passed 500 characters ',


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

    private function renderresponse_partofselection($data , $message)

    {
        $response=array();
        $response['status']="102";
        $response['message']= $message ;
        $response['data']=$data;
        return $response;

    }
}
