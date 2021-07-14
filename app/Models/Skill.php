<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Skillcategory;

class Skill extends Model
{
    // use HasFactory;
    protected $table = 'skills';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'skill_category_id',
                  'topic_id',
                  'grade_id',
                  'skill_name',
                  'skill_description',
                  'description_Fr',
                  'description_Ar',
                  'version',
                  'publish_status',
                  'approve_status',
                  'createdby',
                  'updatedby',
                  'sort_order',
                  'origin_id'
              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get the skillcategory of this skill.
     */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
    public function skillcategory()
    {
        return $this->belongsTo('App\Models\Skillcategory','skill_category_id','id');
    }

    /**
     * Get the topic related to this skill.
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic','topic_id','id');
    }

    // get the topic name
    public function get_topicname()
    {
        $topicname='';
        if($this->topic_id){
            $topic=Topic::where ( 'id',$this->topic_id )->first();
            $topicname=$topic->topic_name;
        }
        return $topicname ;
    }
    public function contains(Skillcategory $skillcategory){
        return $this->skillcategory->where('skill_category_id',$skillcategory->id)->count();
    }
    /**
     * Get the grade_id of that skill as each skill is related to one grade.
     */
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade','grade_id');
    }

    //get the grade name
    public function get_gradename()
    {
        $gradename='';
        if($this->grade_id){
            $grade=Grade::where ( 'id',$this->grade_id )->first();
            if($grade){
                $gradename=$grade->grade_name;
                return $gradename;
            }

        }
        return "";
    }

    /**
     * get the skills changes for the next version
     */
    public function getskillchildren()
    {
        $childrenSkills=Skill::where ( 'origin_id' ,'=' ,$this->id )->get();
        return  $childrenSkills;
    }

    //get the user who updated the skill
    public function getusername_updateby()
    {
        $user=User::where ( 'id',$this->updatedby )->first();
        if ($user)
              return  $user->name;

        return "";
    }

    // get the user who created the skill
    public function getusername_createdby()
    {
        $user=User::where ( 'id',$this->createdby )->first();
        if ($user)
            return  $user->name;

        return "";
    }

    /**
     * Get class Exam - Develop by WC --TODO check what is this function for?
     */
    public function exam()
    {
        return $this->hasOne('App\Models\Exam', 'skill_id');
    }

    /**
     * Get all questions related to this skill
     */
    public function skillQuestion()
    {
        return $this->hasMany('App\Models\Question', 'skill_id');
    }

    //Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    //Get updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
