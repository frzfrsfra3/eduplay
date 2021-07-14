<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inviteduser extends Model
{
    // --TODO Check why is a user invited to a discipline, I thought he's invited to a CourseClass that might have no curriculum specified

    public $timestamps = false;
    protected $table = 'invitedusers';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'email',
                  'invitedby',
                  'message',
                  'invitationtype',
                  'invitationstatus',
                  'isinvitedregistered',
                  'discipline_id'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the discipline for this model.
     */
    public function discipline()
    {
        return $this->belongsTo('App\Models\Discipline','discipline_id');
    }

    // Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
