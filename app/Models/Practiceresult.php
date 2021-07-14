<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Practiceresult extends Model
{
    
    public $timestamps = false;
    protected $table = 'practiceresults';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'question_id',
                   'user_id',
                  'answer_id',
                  'iscorrect',
                  'topics_id',
									'exercise_id',
									'total_minutes',
									'practice_token'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the question of this practice result.
     */
    public function question()
    {
        return $this->belongsTo('App\Models\Question','question_id');
    }

    /**
     * Get the answeroption of this practice result.
     */
    public function answeroption()
    {
        return $this->belongsTo('App\Models\Answeroption','answer_id');
    }

    /**
     * Get the topic for this model.
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic','topics_id');
    }

    /**
     * Get the exercise for this model.
     */
    public function exercise()
    {
        return $this->belongsTo('App\Models\Exercise','exercise_id');
    }

    // Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
