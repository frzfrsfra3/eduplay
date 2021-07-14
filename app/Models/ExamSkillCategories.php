<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSkillCategories extends Model
{
    //Table to save the exam creation selections - Skill Category Selection Step

    /* public function getExamSkillCategories()
    {
        //return $this->belongsToMany('App\Models\Exam', 'exams', 'skill_category_id', 'exam_id')->withTimestamps();
        return $this->belongsToMany('App\Models\Skillcategory', 'exam_skill_categories', 'skill_category_id', 'exam_id')->withTimestamps();
    } */

}
