<?php

namespace App\Http\Controllers\GamePackAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GamePackController extends Controller
{

    public function __construct()
    {
        $this->middleware(['web' , 'api']);

    }

    public function getBootConfig()
    {
        return json_encode([ 'token' => csrf_token() ]);
    }
}
