<?php

namespace App\Models;


use Codebyray\ReviewRateable\Contracts\ReviewRateable;
use Codebyray\ReviewRateable\Traits\ReviewRateable as ReviewRateableTrait;
use Illuminate\Database\Eloquent\Model;

class Game extends Model implements ReviewRateable
{
    use ReviewRateableTrait;

    protected $table = 'games';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'discipline_id',
                  'developer_id',
                  'game_name',
                  'patform',
                  'app_id',
                  'secrete_key',
                  'game_icon',
                  'image1',
                  'image2',
                  'image3',
                  'image4',
                  'image5',
                  'category_id',
                  'age_id',
                  'status',
                  'isapproved',
                  'isactive',
                  'description'
              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get the discipline that this game is designed for. 0 is for all
     */
    public function discipline()
    {
        return $this->belongsTo('App\Models\Discipline','discipline_id');
    }

    /**
     * Get the developer of this game
     */
    public function developer()
    {
        return $this->belongsTo('App\Models\User','developer_id');
    }

    /**
     * Get the users who downloaded this game --TODO Use it in admin views
     */
    public function downloaders(){
        return $this->belongsToMany('App\Models\User','gamedownloads','game_id','user_id','id' );
    }

    //Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    //Get update_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
