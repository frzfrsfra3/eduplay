<?php

namespace App\React\Disciplines;

use App\Http\Controllers\Controller;
use App\Models\Discipline;
use App\Models\Disciplineversion;
use App\Models\Grade;
use App\Models\Skillcategory;
use Illuminate\Support\Collection;


use Log;


use Exception;

class KnowledgemapController  extends Controller
{
    public function __construct ()
    {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        //$this->middleware ('auth');

    }


    public function index ($disciplineid)
    {

        $discipline = Discipline::findorfail ($disciplineid);


            $discipline_name = $discipline->discipline_name;
            $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');
            if (is_null ($lastversion) == true) $lastversion = 0;

            $skillcategories = Skillcategory::Where ([['discipline_id', '=', $disciplineid], ['version', '=', $lastversion], ['publish_status', '=', 'published']])
                               ->get ()->sortBy ('sort_order');
            $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();

                $grades =$discipline->curriculum_gradelist->grades()->get();
            return view ('knowledgemap.index', compact ('skillcategories','disciplines' , 'topics', 'grades', 'lastversion', 'discipline' ));
        }


    public function index_byskillcat ($disciplineid)
    {

        $discipline = Discipline::findorfail ($disciplineid);

        $discipline_name = $discipline->discipline_name;
        $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');
        if (is_null ($lastversion) == true) $lastversion = 0;

        $skillcategories = Skillcategory::Where ([['discipline_id', '=', $disciplineid], ['version', '=', $lastversion], ['publish_status', '=', 'published']])
            ->get ()->sortBy ('sort_order');
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();

        $grades =$discipline->curriculum_gradelist->grades()->get();
        return view ('knowledgemap.index_byskillcat', compact ('skillcategories','disciplines' , 'topics', 'grades', 'lastversion', 'discipline' ));
    }


}