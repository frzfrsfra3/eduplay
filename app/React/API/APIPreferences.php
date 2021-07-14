<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\React\API;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\User;
//use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Models\Role_user;



use Log;
use Illuminate\Support\Facades\Storage;


class APIPreferences extends Controller
{


    public function setuserrole(){

        try{

        $today = date ("Ymd");
        $logsfile = "api.setuserrole" . $today . ".txt";
        $data = array();
        $request = Request::capture ();
        $data['remember_token'] = Input::get ('user_token');
        $data['role_id'] = Input::get ('role_id');


        Storage::disk ('local')->append ($logsfile, $request);
        Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

        $validator = $this->uservalidator1 ($data);
        if ($validator->fails ()) {



            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);

            Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $responce));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

            return  json_encode( $responce);
        }

          $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        if (!$user->roles ->contains($data['role_id'])) {
            $user->roles ()->attach ( $data['role_id']);
        }

        $user_role=array();
        $user_roles=array();

      $roles=  $user->roles()->get();
       foreach ($roles as $role){
           $user_role['user_id']=$user->id;
           $user_role['role_id']=$role->id;
           $user_role['role_name']=$role->name;
           $user_roles[]=$user_role;
       }

        Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $user_roles));
        Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

            $responce=$this->renderresponse($user_roles ,"Success  Role well added , list of user role  Data" );
            return json_encode($responce);


        } catch (Exception $exception) {

            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }
        }


    public function unsetuserrole(){

        try{

        $today = date ("Ymd");
        $logsfile = "api.unsetuserrole" . $today . ".txt";
        $data = array();
        $request = Request::capture ();
        $data['remember_token'] = Input::get ('user_token');
        $data['role_id'] = Input::get ('role_id');


        Storage::disk ('local')->append ($logsfile, $request);
        Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

        $validator = $this->uservalidator1 ($data);
        if ($validator->fails ()) {


            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);

            Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ( $responce));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
         //   $responce = str_replace ("\r\n", "<br>", $responce);
            return json_encode($responce);
        }

        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        if ($user->roles ->contains($data['role_id'])) {
            $user->roles ()->detach ( $data['role_id']);
        }


        if($user->roles()->count()==0)  $user->roles ()->attach ( 1) ;
        $user_role=array();
        $user_roles=array();

        $roles=  $user->roles()->get();
        foreach ($roles as $role){
            $user_role['user_id']=$user->id;
            $user_role['role_id']=$role->id;
            $user_role['role_name']=$role->name;
            $user_roles[]=$user_role;
        }

        Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $user_roles));
        Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

            $responce=$this->renderresponse($user_roles ,"Success  Role well Removed , list of user role  Data" );
            return json_encode($responce);


        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }
        }



    public function setuserpreferences(){

        try{

        $today = date ("Ymd");
        $logsfile = "api.setuserpreferences" . $today . ".txt";
        $data = array();
        $request = Request::capture ();
        $data['remember_token'] = Input::get ('user_token');
        $data['grade_id'] = Input::get ('grade_id');
        $data['school_id'] = Input::get ('school_id');
        $data['uilanguage_id'] = Input::get ('uilanguage_id');



        Storage::disk ('local')->append ($logsfile, $request);
        Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

        $validator = $this->preferencesvalidator ($data);
        if ($validator->fails ()) {
            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);



            Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ( $responce));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
            $responce = str_replace ("\r\n", "<br>", $responce);
            return json_encode( $responce);
        }

        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
            if  (strlen ( $data['grade_id']) <>0 )      $user->grade_id = $data['grade_id'];
            if  (strlen ( $data['school_id']) <>0 )     $user->school_id = $data['school_id'];
            if  (strlen ( $data['uilanguage_id']) <>0 ) $user->uilanguage_id = $data['uilanguage_id'];
        $user->save();
        $user=User::select('id','grade_id','school_id','uilanguage_id')
            ->findorfail($user->id);


        Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $user));
        Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

            $responce = $this->renderresponse ($user, "Successfully preference added ,   User   preferences Data ");
            return json_encode ($responce);

    //    return json_encode(  $user );

        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);
        }
        }



    public function unsetuserpreferences(){

        try{

            $today = date ("Ymd");
            $logsfile = "api.setuserpreferences" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['remember_token'] = Input::get ('user_token');
            $data['preference'] = Input::get ('preference');


            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

            $validator = $this->unsetpreferencesvalidator ($data);
            if ($validator->fails ()) {



                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse($messages);
                Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ( $responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                $responce = str_replace ("\r\n", "<br>", $responce);
                return  json_encode ($responce);
            }

            $user = User::select('id','grade_id','school_id','uilanguage_id')->where ('remember_token', '=', $data['remember_token'])->first ();
            if( $data['preference'] =='grade_id' )   $user->grade_id = null;
            if( $data['preference'] =='school_id' )  $user->school_id =null;
            if( $data['preference'] =='uilanguage_id' ) $user->uilanguage_id = null;
            $user->save();
           $user=User::select('id','grade_id','school_id','uilanguage_id')
              ->findorfail($user->id);


            Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $user));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
            $responce = $this->renderresponse ($user, "Successfully preference removed ,  User   preferences Data");
            return json_encode ($responce);

           // return json_encode(  $user );

        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }
    }


    public function getuserpreferences(){

        try{

            $today = date ("Ymd");
            $logsfile = "api.getuserpreferences" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['remember_token'] = Input::get ('user_token');

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

            $validator = $this->preferencesvalidator ($data);
            if ($validator->fails ()) {


                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse($messages);
                Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                $responce = str_replace ("\r\n", "<br>", $responce);
                return json_encode ($responce);
            }

            $user = User::select('id','grade_id','school_id','uilanguage_id')->where ('remember_token', '=', $data['remember_token'])->first ();

            Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $user));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
            $responce = $this->renderresponse ($user, "Success  User   preferences Data ");
            return json_encode ($responce);
           // return json_encode(  $user );

        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }
    }

    public function getuserinfo(){

        try{

            $today = date ("Ymd");
            $logsfile = "api.getuserpreferences" . $today . ".txt";
            $data = array();
            $request = Request::capture ();
            $data['remember_token'] = Input::get ('user_token');

            Storage::disk ('local')->append ($logsfile, $request);
            Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

            $validator = $this->preferencesvalidator ($data);
            if ($validator->fails ()) {



                $messages = $validator->errors ()->first ();
                $responce = $this->rendererrorresponse($messages);
                Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $responce));
                Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
                $responce = str_replace ("\r\n", "<br>", $responce);
                return json_encode ($responce);
            }

            $user = User::select('id','grade_id','school_id','uilanguage_id' , 'name' , 'email' ,'gender' ,'dob','country_id' )->where ('remember_token', '=', $data['remember_token'])->first ();

            Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $user));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');
            $responce = $this->renderresponse ($user, "Success User preferences Data ");
            return json_encode ($responce);


        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }
    }



    public function getuserrole(){
        try{

        $today = date ("Ymd");
        $logsfile = "api.getuserrole" . $today . ".txt";
        $data = array();
        $request = Request::capture ();
        $data['remember_token'] = Input::get ('user_token');


        Storage::disk ('local')->append ($logsfile, $request);
        Storage::disk ('local')->append ($logsfile, 'Ip:' . $request->ip ());

        $validator = $this->getuservalidator1 ($data);
        if ($validator->fails ()) {



            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse($messages);

            Storage::disk ('local')->append ($logsfile, "responce:\r\n" . json_encode ($responce));
            Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

            return json_encode ($responce);
        }

        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        $user_role=array();
        $user_roles=array();

        $roles=  $user->roles()->get();
        foreach ($roles as $role){
            $user_role['user_id']=$user->id;
            $user_role['role_id']=$role->id;
            $user_role['role_name']=$role->name;
            $user_roles[]=$user_role;
        }

        Storage::disk ('local')->append ($logsfile, "responce:\r\n" .json_encode( $user_roles));
        Storage::disk ('local')->append ($logsfile, '------------------------------------------------------------------------------------------------------------------------------------');

            $responce=$this->renderresponse($user_roles ,"Success list of user roles  Data" );
            return json_encode($responce);


        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }

    }






    protected function uservalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'role_id'=> 'required|in:1,2,3',

            ], $this->messagevalidation ()
        );


    }


    protected function getuservalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',


            ], $this->messagevalidation ()
        );


    }



    protected function preferencesvalidator (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'grade_id'=> 'nullable|exists:grades,id|numeric',
                'school_id'=> 'nullable|exists:schools,id|numeric',
                'uilanguage_id'=> 'nullable|exists:languages,id|numeric',


            ], $this->messagevalidation ()
        );


    }

    protected function unsetpreferencesvalidator (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'preference'=> 'required|in:grade_id,school_id,uilanguage_id|string',

            ], $this->messagevalidation ()
        );


    }



    private function messagevalidation ()
    {

        return $messages = array(

            'grade_id.required' =>  '101: grade id is empty',
            'role_id.required'=>'101: role is empty',
            'role_id.in'=>'101: role id must a value of 1 ,2  or 3',
            'grade_id.exists' =>  '101: grade id is not existing',
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' =>'101: user not exist',
            'school_id.required' =>  '101: school  id is empty',
            'school_id.exists' =>  '101: school id is not existing',
            'uilanguage_id.required' =>  '101: uilanguage id is empty',
            'uilanguage_id.exists' =>  '101: language id is not existing',
            'grade_id.numeric' =>'101:The grade id must be a number.',
            'school_id.numeric' =>'101:The school id must be a number.',
            'uilanguage_id.numeric' =>'101:The uilanguage  id must be a number.',
            'preference.required' => '101:Empty preference parameter.',
            'preference.in' =>'101:preference must be :grade_id ,school_id or uilanguage_id',
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