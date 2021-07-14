<?php

namespace App\Http\Traits;

use App\Models\Badge;
use App\Models\Useractivitylog;
use App\Models\Userbadge;
use App\Models\Xp_point;
use App\Models\User;
use Auth;
use DB;
use App\Models\Activity;

trait AddXppoint
{
    /**
     * Undocumented function
     *
     * param [type] $user_id
     * param [type] $action
     * return void
     */
    public function add_xp_point($user_id, $action,$role=null)
    {
        //dd($user_id, $action,$role);
        $role = $this->getRole($role);

        // Action remove space & strlower
        $sp  = str_replace(' ','',$action);
        $action = strtolower($sp);

        // replace query due to remove db:field space.
        $xp_point = Xp_point::where(\DB::raw("REPLACE(activity_name, ' ', '')"), '=', $action)->first();

        $activitys=Activity::where(\DB::raw("REPLACE(activity_description, ' ', '')"),'=',$action)
        ->where('role_type','=',$role)
        ->first();

        //dd($xp_point,$activitys);
        if (!empty($activitys)) {
            if ($xp_point) {
                $accumulated_points = 0;
                $last_xp_point_by_user = Useractivitylog::where('user_id', '=', $user_id)->orderBy('id', 'desc')->first();
                if ($last_xp_point_by_user) {
                    $accumulated_points=$last_xp_point_by_user->accumulated_points;
                }

                $activity_id = $activitys->id;

                $accumulated_points = $accumulated_points+ $xp_point->point;
                $new_user_activity = new Useractivitylog;
                $new_user_activity->activity_id = $activity_id;
                $new_user_activity->user_id = $user_id;
                $new_user_activity->points = $xp_point->point;
                $new_user_activity->accumulated_points = $accumulated_points;
                $new_user_activity->details = $action;
                $new_user_activity->save();

                // Activity Count
                $countActivity=Useractivitylog::where('activity_id',$activity_id)->where('user_id', '=', $user_id)->count();
                //dd($countActivity);

                $this->setbadge($user_id,$accumulated_points,$countActivity,$activity_id);

                // For update total user points.
                $Userpoint = User::where('id', '=', $user_id)->first();
                $Userpoint->update(['totalpoints' => $new_user_activity->accumulated_points]);
            }
        }
        else{
            return;
        }
    }

    /**
     * Undocumented function
     *
     * param [type] $user_id
     * param [type] $points
     * return void
     */
    private function setbadge($user_id, $points,$countActivity,$activity_id)
    {
        //dd($user_id, $points,$countActivity,$activity_id);
        $role = $this->getRole();
        $activitys=Activity::where('id',$activity_id)->where('role_type',$role)->where('activity_category','=','creation')->first();

        $badges = Badge::where(function($q) use($points){
            $q->where('badge_type','=','point');
            $q->where(function($q1) use($points){
                $q1->where('points', '<=', $points);
                //$q1->orWhere('points','!=',0);
            });
        })
        ->orWhere(function($q){
            $q->orWhere('badge_type','=','activity');
        })
        ->get();

        // if Activity is no null
        if(!empty($activitys)){
            if ($badges->count() > 0) {
                $activityId = $activitys->id;

                foreach ($badges as $badge) {
                    //dd($user_id,$badge->id,$activityId);
                    $userbadge = Userbadge::where('user_id' , '=', $user_id)
                    ->where('badge_id', '=', $badge->id)
                    ->where(function($query) use($activityId){
                        $query->where('activity_id', '=', $activityId);
                        $query->orWhereNull('activity_id');
                    })
                    ->first();
                        if (!$userbadge) {
                            $userbadge = new Userbadge;
                        } else{
                            $userbadge = Userbadge::find($userbadge->id);
                        }
                        $userbadge->user_id = $user_id;
                        $userbadge->badge_id = $badge->id;
                        $userbadge->badgetitle = $badge->badgetitle;
                        $userbadge->points = $badge->points;
                        //$userbadge->type = 'activity';
                        if($badge->badge_type == 'activity'){
                            $userbadge->type = 'activity';
                            $userbadge->activity_id = $activitys->id;
                            $userbadge->badgedescription = 'You have perform "'.$activitys->activity_description.'" activity "'.$countActivity.'" times';
                        } else {
                            $userbadge->type = 'point';
                            $userbadge->badgedescription = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
                        }
                        $userbadge->save();
                    //}
                }
            }
        }
        return;
    }
    // Set Role Preority
    private function getRole($role = null){
        if(Auth::check()){
            if($role == null){
                if (Auth::user()->hasRole('Teacher') > 0) {
                    $role = "Teacher";
                }elseif (Auth::user()->hasRole('Learner') > 0) {
                    $role = "Learner";
                }else{
                    $role = Auth::user()->roles()->first()->name;
                }
                return $role;
            } else {
                return $role;
            }
        } else {
            return $role;
        }
    }
}
