<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleclassExams extends Model
{
    public $timestamps = false;
    protected $table = 'googleclass_exams';
    protected $primaryKey = 'id';

    protected $fillable = [
                'class_id',
                'exam_id',
                'exam_start_date',
                'exam_end_date',
                'addedon',
              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get the google classroom for this learner.
    */
    public function googleClassroom()
    {
        return $this->belongsTo('App\Models\GoogleClassroom','class_id');
    }
    
    /**
     * Get the class for this model.
     */
    public function class()
    {
        return $this->belongsTo('App\Models\GoogleClassroom', 'class_id');
    }


    /**
     * Get the exam for this model.
     */
    public function exam()
    {
        return $this->belongsTo('App\Models\Exam', 'exam_id');
    }

    /**
     * Get class get Class Exam- Develop by WC
     */
    public function getUserSkillMasteryLevel()
    {
        return $this->hasMany('App\Models\UserSkillmasterylevel');
    }

    /**
     * Get the userexamanswer for this model.-  Develop by WC
     */
    public function getExamquestion()
    {
        return $this->hasMany('App\Models\Examquestion','exam_id','exam_id');
    }

    /**
    * Set & Get AddedON Attribute
     */
    public function setAddedonAttribute($value)
    {
        $this->attributes['addedon'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getAddedonAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}