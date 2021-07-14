<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;

class Pendingtask extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pendingtasks';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'user_id',
                  'sender_id',
                  'pending_task',
                  'pending_task_description',
                  'pending_task_description_ar',
                  'pending_task_action',
                  'status',
                  'task_type'
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
     * Get the user for this model.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    /**
     * Get the sender for this model.
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User','sender_id');
    }

    /**
     * Get created_at in array format
     *
     * param  string  $value
     * return array
     */
    public function getCreatedAtAttribute($value)
    {
        return $value;
        //return date('j/n/Y g:i A', strtotime($value));
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


    // Pending tas table Translation
    public function getPendingTaskAttribute()
    {
        if(Config::get('languageTranslator') == "ar"  && !empty($this->pending_task_description_ar)){
            return $this->pending_task_description_ar;
        } else {
            return $this->attributes['pending_task_description'];
        }
    }

}
