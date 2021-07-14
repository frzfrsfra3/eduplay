<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examquestion extends Model
{
    //Table to save the exam creation selections - Questions Selection Step

    public $timestamps = false;
    protected $table = 'examquestions';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'exam_id',
                  'question_id',
                  'sort_order'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the exam for this record
     */
    public function exam()
    {
        return $this->belongsTo('App\Models\Exam','exam_id','id');
    }

    /**
     * Get the question for this record.
     */
    public function question()
    {
        return $this->belongsTo('App\Models\Question','question_id','id');
    }

    /**
     * Get Question answers for this record - Developed by WC
     */
    public function getUserExamAnswere()
    {
        return $this->hasMany('App\Models\Userexamanswer','question_id','question_id')
        //->where('exam_id', $this->exam_id)
        ;
    }

    /**
     * Get the answeroptions for this record. - Develop by WC
     */
    public function answereoption()
    {
        return $this->hasMany('App\Models\Answeroption','question_id','question_id');
    }

}
