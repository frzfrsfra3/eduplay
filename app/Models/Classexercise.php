<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classexercise extends Model
{
    // This is a intermediary Table between CourseClass and Exercise

    public $timestamps = false;
    protected $table = 'classexercises';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'class_id',
                  'exercise_id',
                  'addedon'
              ];

    protected $dates = [];
    protected $casts = [];

    // This is an intermediary Table. Get the Class for this record
    public function courseclass()
    {
        return $this->belongsTo('App\Models\Courseclass', 'class_id','id');
    }

    // This is an intermediary Table. Get the Exercise for this record
    public function exercise()
    {
        return $this->belongsTo('App\Models\Exerciseset', 'exercise_id');
    }

    // Set and Get Added On attribute
    public function setAddedonAttribute($value)
    {
        $this->attributes['addedon'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getAddedonAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }
}