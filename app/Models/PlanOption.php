<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanOption extends Model
{
    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id', 'id');
    }

    public function option()
    {
        return $this->belongsTo('App\Models\Option', 'option_id' , 'id');
    }
}
