<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvatarAccessorie extends Model
{
    protected $table = 'avatar_accessories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'avatar_id',
        'points',
        'image'
    ];

    // Get the avatar of this Accessory
    public function avatar() {
        return $this->belongsTo('App\Models\Avatar', 'avatar_id', 'id');
    }

}
