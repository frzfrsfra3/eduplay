<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Userexamscore extends Model
{
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'userexamscores';

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
                  'game_id',
                  'topic_id',
                  'match_uid',
                  'exam_id',
                  'classexam_id',
                  'score',
                  'totaltimespent'



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
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    /**
     * Get the exam for this model.
     */
    public function exam()
    {
        return $this->belongsTo('App\Models\Exam','exam_id','id');
    }

    /**
     * Get the skill for this model.
     */
    public function skill()
    {
        return $this->belongsTo('App\Models\Skill','skill_id');
    }

    /*** Get the topics for this Discipline.
     */
    public function topics()
    {
        return $this->belongsTo('App\Models\Topic','topic_id');
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


    public static function getHighestScoreInTopicAndGame($topic_id , $game_id){

        $scores = self::select('user_id' , DB::raw('sum(score) as total_score'))->where('topic_id' , $topic_id)->where('game_id' , $game_id)->groupBy('user_id')->get();
        $highestScore = $scores->first()->total_score;
        $userID = $scores->first()->user_id;
        foreach( $scores as $score )
        {
            if ( $score->total_score > $highestScore )
            {
                $highestScore = $score->total_score;
                $userID = $score->user_id;
                }
        }
        return $highestScore;

    }

}
