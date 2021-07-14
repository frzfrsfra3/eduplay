<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $table = 'avatars';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'points',
        'category',
        'image'
    ];

    public function accessories()
    {
        return $this->hasMany('App\Models\AvatarAccessorie', 'avatar_id' );
    }

}
