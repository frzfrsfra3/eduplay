<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    //--TODO Check why is login activity logged separately from other activities

    protected $table = 'login_activities';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address'
    ];
}
