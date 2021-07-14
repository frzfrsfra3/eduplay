<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;

class Activity extends Model
{

    // Indicates if the model should be timestamped.
    public $timestamps = false;
    protected $table = 'activities';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'activity_description',
                  'activity_description_ar'
              ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [];
    protected $casts = [];


    // Get the Activity Description
    public function getActivityDescriptionAttribute()
    {
        if(Config::get('languageTranslator') == "ar"  && !empty($this->activity_description_ar)){
            return $this->activity_description_ar;
        } else {
            return $this->attributes['activity_description'];
        }
    }

}
