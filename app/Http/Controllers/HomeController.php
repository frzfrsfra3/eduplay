<?php
namespace App\Http\Controllers;
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
use App\Models\Topic;
use Exception;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use App\Models\Useractivitylog;
use App\Models\Grade;
use App\Models\Plan;
use LogicHelper;
use DB;
use Redirect;
use App\Models\Language;
class HomeController extends Controller {

    /**
     * if user is Authenticated direct to the related Dashboard
     * if not authenticated direct to  view home
     * return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $user = Auth::user();
        $today = Carbon::now();
        $today->toDateTimeString();

        $topics = Topic::withCount('userInterests')
        ->orderBy('user_interests_count','DESC')
        ->orderBy('topic_name','ASC')
        //->toSql();
        ->limit(5)
        ->get();
//        dd($topics);
        $grades = Grade::orderBy('grade_name','asc')->get();
        $languages = Language::orderBy('language', 'asc')->get();
        
        if (Auth::user()) {
            $userinterest = Userinterest::where('topic_id', '=', 0)->where('user_id', '=', Auth::user()->id)->first();
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('users.user.index');
            } elseif (Auth::user()->hasRole('Learner')) {
                $disciplines = Auth::user()->disciplines->all();
                $users = '';
                $courseclasses = Courseclass::with('discipline', 'grade', 'language')->where('isavailable', 'like', 'y')->limit(6)->get();
                if (count($disciplines) == 0) {
                    $disciplines = Discipline::with('curriculum_gradelist', 'languagePreference')->orderByRaw('RAND()')->limit(9)->get();
                }
                $exercisesets = new Collection();
                $nb = count($disciplines);
                foreach ($disciplines as $discipline) {
                    $exercisesets = $exercisesets->merge($discipline->exercisesets()->get());
                }
                $allbadges = Auth::user()->badges->last();
                $pendings = Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)
                //->where('status', 'like', 'pending')
                ->where('task_type', 1)->orderby('sort','asc')->get();
                $profile = User::where('id', '=', Auth::user()->id)->select('id', 'name', 'mobile', 'email', 'gender', 'country_id', 'native_language','city','state','aboutme','user_image', 'grade_id', 'uilanguage_id', 'dob','linkedin_url', 'created_at')->first();
                // Task Percentage logic
                $totalTaskPr=LogicHelper::countTask();

                return view('eduplaycloud.users.dashboard', compact('user','disciplines', 'allbadges', 'pendings', 'exercisesets', 'courseclasses','profile','totalTaskPr','topics','userinterest','grades','languages'));

            }
            elseif (Auth::user()->hasRole('Teacher')) {

                $disciplines = Discipline::with ('curriculum_gradelist','languagePreference')->get();

                $exercisesets=new Collection();
                $nb = count($disciplines);
                foreach ($disciplines as $discipline) {
                    $exercisesets = $exercisesets->merge($discipline->exercisesets()->get());
                }
                $allbadges = Auth::user()->badges->last();
                $pendings = Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)
                //->where('status', 'like', 'pending')
                ->where('task_type', 1)->get();
                //Recent activities
                $recentActivities = Useractivitylog::where('user_id', $user->id)->whereNotIn('activity_id', [4, 5, 6, 7, 8, 9, 10])->orderBy('id', 'DESC')->limit(4)->get();
                $profile = User::where('id', '=', Auth::user()->id)->select('id', 'name', 'mobile', 'email', 'gender', 'country_id', 'grade_id', 'user_image', 'grade_id', 'uilanguage_id', 'dob')->first();
                // Task Percentage logic
                $totalTaskPr = LogicHelper::countTask();
                return view('eduplaycloud.users.dashboard', compact('user','disciplines','allbadges','pendings','exercisesets','courseclasses','profile','totalTaskPr','topics','userinterest','grades','languages'));
            } elseif (Auth::user()->hasRole('Parent')) {
                $childrens = User::where('parent_id', '=', Auth::user()->id)->get();
                $allbadges = Auth::user()->badges->last();
                $pendings = Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)
                //->where('status', 'like', 'pending')
                ->where('task_type', 1)->get();
                $profile = User::where('id', '=', Auth::user()->id)->select('id', 'name', 'mobile', 'email', 'gender', 'country_id', 'grade_id', 'user_image', 'grade_id', 'uilanguage_id', 'dob')->first();
                // Task Percentage logic
                $totalTaskPr=LogicHelper::countTask();

                return view('eduplaycloud.users.dashboard',compact('user','childrens','allbadges','pendings','profile','totalTaskPr','topics','userinterest','grades','languages'));
            }
        }

         //return view('home');
        return view('eduplaycloud.home');
    }

    /**
     * Display a listing of the countries.
     *
     * return Illuminate\View\View
     */
    public function home() {
        $topics = Topic::where('approve_status', '=', 'approved')->paginate(25);
        return view('eduplaycloud.home', compact('topics'));
    }

    /**
     * Load my private library data
     *
     * param Request $request
     * return void
     */
    public function myPrivateLibrary(Request $request) {
        if (Auth::user()) {
            if (isset($_GET['searchkey'])) {
                $name = $_GET['searchkey'];
            } else {
                $name = '';
            }
            $user = Auth::user();
            $myExercises = $user->myexercises()->where([['title', 'like', '%' . $name . '%'], ['createdby', '=', $user->id]])->orwhere([['description', 'like', '%' . $name . '%'], ['createdby', '=', $user->id]])->get();
            $exercisesBuy = $user->exercises;
            $myExercises->unique();
            $exercisesBuy->unique();
            $exerciseRatingList = $this->collectRatingsWithUser($myExercises);
            $exerciseBuyRatingList = $this->collectRatingsWithUser($exercisesBuy);
            return view('eduplaycloud.users.private-library.index', compact('myExercises', 'exercisesBuy', 'exerciseRatingList', 'exerciseBuyRatingList'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Get top discipline for guest into home page.
     *
     * return view
     */
    public function getTopDiscipline() {
        $topicsSimple = Topic::where('approve_status', '=', 'approved')->latest()->limit(4)->get();
        $topics = Topic::where('approve_status', '=', 'approved')->paginate(25);
        $classes = Courseclass::with(['getLearner', 'teacher', 'discipline', 'getLearnerExam', 'exercises'])->inRandomOrder()->limit(2)->get();
        $plans = Plan::getPlansByRoleId(1);
        return view('eduplaycloud.students', compact('topicsSimple', 'topics', 'classes' , 'plans'));
    }

    /**
     * Get top discipline for guest into home page.
     *
     * return view
     */
    public function getParent() {
        $topics = Topic::where('approve_status', '=', 'approved')->paginate(25);
        $plans = Plan::getPlansByRoleId(3);
        return view('eduplaycloud.parents', compact('topics' , 'plans'));
    }

    /**
     * Get top practice Exercises for teacher.
     *
     * return view
     */
    public function getToExercises() {
        $topics = Topic::where('approve_status', '=', 'approved')->paginate(25);
        $exerciseset = Exerciseset::with('discipline', 'grade', 'language')->inRandomOrder()->limit(3)->get();
        $exercisesets = $this->collectRatingsWithUser($exerciseset);
        $plans = Plan::getPlansByRoleId(2);
        return view('eduplaycloud.teachers', compact('exercisesets', 'topics' , 'plans'));
    }

    /**
     * Display what we are page.
     *
     * return View
     */
    public function getWhoWeArePage() {
        return view('eduplaycloud.who-we-are');
    }

    /**
     * Display what we are page.
     *
     * return View
     */
    public function getWhatWeDoPage() {
        return view('eduplaycloud.what-we-do');
    }

    /**
     * Display contact us page.
     *
     * return View
     */
    public function getContactUsPage() {
        return view('eduplaycloud.contact-us');
    }

    /**
     * Display faq page.
     *
     * return View
     */
    public function getFaqPage() {
        if(session('local') == null || session('local') == 'en'){
            return Redirect::to('https://eduplaycloud.freshdesk.com/en/support/home');
        } else {
            return Redirect::to('https://eduplaycloud.freshdesk.com/ar/support/home');
        }
        //return view('eduplaycloud.faq');
    }

    /**
     * Display privacy policy page.
     *
     * return View
     */
    public function getPrivacyPolicyPage() {
        return view('eduplaycloud.privacy-policy');
    }

    public function getPrivacyPolicyPageForGame() {
        return view('eduplaycloud.privacy-policy-for-game');
    }

    /**
     * Display forum page.
     *
     * return View
     */
    public function getForumPage() {
        if(session('local') == null || session('local') == 'en'){
            return Redirect::to('https://eduplaycloud.freshdesk.com/en/support/discussions');
        } else {
            return Redirect::to('https://eduplaycloud.freshdesk.com/ar/support/discussions');
        }
        //return view('eduplaycloud.forum');
    }
    
    /**
     * Display careers page.
     *
     * return View
     */
    public function getCareersPage() {
        return view('eduplaycloud.careers');
    }

    public function getdisciplies($laungauge_id,$topicId = null){
        $disciplineObj =Discipline::where('language_preference_id',$laungauge_id)
        ->where('approve_status','approved')
        ->where('publish_status','published');
        if(!empty($topicId)){
            $disciplineObj->where('topic_id','=',$topicId);
        }
        $discipline = $disciplineObj->get();
        return  Response($discipline);
    }

    public function getgrades ($discipline_id,$language_id){
        if ($discipline_id == 0) {
            $grade = Grade::all(); //select Select Discipline's Curriculum with value 0.
            //$grade = array();
        } else {
            $discipline=Discipline::findorfail($discipline_id);
            //$grade=$discipline->curriculum_gradelist->grades;
            $grade = Grade::whereHas('exerciseset',function ($query) use ($discipline_id,$language_id) {
                $query->where('publish_status', '!=', 'private');
                if (Auth::user()) {
                    $query->where('createdby', '!=', Auth::user()->id);
                }
                $query->where(['discipline_id'=>$discipline_id,'language_id' => $language_id]);
            })->with(['exerciseset','curriculum_gradelist.disciplines'])
            ->whereHas('curriculum_gradelist.disciplines',function($q) use ($discipline_id){
                $q->where('id',$discipline_id);
            })
            ->withcount(['exerciseset'=>function($q) use ($discipline_id,$language_id){
                $q->where('publish_status', '!=', 'private');
                if (Auth::user()) {
                    $q->where('createdby', '!=', Auth::user()->id);
                }
                $q->where(['discipline_id'=>$discipline_id,'language_id' => $language_id]);
            }])
            ->having('exerciseset_count','>',0)
            ->get();
        }

        return Response($grade);
    }


    public function microsoftTeams(){
      return view('microsoft-teams');
    }
}
