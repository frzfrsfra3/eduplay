<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Discipline;
use App\Models\Pendingtask;
use App\Models\Userinterest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Courseclass;
use Exception;
use App\Models\Country;
use App\Models\Language;
use App\Models\Useractivitylog;
use App\Models\Grade;
use App\Models\Badge;
use LogicHelper;
use phpDocumentor\Reflection\Types\Null_;

class UserHomeController extends Controller {
    
    /**
     * Display a listing of the userinterests.
     *
     * return Illuminate\View\View
     */
    public function index() {
        $disciplines = Discipline::with('curriculum', 'languagePreference')->get();
        $allbadges = Auth::user()->badges->last();
        $pendings = Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)->where('task_type', 1)->get();
        $exercisesets = new Collection();
        $nb = count($disciplines);
        // Task Percentage logic
        $totalTaskPr = LogicHelper::countTask();
        return view('homepage', compact('disciplines', 'allbadges', 'pendings', 'totalTaskPr'));
    }

    /**
     * Get my task list.
     *
     * return void
     */
    public function getMyTasks() {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $countries = Country::pluck('country_name', 'id')->all();
        $uilanguages = Language::pluck('language', 'id')->all();
        $grades = Grade::pluck('grade_name', 'id')->all();
        $lastuseractivitylogs = Useractivitylog::where('user_id', '=', $id)->orderBy('id', 'desc')->first();
        $profile = User::where('id', '=', $id)->select('id', 'name', 'mobile', 'email', 'gender', 'country_id', 'grade_id', 'user_image', 'grade_id', 'school_id', 'uilanguage_id', 'dob', 'phone')->first();
        $children = User::where('parentmail', '=', $user->email)->get();
        $badgesAll = Badge::get();
        return view('eduplaycloud.users.task.my-task', compact('user', 'countries', 'uilanguages', 'profile', 'grades', 'lastuseractivitylogs', 'children', 'badgesAll'));
    }

    /**
     * Validate unique email
     *
     * param Request $request
     * return void
     */
    public function validateUniqueEmail(Request $request) {
        $usersObj = User::where($request->column, $request->value)->count();
        if ($usersObj > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    /**
     *
     * validation unique email for child
     *
     * param Illuminate\Http\Request $request
     * return Response
     */
    public function validationUniqueChildEmail(Request $request) {

        if(Auth::user()->email == $request->value){
            return 'false';
        } else {
            $usersObj = User::where($request->column, $request->value)->count();
            if($usersObj > 0){
                $childUserObj = User::where($request->column, $request->value)->whereNull('parent_id')->count();
                if($childUserObj > 0){
                    return 'true';
                } else {
                    $childUserObj = User::where($request->column, $request->value)->where('parent_id','=',Auth::user()->id)->count();
                    if($childUserObj > 0){
                        return 'true'; 
                    }
                    else{
                        return 'false';
                    }
                }
            }
            else{
                return 'true';
            }
        }
        //$usersObj = User::where($request->column, $request->value)->where('parent_id', '!=', NULL)->count();
        /* if ($usersObj > 0) {
            echo "false";
        } else {
            echo "true";
        } */
    }
}
?>