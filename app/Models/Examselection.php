<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examselection extends Model
{
    
    public $timestamps = false;
    protected $table = 'examselections';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'exam_id',
                  'selection_id',
                  'selection_table',
                  'isselected'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the exam of this selection.
     */
    public function exam()
    {
        return $this->belongsTo('App\Models\Exam','exam_id');
    }

}
