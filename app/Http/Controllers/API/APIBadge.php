<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use File;
use Log;
use Illuminate\Support\Facades\Storage;


class APIBadge extends Controller
{
    //getallbadges, getuserbadges, getbadge
    //rendererrorresponse, renderresponse,
    // badgevalidator1, messagevalidation, uservalidator1

    /*
     *
     */
    public function getallbadges ()
    {
        $imagesurl = url ('/assets/images/badges/');
        $imagespath = public_path('/assets/images/badges');
        $badges = Badge::select ('id', 'badgetitle', 'badgedescription', 'badgeimageurl', 'points', 'badge_condition')->where ('isactive', '=', 1)->get ();

        if ($badges->count () == 0) {
            $messages = "101: Badges  table is empty";;
            $responce = $this->rendererrorresponse ($messages);

            return json_encode ($responce);
        }

        $badges = $badges->toArray ();

        foreach ($badges as &$badge) {
            if (strlen($badge['badgeimageurl']) > 0 && File::exists($imagespath . "/" . $badge['badgeimageurl'])) {
                $badge['badgeimageurl'] = $imagesurl . "/" . $badge['badgeimageurl'];
            }
            else {
                $badge['badgeimageurl'] = $imagesurl . "/default_badges.png" ;
            }
        }
        $responce = $this->renderresponse ($badges, "Success  All Badges Data");
        return json_encode ($responce);
    }

    /*
     *
     */
    public function getuserbadges ()
    {
        $imagesurl = url ('/assets/images/badges/');
        $imagespath = public_path('/assets/images/badges');
        $data = array();
        $data['remember_token'] = Input::get ('user_token');

        $validator = $this->uservalidator1 ($data);
        if ($validator->fails ()) {
            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);
        }
        $user = User::where ('remember_token', '=', $data['remember_token'])->first ();
        if ($user) {
            $badges = $user->badges ()->get ();
            $user_badge = array();
            $user_badges = array();

            foreach ($badges as $badge) {
                $user_badge['user_id'] = $user->id;
                $user_badge['badge_id'] = $badge->id;
                $user_badge['badgetitle'] = $badge->badgetitle;
                $user_badge['badgedescription'] = $badge->badgedescription;

              //  if (strlen ($badge->badgeimageurl) <> 0) $badge['badgeimageurl'] = $imagespath . "/" . $badge->badgeimageurl;

                if (strlen($badge->badgeimageurl) > 0 && File::exists($imagespath . "/" . $badge->badgeimageurl)) {
                    $badge['badgeimageurl'] = $imagesurl . "/" . $badge->badgeimageurl;
                }
                else {
                    $badge['badgeimageurl'] = $imagesurl . "/default_badges.png" ;
                }

                $user_badge['badgeimageurl'] = $badge->badgeimageurl;
                $user_badge['badgeorder'] = $badge->badgeorder;
                $user_badge['badge_condition'] = $badge->badge_condition;

                $user_badges[] = $user_badge;
            }

            if ($user_badge) {
                $responce = $this->renderresponse ($user_badges, "Success User Badges Data");

                return json_encode ($responce);
            } else {

                $messages = '1: This user have default badges';

                $defaultbadge=array();
                $defaultbadge['user_id']=$user->id;
                $defaultbadge['badge_id'] = 0;
                $defaultbadge['badgetitle'] ='Default Badges';
                $defaultbadge['badgedescription'] ='Default Badges';
                $defaultbadge['badgeimageurl']=$imagesurl . "/default_badges.png" ;
                $defaultbadge['badgeorder'] = 1;
                $defaultbadge['badge_condition'] = 'Default Badges';
                $defaultbadge=array($defaultbadge);
                $responce = $this->renderresponse ($defaultbadge,'This user have default badges');

                return json_encode ($responce);
            }
        }
    }

    /*
     *
     */
    public function getbadge ()
    {

        $imagesurl = url ('/assets/images/badges/');
        $imagespath = public_path('/assets/images/badges');
        $data = array();
        $data['badge_id'] = Input::get ('badge_id');
        $validator = $this->badgevalidator1 ($data);
        if ($validator->fails ()) {

            $messages = $validator->errors ()->first ();
            $responce = $this->rendererrorresponse ($messages);
            return json_encode ($responce);
        }

        $badge = Badge::select ('id', 'badgetitle', 'badgedescription', 'badgeimageurl', 'points', 'badge_condition')
            ->where ('isactive', '=', 1)->where ('id', '=', $data['badge_id'])->first ();

        if ($badge) {
            if (strlen($badge['badgeimageurl']) > 0 && File::exists($imagespath . "/" . $badge['badgeimageurl'])) {
                $badge['badgeimageurl'] = $imagesurl . "/" . $badge['badgeimageurl'];
            }
            else {
                $badge['badgeimageurl'] = $imagesurl . "/default_badges.png" ;
            }
            $responce = $this->renderresponse ($badge, "Success  Badge Data");
            return json_encode ($responce);
        }

        $messages = '101: Badge id is not exist';
        $responce = $this->rendererrorresponse ($messages);
        return json_encode ($responce);

    }

    /*
     *
     */
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

    /*
     *
     */
    private function renderresponse ($data, $message)
    {
        $response = array();
        $response['status'] = "1";
        $response['message'] = $message;
        $response['data'] = $data;

        return $response;
    }

    /*
     *
     */
    protected function badgevalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'badge_id' => 'required|exists:badges,id',

            ], $this->messagevalidation ()
        );
    }

    /*
     *
     */
    private function messagevalidation ()
    {

        return $messages = array(
            'remember_token.required' => '101:Empty remember_token.',
            'remember_token.exists' => '101: user not exist',
            'badge_id.required' => '101: badge id is empty',
            'badge_id.exists' => '101: badge id is not exist',

        );


    }

    /*
     *
     */
    protected function uservalidator1 (array $data)
    {
        return Validator::make (
            $data,
            [
                'remember_token' => 'required|exists:users,remember_token|string|max:500',

            ], $this->messagevalidation ()
        );


    }

}

