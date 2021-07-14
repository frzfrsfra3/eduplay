<?php

namespace App\Http\Controllers\Disciplines;

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

    /**
     *  gets the latest version (max version), get latest version of all skill categories related to this curriculum sorted by order
     * param $curriculumid
     * return to the view the skill categories, list of curricula, the grades, latest version and the curriculum itself
     */
    public function index ($disciplineid)
    {

        $discipline = Discipline::findorfail ($disciplineid);
        $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');
            if (is_null ($lastversion) == true) $lastversion = 0;

        $skillcategories = Skillcategory::Where ([['discipline_id', '=', $disciplineid], ['version', '=', $lastversion], ['publish_status', '=', 'published']])
                               ->get ()->sortBy ('sort_order');
        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
        $grades =$discipline->curriculum_gradelist->grades()->get();

       //topics is not available anywhere is this working??
            return view ('knowledgemap.index', compact ('skillcategories','disciplines' , 'topics', 'grades', 'lastversion', 'discipline' ));
    }

    /**
     *  same data as the function above but returning a different view !!
     * param $disciplineid
     */
    public function index_byskillcat ($disciplineid)
    {

        $discipline = Discipline::findorfail ($disciplineid);

        $lastversion = Disciplineversion::where ('discipline_id', '=', $disciplineid)->max ('version');
            if (is_null ($lastversion) == true) $lastversion = 0;

        $skillcategories = Skillcategory::Where ([['discipline_id', '=', $disciplineid], ['version', '=', $lastversion], ['publish_status', '=', 'published']])
                                ->get ()->sortBy ('sort_order');

        $disciplines = Discipline::pluck ('discipline_name', 'id')->all ();
        $grades =$discipline->curriculum_gradelist->grades()->get();

        return view ('knowledgemap.index_byskillcat', compact ('skillcategories','disciplines' , 'topics', 'grades', 'lastversion', 'discipline' ));
    }


}