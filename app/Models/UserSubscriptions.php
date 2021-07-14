<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptions extends Model
{
    protected $table = 'usersubscriptions';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id', 'id');
    }

    public static $tempRoleId = null;
    public static function getByUserAndRole($user_id , $role_id){
        self::$tempRoleId = $role_id;
        $userSubscriptions = UserSubscriptions::with('plan')
        ->where('user_id' , $user_id)->whereHas('plan' , function($query){
            $query->where('role_id', '=', UserSubscriptions::$tempRoleId);
        })->get();

        return $userSubscriptions;
        
    }

    public function CheckStatus(){
        
        /*
            1: ( CURRENT_TIME < expired_at && unsubscribed == null )
            2: ( CURRENT_TIME > expired_at && unsubscribed == null )
            3: ( unsubscribed != null )
        */
        
        return null;
    }


}
