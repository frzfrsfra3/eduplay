<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gamedetail extends Model
{
    
    // --TODO this table should be merged with the games table

    protected $table = 'gamedetails';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'platform_id',
                  'game_id',
                  'android_link',
                  'ios_link',
                  'ios_bundle_id',
                  'ios_url_scheme_suffix',
                  'ios_iphone_store_id',
                  'ios_ipad_store_id',
                  'android_package_name',
                  'android_key_hashes',
                  'android_class_name',
                  'android_amazon_url'
              ];

    protected $dates = [];
    protected $casts = [];
    
    /**
     * Get the game with this details.
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Game','game_id');
    }

}
