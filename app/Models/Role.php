<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'sort'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function role_user()
    {
        return $this->hasMany('App\Models\Role_user');
    }

    public function plans()
    {
        return $this->hasMany('App\Models\Plan', 'role_id', 'id');
    }


}