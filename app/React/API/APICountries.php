<?php

namespace app\React\API;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class APICountries extends Controller
{

    /**
     * Display a listing of the countries.
     *
     * return Illuminate\View\View
     */
    public function getallcountries()
    {
        $countries = Country::get();

        $countries=Country::select('id', 'country_name', 'abbreviation_code')->get();

        if ($countries->count()==0) {

            $messages= "101: Country  table is empty";
            $responce = $this->rendererrorresponse($messages);
            return  json_encode ($responce);

        }

        $responce = $this->renderresponse ($countries, "Success List of Countries ");
        return json_encode ($responce);



    }


    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'country_name' => 'required|string|min:1|max:100',
            'abbreviation_code' => 'nullable|string|min:0|max:50',
            'country_flag' => 'nullable|string|min:0|max:100',

        ];


        $data = $request->validate($rules);




        return $data;
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
