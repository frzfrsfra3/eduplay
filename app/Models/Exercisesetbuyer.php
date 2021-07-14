<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercisesetbuyer extends Model
{
    // This is a intermediary Table between Exercises and Users to indicate followers of exercisesets

    public $timestamps = false;
    protected $table = 'exercisesetbuyers';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'exerciseset_id',
                  'user_id',
                  'joindate'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the exerciseset from this record
     */
    public function exerciseset()
    {
        return $this->belongsTo('App\Models\Exerciseset','exerciseset_id');
    }

    /**
     * Get the user for this record.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    /**
     * Set & Get the joindate.
     */
    public function setJoindateAttribute($value)
    {
        $this->attributes['joindate'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getJoindateAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
