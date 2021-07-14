<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'schools';
    protected $primaryKey = 'id';
    protected $fillable = [
                  'school_name',
                  'address'
              ];

    protected $dates = [];
    protected $casts = [];
    
    //Get the users for this model.
    public function users()
    {
        return $this->hasMany('App\Models\User','school_id','id');
    }

    /**
     * Get created_at in array format
     */
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    /**
     * Get updated_at in array format
     */
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }
}
