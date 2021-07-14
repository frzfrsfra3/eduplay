<?php

namespace App\React;

use App\Models\User;
use App\Models\Discipline;
use App\Models\Pendingtask;
use App\Models\Userinterest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Courseclass;
use Exception;

class UserHomeController extends Controller
{

    /**
     * Display a listing of the userinterests.
     *
     * return Illuminate\View\View
     */
    public function index()
    {
        $disciplines = Discipline::with ('curriculum','languagePreference')->get();
        $allbadges=Auth::user()->badges->last();

       $pendings=Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)->get();
        $exercisesets=new Collection();
        $nb = count($disciplines);


        return view('homepage',compact('disciplines','allbadges','pendings' ));
    }






}
?>