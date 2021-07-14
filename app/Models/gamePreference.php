<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Exerciseset;

class gamePreference extends Model
{
    
    protected $table = 'game_preferences';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
                  'user_id',
                  'code',
                  'discipline_id',
                  'grade_id',
                  'maxtime',
                  'questiontype',
                  'topic_id',
                  'language_id',
                  'size',
                  'haspassage',
                  'list_exercise_ids',
                  'skill_category_id',
                  'skill_id'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the user for these Preferences
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    /**
     * Get the discipline for these Preferences.
     */
    public function discipline()
    {
        return $this->belongsTo('App\Models\Discipline','discipline_id');
    }

    /**
     * Get the topic for these Preferences
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic','topic_id');
    }

    /**
     * Get the language in these Preferences
     */
    public function language()
    {
        return $this->belongsTo('App\Models\Language','language_id');
    }

    /**
     * Get the grade in these Preferences
     */
     public function grade()
    {
        return $this->belongsTo('App\Models\Grade','grade_id');
    }

    /***
     * get Exercises List in these Preferences
     */
    public function getExercises(){

      $exerciseset_list= Exerciseset::whereIn('id',explode(',', $this->list_exercise_ids))->select('title')->get();

      return $exerciseset_list;
    }

    public function exercisesets(){

        $exerciseset_list= Exerciseset::whereIn('id',explode(',', $this->list_exercise_ids))->get();
  
        return $exerciseset_list;
      }

    // Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    //Get Updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
