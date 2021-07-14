<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gamedownload extends Model
{
    // This is a intermediary Table between Games and Users --TODO Check if intermediary Models are needed at all

    protected $table = 'gamedownloads';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'user_id',
                  'game_id',
                  'download_type'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the user of this record
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    /**
     * Get the game for this record.
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Game','game_id');
    }

    // Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    // Get updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
