<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examtopic extends Model
{
    //Table to save the exam creation selections - Topics Selection Step

    protected $table = 'examtopics';
    protected $primaryKey = 'id';
    protected $fillable = [
        'topic_id',
        'exam_id',
    ];
}
