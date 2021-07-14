<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'passages';

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
                  'passage_title',
                  'passage_text',
                  'exercise_id',
                  'createdby'
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
     * Get the exerciseset for this model.
     */
    public function exerciseset()
    {
        return $this->belongsTo('App\Models\Exerciseset','exercise_id','id');
    }

    /**
     * Get the questions for this model.
     */
    public function questions()
    {
        return $this->hasMany('App\Models\Question','passage_id','id');
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

    /**
     * Get updated_at in array format
     *
     * param  string  $value
     * return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
