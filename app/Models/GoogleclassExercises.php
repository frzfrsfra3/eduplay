<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleclassExercises extends Model
{
    public $timestamps = false;
    protected $table = 'googleclass_exercises';
    protected $primaryKey = 'id';

    protected $fillable = [
                'class_id',
                'exercise_id',
                'googleclassid',
                'status',
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
     * Get the exercise for this model.
     */
    public function exercise()
    {
        return $this->belongsTo('App\Models\Exerciseset', 'exercise_id');
    }

    /**
     * Set & Get the addedon Attribute
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