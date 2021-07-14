<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usernotification extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usernotifications';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    public function senderid()
    {
        return $this->belongsTo('App\Models\user','sender_userid');
    }

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'receiver_userid',
                  'sender_userid',
                  'notification',
                  'action_id',
                  'status'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    
    /**
     * Get the action for this model.
     */
    public function action()
    {
        return $this->belongsTo('App\Models\Action','action_id');
    }


    /**
     * Get created_at in array format
     *
     * param  string  $value
     * return array
     */
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    /**
     * Get updated_at in array format
     *
     * param  string  $value
     * return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
