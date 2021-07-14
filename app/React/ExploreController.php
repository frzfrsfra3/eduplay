<?php

namespace App\React;


use App\Models\Language;
use App\Models\Curriculum;
use App\Models\Discipline;
use App\Models\Exerciseset;
use App\Models\Country;
use App\Models\Courseclass;
use Illuminate\Http\Request;


//use Exception;

class ExploreController extends Controller
{

    /**
     * Display a listing of the exercisesets in the Public Library.
     **/
    public function exploreexerciseset()
    {
        // return excercisesets that are published to the public library
        if(isset($_GET['searchkey'])){ $name = $_GET['searchkey'];}else {$name='';}
        $exercisesets = Exerciseset::with('discipline','grade','language') ->where([['title', 'like', '%'.$name.'%'],['publish_status', 'like', 'public']])->orwhere([['description', 'like', '%'.$name.'%'],['publish_status', 'like', 'public']])->paginate(25);

        return view('exercisesets.index', compact('exercisesets'));
    }

    public function explorediscipline ()
    {
        if(isset($_GET['searchkey'])){ $name = $_GET['searchkey'];}else {$name='';}
        $disciplines = Discipline::with ('curriculum_gradelist','languagePreference')->where([['discipline_name', 'like', '%'.$name.'%'],['publish_status', 'like', 'published']])->orwhere([['description', 'like', '%'.$name.'%'],['publish_status', 'like', 'published']])->paginate (25);


        return view ('disciplines.index', compact('disciplines'));
    }

    public function exploreclasses(Request $request)

    {
        $paginationcount=8;
        if(isset($_GET['searchkey'])){ $name = $_GET['searchkey'];}else {$name='';}
        $courseclasses =  Courseclass::with('discipline','grade','language')
            ->where([['isavailable', 'like', 'y'],['class_name', 'like', '%'.$name.'%']])
            ->orwhere([['isavailable', 'like', 'y'] , ['class_description', 'like', '%'.$name.'%']])->paginate($paginationcount);

        if ($request->ajax()) {

            $view = view('courseclasses.classes',compact('courseclasses'))->render();

            return response()->json(['html'=>$view]);
            //  return response()->json(['html'=>$id]);
        }


        return view('courseclasses.index', compact('courseclasses'));
    }


}
