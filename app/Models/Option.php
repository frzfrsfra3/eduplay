<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function plan_options()
    {
        return $this->hasMany('App\Models\PlanOption', 'option_id', 'id');
    }
}
