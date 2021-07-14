<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gamerestrictedkid extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gamerestrictedkids';

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
                  'kid_id',
                  'game_id',
                  'restricted_by',
                  'isactive'
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
     * Get the kid for this model.
     */
    public function kid()
    {
        return $this->belongsTo('App\Models\Kid','kid_id');
    }

    /**
     * Get the game for this model.
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Game','game_id');
    }

    /**
     * Get the restrictedBy for this model.
     */
    public function restrictedBy()
    {
        return $this->belongsTo('App\Models\RestrictedBy','restricted_by');
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
