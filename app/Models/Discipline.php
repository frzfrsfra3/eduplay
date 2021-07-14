<?php

namespace App\Models;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    /*
     * This class does represent the curriculum of a Discipline
     */
   use Taggable;
    protected $table = 'disciplines';
    protected $primaryKey = 'id';
    protected $fillable = [
                  'discipline_name',
                  'description',
                  'curriculum_gradelist_id',
                  'topic_id',
                  'group_id',
                  'iconurl',
                  'color',
                  'language_preference_id',
                  'approve_status',
                  'publish_status',
                  'createdby',
                  'updatedby'
              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get all the classes for this discipline (curriculum).
     */
    public function courseclasses()
    {
        return $this->hasMany('App\Models\Courseclass', 'discipline_id');
    }

    /**
     * Get the classes for this discipline (curriculum) given a specific language and checking this class is made available.
     */
    public function classes($discipline_id,$language_id)
    {   
        $classes = Courseclass::where('teacher_userid','<>',auth()->id())
                    ->where('discipline_id','=',$discipline_id)
                    ->where('language_id','=',$language_id)
                    ->where('isavailable','=','Y')
                    ->count();

        return $classes;
    }

    /**
     * Get all the Exercises for this discipline (curriculum).
     */
    public function exercisesets()
    {
        return $this->hasMany('App\Models\Exerciseset', 'discipline_id');
    }

    /**
     * Get the grades list for this discipline (curriculum).
     */
    public function curriculum_gradelist()
    {
        return $this->belongsTo('App\Models\Curriculum_gradelist', 'curriculum_gradelist_id', 'id');
    }

    /**
     * Get all the Skill Categories for this discipline (curriculum).
     */
    public function skillcategories()
    {
        return $this->hasMany('App\Models\Skillcategory', 'discipline_id', 'id');
    }

    /**
     * Get the topic for this Discipline.
     */
    public function topics()
    {
        return $this->belongsTo('App\Models\Topic', 'topic_id');
    }

    /**
     * Get the language for this Discipline.
     */
    public function languagePreference()
    {
        return $this->belongsTo('App\Models\Language', 'language_preference_id');
    }

    /**
     * Get collaborators for creating this Discipline (Curriculum).
     */
    public function disciplinecollaborators()
    {
        return $this->belongsToMany('App\Models\User', 'disciplinecollaborators', 'discipline_id','user_id')->withPivot(['approvalstatus','created_at']);
    }

    /**
     * Get the versions for this Discipline (Curriculum)..
     */
    public function disciplineversions()
    {
        return $this->hasMany('App\Models\Disciplineversion', 'discipline_id', 'id');
    }

    // Get Current Version
    public function currentversion()
    {
        $currentpublishedversion = Disciplineversion::where('discipline_id', '=', $this->id)->max ('version');
        return $currentpublishedversion;
    }

    //Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    //Get updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }


}