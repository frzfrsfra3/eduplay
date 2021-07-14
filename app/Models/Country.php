<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;


class Country extends Model
{
    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $fillable = [
                  'country_name',
                  'country_name_ar',
                  'country_name_fr',
                  'abbreviation_code',
                  'country_flag'
              ];

    protected $dates = [];
    protected $casts = [];

    // Countries Translation
    public function getCountryNameAttribute()
    {
        if(Config::get('languageTranslator') == "ar" && !empty($this->country_name_ar) ){
            return $this->country_name_ar;
        } else {
            return $this->attributes['country_name'];
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
