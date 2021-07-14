<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Useractivitylog extends Model
{
    // intermediate table between Users and Activity

    public $timestamps = false;
    protected $table = 'useractivitylogs';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'activity_id',
                  'user_id',
                  'points',
                  'accumulated_points',
                  'details',
                  'device',
                  'browserinformation'
              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get the activity for this record.
     */
    public function activity()
    {
        return $this->belongsTo('App\Models\Activity','activity_id');
    }

    /**
     * Get the user for this record.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    // get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }
}
