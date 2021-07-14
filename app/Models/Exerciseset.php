<?php

namespace App\Models;

use Conner\Tagging\Taggable;
use Codebyray\ReviewRateable\Contracts\ReviewRateable;
use Codebyray\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Exerciseset extends Model implements ReviewRateable
{
    use ReviewRateableTrait;
    use Taggable;

    protected $table = 'exercisesets';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'title',
                  'exerciseset_image',
                  'discipline_id',
                  'grade_id',
                  'skill_category_id',
                  'language_id',
                  'topic_id',
                  'description',
                  'minimum_age',
                  'maximum_age',
                  'publish_status',
                  'createdby',
                  'price'
                ];

    protected $dates = [];
    protected $casts = [];

    protected $hidden = ['pivot'];

    // Get the gradelist for this exerciseset from related discipline-> curricula table->grades
    public function gradelist()
    {
        return $this->discipline()->curriculum_gradelist()->grades();
    }

    //Get the discipline for this exerciseset.
    public function discipline()
    {
        return $this->belongsTo('App\Models\Discipline','discipline_id');
    }

    /**
     * Get topic for which this exerciseset belongs - prepare by Wc --TODO Check if ever used
     */
    public function topics()
    {
        return $this->belongsTo('App\Models\Topic','topic_id');
    }
    // duplicate function used in views/users/private-library/index.blade.php line 578
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic','topic_id');
    }

    /**
     * Get the grade specified for this exerciseset.
     */
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade','grade_id');
    }

    /**
     * Get the language specified for this exerciseset.
     */
    public function language()
    {
        return $this->belongsTo('App\Models\Language','language_id');
    }

    /**
     * Get the classes in which this exerciseset is published.
     */
    public function classes()
    {
        return $this->belongsToMany('App\Models\Courseclass','classexercises','exercise_id','class_id');
    }

    //check if this exercise is published to any class for safe deleting
    public function isbelelongtoclass($classid){

        $class=$this->classes()->where('class_id','=',$classid)->get();

        if ($class->count()<>0) return true;
        return false;
    }

    /**
     * Get the list of questions forming this exerciseset
     */
    public function question()
    {
        return $this->hasMany('App\Models\Question','exercise_id','id');
    }
    public function questions()
    {
        return $this->hasMany('App\Models\Question','exercise_id','id');
    }
    // calculating the number of questions in the exerciseset??
    public function sectionsCountRelation(){
        return $this->question()->selectRaw('id, count(*) as count')->groupBy('id');
    }

    /**
     * Get the list of passages existing in this exerciseset
     */
    public function passages()
    {
        return $this->hasMany('App\Models\Passage','exercise_id','id');
    }

    //Get the createdby for this exerciseset.
    public function owner()
    {
        return $this->belongsTo('App\Models\User','createdby');
    }

    // Get the list of users following this exerciseset
    public function buyers()
    {
        return $this->belongsToMany('App\Models\User','exercisesetbuyers','exerciseset_id','user_id');
    }



}
