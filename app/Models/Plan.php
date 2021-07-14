<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    // get the Plan Options of this plan
    public function plan_options()
    {
        return $this->hasMany('App\Models\PlanOption', 'plan_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany('App/Models/UserSubscriptions', 'plan_id', 'id');
        
    }

    public static function getPlansByRoleId($role_id)
    {
        return Plan::where(['role_id' => $role_id , 'visibility' => 'public'])->get();
    }

    public static function getPlanByRoleId($role_id , $price = 0)
    {
        return Plan::where([
            'role_id' => $role_id,
            'price' => $price
        ])->first();
    }
}
