<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSkillmasterylevel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'userskillmasterylevels';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'user_id',
                  'skill_id',
                  'classexam_id',
                  'score',
                  'masteryLevel'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    
    /**
     * Get the user for this model.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    /**
     * Get the user for this model.
     */
    public function Skillmasterylevel()
    {
        return $this->belongsTo('App\Models\Skillmasterylevel','masteryLevel');
    }

    /**
     * Get the skill for this model.
     */
    public function skill()
    {
        return $this->belongsTo('App\Models\Skill','skill_id');
    }


    /**
     * Get created_at in array format
     *
     * param  string  $value
     * return array
     */
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    /**
     * Get updated_at in array format
     *
     * param  string  $value
     * return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    public function get_skillname()
    {
        $skillname='';
        if($this->skill_id){
            $skill=Skill::where ( 'id',$this->skill_id )->first();
            $skillname=$skill->skill_name;
        }
        return $skillname ;
    }

    public function get_level_massage()
    {
        $level_massage='';
        if($this->masteryLevel){
            $masteryLevel=Skillmasterylevel::where ( 'id',$this->masteryLevel )->first();
            $level_massage=$masteryLevel->level_massage;
        }
        return $level_massage ;
    }

}
