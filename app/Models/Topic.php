<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Config;

class Topic extends Model
{
    protected $table = 'topics';
    protected $primaryKey = 'id';

    protected $fillable = [
        'topic_name',
        'topic_name_ar',
        'topic_name_fr',
        'approve_status',
        'iconurl',
        'publish_status',
        'createdby',
        'updatedby'
    ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get the skill for this Topic.--TODO Check the relationship it should be hasmany
     */
    public function skill()
    {
        return $this->hasOne('App\Models\Skill', 'topic_id', 'id');
    }

    /**
     * Get All the disciplines related  to this topic
     */
    public function discipilnes()
    {
        return $this->hasMany('App\Models\Discipline', 'topic_id', 'id');
    }

    /**
     * Get All the exercisesets related  to this topic
     */
    public function exercisesets()
    {
        return $this->hasMany('App\Models\Exerciseset', 'topic_id', 'id');
    }

    /**
     * Get All the exercisesets related  to this topic and created by this user and are published
     */
    public function exercisesetsfilter()
    {
        return $this->exercisesets()->where([['publish_status', 'like', 'public']])->where('createdby', '<>', auth()->id());
    }


    /**
     * Get the count of the exercises that this Topic has
     */
    public function countofexercisesets()
    {
        $count = $this->exercisesetsfilter()->count();
        return $count;
    }

    /**
     * Get user interests for this Topic
     */
    public function userInterests()
    {
        return $this->hasMany('App\Models\Userinterest', 'topic_id');
    }

    // Get the Topic name field translated based on the language used
    public function getTopicNameAttribute()
    {
        if(Config::get('languageTranslator') == "ar"  && !empty($this->topic_name_ar)){
            return $this->topic_name_ar;
        } else {
            return $this->attributes['topic_name'];
        }
    }

    //--TODO Check this is a dubplicate of the above
    public function getUserInterests()
    {
        return $this->hasOne('App\Models\Userinterest', 'topic_id');
    }

    // get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    // get updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
