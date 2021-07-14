<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // A Grade is specific to a Curriculum (Discipline Model) which is specific to Discipline (Topic Model)
    // Once a grade_id is specified you can know what is the Curriculum and the Discipline

    protected $table = 'grades';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'grade_name',
                  'curriculum_gradelist_id',
                  'createdby'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the curriculum grades list related to this grade.
     */
    public function curriculum_gradelist()
    {
        return $this->belongsTo('App\Models\Curriculum_gradelist','curriculum_gradelist_id','id');
    }

    /**
     * Get the exercises related to this grade_id.
     */
    public function exerciseset()
    {
        return $this->hasMany('App\Models\Exerciseset','grade_id','id');
    }

    /**
     * Get the skills for this grade_id. - Develop by WC
     */
    public function skill()
    {
        return $this->belongsTo('App\Models\Skill','grade_id','id');
    }

    /**
     * Get all the skill categories for this grade_id
     */
    public function skillCategory()
    {
        return $this->belongsToMany('App\Models\Skillcategory','skills','skill_category_id','grade_id')->withPivot('grade_id','skill_category_id');
    }

    // Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    // Get updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
