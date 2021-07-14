<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skillmasterylevel extends Model
{
    protected $table = 'skillmasterylevels';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'levelname',
                  'level_massage',
                  'min_score',
                  'max_score',
                  'min_consecutive_value',
                  'max_consecutive_value'
              ];

    protected $dates = [];
    protected $casts = [];

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
