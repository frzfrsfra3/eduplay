<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Businessrule extends Model
{
    /**
     * This Model is Not Used yet
     */
    protected $table = 'businessrules';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'businessrule_name',
                  'businessrule_condition',
                  'isactive'
              ];

    protected $dates = [];
    protected $casts = [];

    //Get Created At
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    //Get Updated At
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }
}
