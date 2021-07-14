<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 3/14/2018
 * Time: 9:36 AM
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Skillcategory;
use App\Models\User;
use App\Models\Userexamscore;
use App\Models\UserSkillmasterylevel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class APIUserReports extends Controller
{

    public function getuserscore()
    {

        if (Input::get('game_id') == null) {
            $gameID = 1;
        } else {
            $gameID = Input::get('game_id');
        }

        $userToken = Input::get('user_token');

        $user = User::where('remember_token', '=', $userToken)->first();

        $userScores = Userexamscore::select('topic_id', DB::raw('sum(score) as score'), 'created_at')->where('user_id', $user->id)->where('game_id', $gameID)->where('topic_id', '!=', null)->groupBy('topic_id')->get();

        $i = 0;

        $data = [];
        foreach ($userScores as $userScore) {
            $data[$i]['user_id'] = $user->id;
            $data[$i]['topic_id'] = $userScore->topic_id;
            $data[$i]['topic_name'] = $userScore->topics['topic_name'];
            // Calculate Percentage of highest score
            $highestScore = Userexamscore::getHighestScoreInTopicAndGame($userScore->topic_id, $gameID);
            $currentScore = $userScore->score;
            $percentage = $currentScore * 100 / $highestScore;
            $data[$i]['highest_score'] = $highestScore;
            $data[$i]['current_score'] = $currentScore;
            $data[$i]['score'] = intval($percentage);
            $data[$i]['created_at'] = $userScore->created_at;
            $i++;
        }

        $responce = $this->renderresponse($data, "User Scores Returned Successfully");

        return json_encode($responce);

    }

    public function usermasterydetails()
    {

        try {
            $data = array();
            $userscore = array();
            $highscore = array();
            $allskillmasterylevel = array();

            $data['remember_token'] = Input::get('user_token');
            $data['topic_id'] = Input::get('topic_id');
            $validator = $this->userskillvalidator1($data);

            if ($validator->fails()) {

                $messages = $validator->errors()->first();
                $responce = $this->rendererrorresponse($messages);
                return json_encode($responce);
            }
            $user = User::where('remember_token', '=', $data['remember_token'])->first();

            $sub = UserSkillmasterylevel::select('user_id', 'skill_id', DB::raw('max( created_at )  as max_date'))->groupBy('user_id')
                ->groupBy('skill_id');

            $mastrylevel = UserSkillmasterylevel::join(DB::raw("( {$sub->toSql()}  )  max_table "), function ($join) {
                $join->on('max_table.max_date', '=', 'userskillmasterylevels.created_at')
                    ->on('max_table.user_id', '=', 'userskillmasterylevels.user_id')
                    ->on('max_table.skill_id', '=', 'userskillmasterylevels.skill_id');

            })->where('userskillmasterylevels.user_id', '=', $user->id)->get();

            $i = 0;

            foreach ($mastrylevel as $userskillmasterylevel) {
                if ($userskillmasterylevel->skill->skillcategory->discipline->topic_id == $data['topic_id']) {
                    if (is_null($userskillmasterylevel->Skillmasterylevel)) {
                        $levelname = "";
                    } else {
                        $levelname = $userskillmasterylevel->Skillmasterylevel->levelname;
                    }
                    $allskillmasterylevel[$i]['user_id'] = $userskillmasterylevel->user_id;
                    $allskillmasterylevel[$i]['skill_id'] = $userskillmasterylevel->skill_id;
                    $allskillmasterylevel[$i]['skill_name'] = $userskillmasterylevel->skill->skill_name;
                    $allskillmasterylevel[$i]['topic_name'] = $userskillmasterylevel->skill->skillcategory->discipline->topics->topic_name;
                    $allskillmasterylevel[$i]['masteryLevel'] = $levelname;
                    $allskillmasterylevel[$i]['score'] = $userskillmasterylevel->score;
                    $allskillmasterylevel[$i]['created_at'] = $userskillmasterylevel->created_at;
                    $allskillmasterylevel[$i]['updated_at'] = $userskillmasterylevel->updated_at;
                    $i++;
                }
            }

            if ($allskillmasterylevel) {

                $responce = $this->renderresponse($allskillmasterylevel, "Success User Mastry Level ");
                return json_encode($responce);

            } else {
                $messages = "101: Not enough data to display";
                $responce = $this->rendererrorresponse($messages);
                return json_encode($responce);
            }
        } catch (Exception $exception) {
            $messages = '101: database error';
            $responce = $this->rendererrorresponse($messages);
            return json_encode($responce);
        }
    }

    protected function uservalidator1(array $data)
    {
        return Validator::make(
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',

            ], $this->messagevalidation()
        );

    }

    protected function userskillvalidator1(array $data)
    {
        return Validator::make(
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',
                'topic_id' => 'required|exists:topics,id|int',

            ], $this->messagevalidation()
        );

    }

    private function messagevalidation()
    {

        return $messages = array(
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' => '101: user not exist',
            'topic_id.required' => '101: topic id is empty',
            'game_id.exists' => '101: game id is not existing',
        );

    }

    private function rendererrorresponse($message)
    {
        $data = array();
        $errorid = substr($message, 0, 3);
        $errortext = substr($message, 4);
        $response = array();
        $response['status'] = $errorid;
        $response['message'] = $errortext;
        $response['data'] = $data;
        return $response;

    }

    private function renderresponse($data, $message)
    {
        $response = array();
        $response['status'] = "1";
        $response['message'] = $message;
        $response['data'] = $data;

        return $response;
        // a sample    {"status":"1","message":"SuccessfullyRegister ","usertoken":"546a456dfasdf6544"}
    }

}
