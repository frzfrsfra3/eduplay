<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userexamanswer extends Model
{

    public $timestamps = false;
    protected $table = 'userexamanswers';

    protected $primaryKey = 'id';

    protected $fillable = [
                  'answerdate',
                  'user_id',
                  'exam_id',
                  'class_id',
                  'classexam_id',
                  'attempt_number',
                  'question_id',
                  'answer_id',
                  'timespent',
                  'iscorrect',
                  'teachermark',
                  'pointsgained',
                  'gameid',
                  'user_agent',
                  'match_uid',
                  'match_datetime'
              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get the user for this record.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    /**
     * Get the exam for this record.
     */
    public function exam()
    {
        return $this->belongsTo('App\Models\Exam','exam_id','id');
    }

    /**
     * Get the question answered .
     */
    public function question()
    {
        return $this->belongsTo('App\Models\Question','question_id');
    }

    /**
     * Get the answer for this model.
     */
    public function answer()
    {
        return $this->belongsTo('App\Models\Answer','answer_id');
    }

    /**
     * Set & Get the answerdate Attribute
     */
    public function setAnswerdateAttribute($value)
    {
        $this->attributes['answerdate'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getAnswerdateAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    /**
     * Set & Get MatchDatetime Attribute
     */
    public function setMatchdatetimeAttribute($value)
    {
        $this->attributes['match_datetime'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getMatchdatetimeAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
