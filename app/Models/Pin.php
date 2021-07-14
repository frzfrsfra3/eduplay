<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pins';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'class_id',
        'url',
        'image',
        'description'
    ];

}
