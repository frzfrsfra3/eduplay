<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'filters';

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
      'type',
      'operator',
      'value',
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
