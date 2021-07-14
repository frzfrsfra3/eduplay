<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamExercises extends Model
{
    //Table to save the exam creation selections - Exercises Selection Step

    public function exerciseset()
    {
        return $this->hasOne('App\Models\Exerciseset','id', 'exerciseset_id');
    }
}
