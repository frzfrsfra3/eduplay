<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Conner\Tagging\Taggable;
class Curriculum_gradelist extends Model
{
    use HasFactory, Taggable;

    protected $table = 'curricula_gradelists';
    protected $primaryKey = 'id';

    protected $fillable = [
                  'curriculum_gradelist_name',
                  'description',
                  'country_id',
                  'approve_status',
                  'createdby',
                  'updatedby'
              ];

    protected $dates = [];
    protected $casts = [];

    /**
     * Get all the disciplines (curriculum) that have this grades list.
     */
    public function disciplines()
    {
        return $this->hasMany('App\Models\Discipline', 'curriculum_gradelist_id', 'id');
    }

    /**
     * Get the grades of this grades list.
     */
    public function grades()
    {
        return $this->hasMany('App\Models\Grade', 'curriculum_gradelist_id', 'id');
    }

    /**
     * Get the country.... why is the country related to the grades list?
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    //Get created_at Attribute
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    //Get updated_at Attribute
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }
}
