<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use Log;
use Illuminate\Support\Facades\Storage;


class APILanguage extends Controller
{

    public function getlanguages ()
    {

        $languages = Language::select ('id', 'language')->get ();

        if ($languages->count () == 0) {
            $messages = "101: Languages  table is empty";
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);

        }

        $responce = $this->renderresponse ($languages, "Success list of languages ");
        return json_encode ($responce);

        //  return json_encode($languages);


    }

    public function getlanguage ()
    {


        $data = array();
        $data['language_id'] = Input::get ('language_id');
        $validator = $this->languagevalidator1 ($data);
        if ($validator->fails ()) {


            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);

        }

        $language = Language::select ('id', 'language')->findorfail ($data['language_id']);

        if ($language) {

            $responce = $this->renderresponse ($language, "Success language Data ");
            return json_encode ($responce);


        }
    }

    protected function languagevalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'language_id' => 'required|exists:languages,id',

            ], $this->messagevalidation ()
        );


    }

    private function messagevalidation ()
    {

        return $messages = array(
            'language_id.required' => '101: language id is empty',
            'language_id.exists' => '101: language id is not existing',

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

    }


}

