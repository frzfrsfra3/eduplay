<?php

namespace App\React;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Discipline;
use App\Models\Pendingtask;
use App\Models\Exerciseset;
use App\Models\Userinterest;
use App\Http\Controllers\Controller;
use App\Models\Courseclass;
use Exception;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * if user is Authenticated direct to the related Dashboard
     * if not authenticated direct to  view home
     * return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (Auth::user()) {
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('users.user.index');
            }

            elseif (Auth::user()->hasRole('Learner')) {

                $disciplines=Auth::user()->disciplines->all();
                $users='';

                    $courseclasses = Courseclass::with ('discipline', 'grade', 'language')
                        ->where ('isavailable', 'like', 'y')
                        ->limit(6)->get();
                    if (count($disciplines)==0){
                $disciplines = Discipline::with ('curriculum_gradelist','languagePreference')->orderByRaw('RAND()') ->limit(9)->get();
                    }
                $exercisesets=new Collection();
                $nb = count($disciplines);
                     foreach ($disciplines as $discipline) {
                         $exercisesets=$exercisesets->merge($discipline->exercisesets()->get());
                    }


                 $allbadges=Auth::user()->badges->last();


                $pendings=Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)->where('status','like','pending')->get();
                return view('home',compact('disciplines','allbadges','pendings','exercisesets','courseclasses'));
            }
            elseif (Auth::user()->hasRole('Teacher')) {

                $disciplines = Discipline::with ('curriculum_gradelist','languagePreference')->get();

                $exercisesets=new Collection();
                $nb = count($disciplines);
                foreach ($disciplines as $discipline) {
                    $exercisesets=$exercisesets->merge($discipline->exercisesets()->get());
                }

                $allbadges=Auth::user()->badges->last();
                $pendings=Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)->where('status','like','pending')->get();


                return view('home',compact('disciplines','allbadges','pendings','exercisesets'));

            }
            elseif (Auth::user()->hasRole('Parent')) {
                $childrens=User::where('parent_id','=',Auth::user()->id)->get();

                $allbadges=Auth::user()->badges->last();


                $pendings=Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)->where('status','like','pending')->get();
                return view('home',compact('childrens','allbadges','pendings'));
        }
        }

         return view('home');


    }
}