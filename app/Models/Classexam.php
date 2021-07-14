<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classexam extends Model
{
    // This is a intermediary Table between CourseClass and Exam

    public $timestamps = false;
    protected $table = 'classexams';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'class_id',
                  'exam_id',
                  'exam_start_date',
                  'exam_end_date',
                  'addedon'
              ];

    protected $dates = [];
    protected $casts = [];


    //This an intermediary Table Get the Class this record belongs to.
    public function courseclass()
    {
        return $this->belongsTo('App\Models\Courseclass', 'class_id', 'id');
    }

    // duplicate function have to check which one is used
    public function class()
    {
        return $this->belongsTo('App\Models\Courseclass', 'class_id');
    }

    //This an intermediary Table Get the exam this record belongs to
    public function exam()
    {
        return $this->belongsTo('App\Models\Exam', 'exam_id');
    }

    /**
     * Get UserSkill Mastery Level - Develop by WC
     */
    public function getUserSkillMasteryLevel()
    {
        return $this->hasMany('App\Models\UserSkillmasterylevel');
    }

    /**
     * Get the Examquestions for this exam - Develop by WC
     */
    public function getExamquestion()
    {
        return $this->hasMany('App\Models\Examquestion','exam_id','exam_id');
    }

    // Set and Get Added On attribute
    public function setAddedonAttribute($value)
    {
        $this->attributes['addedon'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getAddedonAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
