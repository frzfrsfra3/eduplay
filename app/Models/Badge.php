<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    public $timestamps = false;
    protected $table = 'badges';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'badgetitle',
                  'badgedescription',
                  'badgeimageurl',
                  'points',
                  'isactive',
                  'badge_condition',
                  'addedon'
              ];

    protected $dates = [];
    protected $casts = [];

    // Set & Get when this badge was Addedon.
    public function setAddedonAttribute($value)
    {
        $this->attributes['addedon'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function getAddedonAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    // Get Users who have this badge
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'userbadges', 'badge_id', 'user_id');
    }

    // Get when was this badge Updated
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }
}
