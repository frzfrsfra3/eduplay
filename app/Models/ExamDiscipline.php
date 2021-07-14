<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamDiscipline extends Model
{
    //Table to save the exam creation selections - Disciplines Selection Step
    /**
     * Get the discipline associated with the ExamDiscipline
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function discipline()
    {
        return $this->belongsTo('App\Models\Discipline', 'discipline_id', 'id');
    }
}
