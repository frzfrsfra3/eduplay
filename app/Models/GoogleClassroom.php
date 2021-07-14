<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleClassroom extends Model
{
    protected $table = 'google_classroom';
    protected $primaryKey = 'id';

    protected $fillable = [
                'user_id',
                'classid',
                'name',
                'room',
                'section',
                'alternateLink',
                'courseState',
                'descriptionHeading',
                'description',
                'enrollmentCode',
              ];

    protected $dates = [];
    protected $casts = [];
    

     /**
     * Get the teacher for this CourseClass.
     */
    public function teacher()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    /**
     * Get the learners for this model.
     */
    public function learners()
    {
        return $this->belongsToMany('App\Models\User','googleclass_learners','class_id','user_id','id' )
            ->withPivot(['joindate' ,'status' ,'id','googleclassid']);
    }


    /**
     * Get the exams for this CourseClass.
     */
    public function exams()
    {
        return $this->belongsToMany('App\Models\Exam','googleclass_exams','class_id','exam_id')
            ->withPivot(['exam_start_date' ,'exam_end_date' ,'id' ,'addedon']);
    }

    /**
     * Get the exercises for this model.
     */
    public function exercises()
    {
        return $this->belongsToMany('App\Models\Exerciseset','googleclass_exercises','class_id','exercise_id');
    }


}
