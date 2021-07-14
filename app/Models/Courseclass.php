<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Codebyray\ReviewRateable\Contracts\ReviewRateable;
use Codebyray\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;
class Courseclass extends Model
{
    //to be able to Rate this class and write Reviews
    use ReviewRateableTrait;

    protected $table = 'courseclasses';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'class_name',
                  'class_description',
                  'language_id',
                  'start_date',
                  'end_date',
                  'discipline_id',
                  'grade_id',
                  'teacher_userid',
                  'isavailable',
                  'iconurl'
              ];

    protected $dates = [];
    protected $casts = [];

    //Get the Language of this Class
    public function language()
    {
        return $this->belongsTo('App\Models\Language','language_id');
    }

    // Get the curriculum of this Class
    public function discipline()
    {
        return $this->belongsTo('App\Models\Discipline','discipline_id');
    }

    // Get the grade for this CourseClass.
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade','grade_id');
    }


    // Get the teacher for this CourseClass.
    public function teacher()
    {
        return $this->belongsTo('App\Models\User','teacher_userid');
    }

    /**
     * Get the exercises for this CourseClass.
     */
    public function exercises()
    {
        return $this->belongsToMany('App\Models\Exerciseset','classexercises','class_id','exercise_id');
    }
    /**
     * Get the learners for this CourseClass.
     */
    public function learners()
    {
        return $this->belongsToMany('App\Models\User','classlearners','class_id','user_id','id' )
            ->withPivot(['joindate' ,'status' ,'id']);
    }

    // Get class learners - Develop by WC --TODO Check why this one is needed. it's duplicate of the above
    public function getLearner()
    {
        return $this->belongsToMany('App\Models\User','classlearners','class_id','user_id','id' );
    }

    /**
     * Get the exams for this CourseClass.
     */
    public function exams()
    {
        return $this->belongsToMany('App\Models\Exam','classexams','class_id','exam_id')
            ->withPivot(['exam_start_date' ,'exam_end_date' ,'id' ,'addedon']);
    }

    // Get exam data - Develop by WC --TODO Check why this one is needed. it does not make sense
    public function examdata()
    {
        return $this->belongsTo('App\Models\Exam', 'exam_id', 'id');
    }

    /**
     * Get Intermediate records from ClassExams Table  - Develop by WC -- TODO Check why needed
     */
    public function getLearnerExam()
    {
        return $this->hasMany('App\Models\Classexam', 'class_id');
    }

    /**
     * Get exam scores for all users in this class - Develop by WC
     */
    public function userexamscore()
    {
        return $this->hasMany('App\Models\Userexamscore', 'classexam_id');
    }

    /**
     * Get skill categories in this class based on the discipline related to it - Develop by WC
     */
    public function skillCategory()
    {
        return $this->hasMany('App\Models\Skillcategory','discipline_id','discipline_id');
    }

    /**
     * Get created_at Attribute
     */
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y', strtotime($value));
    }

    /**
     * Get updated_at Attribute
     */
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
