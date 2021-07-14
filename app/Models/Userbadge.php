<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userbadge extends Model
{
    public $timestamps = false;
    protected $table = 'userbadges';

    protected $primaryKey = 'id';
    protected $fillable = [
                  'user_id',
                  'badge_id',
                  'dateacquired'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the user for this record.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    /**
     * Get the badge for this record.
     */
    public function badge()
    {
        return $this->belongsTo('App\Models\Badge','badge_id');
    }

    /**
     * Set & Get the dateacquired.
     */
    public function setDateacquiredAttribute($value)
    {
        $this->attributes['dateacquired'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getDateacquiredAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
