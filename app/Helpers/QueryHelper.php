<?php

namespace App\Helpers;

use Auth;
use App\Models\Useractivitylog;
use App\Models\UserSkillmasterylevel;
use App\Models\Userexamanswer;

class QueryHelper
{
    /**
     * Recent activities
     *
     * param int $id
     * return object
     */
    static function recentActivities($userId)
    {
        return Useractivitylog::where('user_id', $userId)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->orderBy('created_at', 'desc')
            //->whereNotIn('activity_id', [7, 8, 9, 10])
            ->take(6)
            ->get();
    }

    /**
     * Get user notifications
     *
     * param int $id
     * return object
     */
    static function userNotifications($take)
    {
        return Auth::user()->load(['userNotifications' => function($query) use ($take) {
            $query->take($take)->orderBy('id', 'DESC');
        }])->toArray();
    }

    /**
     * Get user days activities counts
     *
     * param int $userId
     * param int $date
     * return array
     */
    static function userDaysActivities($userId, $date)
    {
        return Useractivitylog::selectRaw('id, DATE(created_at) AS created_at, activity_id')
            ->where("created_at", "LIKE", '%'.$date.'%')
            ->where('user_id', $userId)
            //->whereNotIn('activity_id', [7, 8, 9, 10])
            ->count();
    }

    /**
     * Get user skill masterylevel
     *
     * param int $userId
     * param int $date
     * return array
     */
    static function userSkillMasterylevel($userId,$skillId,$classExamId)
    {
        $masteryLevel=UserSkillmasterylevel::where('user_id',$userId)->where('skill_id',$skillId);
        if(!empty($classExamId)){
            $masteryLevel->where('classexam_id',$classExamId);
        }
        $masteryLevel->with(['Skillmasterylevel' => function($query){
            $query->select('id','levelname');
        },]);
        return $masteryLevel->first();
    }

    /**
     * Get user skill masterylevel
     *
     * param int $userId
     * param int $date
     * return array
     */
    static function allSkillMasterylevel($skillId,$classExamId)
    {
        return $masteryLevel=UserSkillmasterylevel::where('skill_id',$skillId)
        ->where('classexam_id',$classExamId)
        ->get();
        //->toArray();
    }

    /**
     * Get user examanswer
     *
     * param int $userId
     * param int $date
     * return array
     */
    static function UserNameExamAnswer($questionId,$answerId,$uId)
    {
        return $masteryLevel=Userexamanswer::where('question_id',$questionId)
        ->where('answer_id',$answerId)
        ->where('user_id',$uId)
        ->first();
        //->toArray();
    }
    /**
     * Get answer percentage ( Exercises set report )
     *
     * param int $userId
     * param int $date
     * return array
     */
    static function getAnswerPercentage($questionId,$answerId,$exam_id=null)
    {
        $masteryLevel=Userexamanswer::where('question_id',$questionId);
        $masteryLevel->where('answer_id',$answerId);
        if($exam_id != null){
            $masteryLevel->where('exam_id',$exam_id);
            return $masteryLevel->orderby('desc')->distinct('id')->count('id');
        }else{
            return $masteryLevel->orderby('desc')->distinct('question_id')->count('question_id');
        }
        //return $masteryLevel->orderby('desc')->distinct('id')->count('id');
        //->toArray();
    }
}