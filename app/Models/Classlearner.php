<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classlearner extends Model
{
    // This is a intermediary Table between CourseClass and Users

    public $timestamps = false;
    protected $table = 'classlearners';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'class_id',
                  'user_id',
                  'joindate'
              ];

    protected $dates = [];
    protected $casts = [];

    //This an intermediary Table. Get the Class this record belongs to.
    public function courseclass()
    {
        return $this->belongsTo('App\Models\Courseclass', 'class_id', 'id');
    }


    //This an intermediary Table. Get the user this record belongs to
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get the Exams related to this class - Developed by WC
     */
    public function getClassExam()
    {
        return $this->hasMany('App\Models\Classexam', 'class_id', 'class_id');
    }

    /**
     * Get class mastery level - Developed by WC
     */
    public function skillMasteryLevel()
    {
        return $this->hasMany('App\Models\UserSkillmasterylevel', 'user_id');
    }

    // Set and Get the Learner's JoinDate to a certain class
    public function setJoindateAttribute($value)
    {
        $this->attributes['joindate'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getJoindateAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }


}
