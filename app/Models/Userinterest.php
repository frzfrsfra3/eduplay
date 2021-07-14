<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userinterest extends Model
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
    protected $table = 'userinterests';

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
        'discipline_id',
        'user_id',
        'topic_id',
        'language_id',
        'grade_id',
        'exercise_type',
        'exercises_id',
        'skill_category_id',
        'skill_id'
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
     * Get the discipline for this model.
     */
    public function discipline()
    {
        return $this->belongsTo('App\Models\Discipline','discipline_id');
    }

    /**
     * Get the user for this model.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
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
     * Get approved disciplone( Topic )
     * 
     *  prepare by WC
     */
    public function approvedTopic()
    {
        return $this->hasMany('App\Models\Topic','id','topic_id');
    }
}