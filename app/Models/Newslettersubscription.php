<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newslettersubscription extends Model
{
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'newslettersubscriptions';

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
                  'email',
                  'subscribedon'
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
     * Set the subscribedon.
     *
     * param  string  $value
     * return void
     */
    public function setSubscribedonAttribute($value)
    {
        $this->attributes['subscribedon'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get subscribedon in array format
     *
     * param  string  $value
     * return array
     */
    public function getSubscribedonAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
