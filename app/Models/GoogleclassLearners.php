<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleclassLearners extends Model
{
    public $timestamps = false;
    protected $table = 'googleclass_learners';
    protected $primaryKey = 'id';

    protected $fillable = [
                'user_id',
                'class_id',
                'googleclassid',
                'status',
                'joindate',
              ];

    protected $casts = [];

     /**
     * Get the google classroom for this learner.
     */
    public function googleClassroom()
    {
        return $this->belongsTo('App\Models\GoogleClassroom','class_id');
    }

}
