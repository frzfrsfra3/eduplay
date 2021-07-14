<?php
namespace App\Http\Controllers\Course;
use App\Events\EnrollRequested;
use App\Models\Classexam;
use App\Models\Classexercise;
use App\Models\Exam;
use App\Models\Exerciseset;
use App\Models\Question;
use App\Models\Grade;
use App\Models\Language;
use App\Models\Discipline;
use App\Models\Curriculum;
use App\Models\Classlearner;
use App\Models\Courseclass;
use App\Models\Userexamanswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\Actiontaken;
use App\Events\ClassCreated;
use App\Events\ExamAdded;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Events\ExerciseSetAdded;
use App\Events\InviteLearner;
use App\Http\Controllers\Course\Input;
USE Carbon\Carbon;
use App\Http\Traits\AddXppoint;
use App\Models\Examquestion;
use App\Helpers\LogicHelper;
//use Carbon;
use Exception;
use App\Models\Pendingtask;
use Lang;
use App\Models\Pin;
use App\Models\RoleUser;
use App\Models\Role;
use App\Mail\InviteNonRegistered;
use App\Mail\InviteParent;
use App\Mail\InviteChild;
use Illuminate\Support\Facades\Mail;
use App\Models\GoogleClassroom;


class CourseclassesController extends Controller {

    /***
     * index, create, store, show, edit, update, destroy, getData
     * requestjoin, saveimage, listmyclasses, addlearner, invitelearner, accept, reject,
     * addexercise, removeexercise, addexam, removeexam, isavailableclass
     * myexercises, myexams, class exams,
     * getData
     ***/
    use AddXppoint;

    //photo path
    public function __construct() {
        //if trying to access this controller without being authenticated, it will ask him for authentication
        $this->middleware('auth');
        $this->photos_path = public_path('/Images');
    }

    /**
     * list all courses that are published
     */
    public function index(Request $request) {
        $paginationcount = 8;
        if (isset($_GET['searchkey'])) {
            $name = $_GET['searchkey'];
        } else {
            $name = '';
        }
        $courseclasses = Courseclass::with('discipline', 'grade', 'language')->where([['isavailable', 'like', 'y'], ['class_name', 'like', '%' . $name . '%']])->orwhere([['isavailable', 'like', 'y'], ['class_description', 'like', '%' . $name . '%']])->paginate($paginationcount);
        if ($request->ajax()) {
            $view = view('courseclasses.classes', compact('courseclasses'))->render();
            return response()->json(['html' => $view]);
            //  return response()->json(['html'=>$id]);
            
        }
        return view('courseclasses.index', compact('courseclasses', 'paginationcount'));
    }

    /**
     * Show the form for creating a new courseclass.
     */
    public function create() {
        if (Auth::user()->can('create', Courseclass::class)) {
            $languages = Language::orderby('language', 'asc')->get();
            $disciplines = Discipline::select('id', 'discipline_name')->orderBy('discipline_name', 'asc')->where('approve_status', 'approved')->where('publish_status', 'published')->get();
            $grades = Grade::pluck('grade_name', 'id')->all();
            //$courseclass='';
            return view('courseclasses.create', compact('languages', 'disciplines', 'grades'));
        } else {
            return view('unauthorized');
        }
    }

    /**
     * Store a new courseclass in the storage. and add XP_points for the teacher
     */
    public function store(Request $request) {
        try {
            //dd($request->file('image'));
            if (isset($request->isavailable)) {
                $request->isavailable;
            } else {
                $request->request->set('isavailable', 'N');
            }
            $path = $this->saveimage($request);
            
            $data = $request->all();
            // $data = $this->getData($request);
            $start_date = $data['start_date'];
            $date = str_replace('/', '-', $start_date);
            $data['start_date'] = date('Y-m-d', strtotime($date));
            $end_date = $data['end_date'];
            $date = str_replace('/', '-', $end_date);
            
            $data['end_date'] = date('Y-m-d', strtotime($date));
            if ($path == '0') {
                $data['iconurl'] = '';
            } else {
                $data['iconurl'] = $path;
            }
            $newclass = Courseclass::create($data);
            event(new ClassCreated($newclass));
            $this->add_xp_point(Auth::user()->id, 'createclass');
            return redirect()->route('courseclasses.courseclass.show', $newclass->id)->with('success_message', Lang::get('controller.classcourse_added'));
            // dd($newclass);
        }
        catch(Exception $exception) {
            //return $exception;
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified courseclass.
     */
    public function show($id) {
        $user = Auth::user();
        $courseclass = Courseclass::findOrFail($id);
        $pins = Pin::where('class_id', $id)->where('user_id', '=', $courseclass->teacher_userid)->get();
        $userrate = $this->collectOneSetRatingsWithUser($courseclass);
        if ($user->can('update', $courseclass)) 
            return view('courseclasses.show', compact('courseclass','userrate' ,'pins', 'user'));
        else 
        $learner = Classlearner::with('courseclass')->where('user_id', '=', $user->id)->where('class_id', '=', $id)->first();
        $exams = $courseclass->exams()->get();
        foreach ($exams as $key => $value) {
            if ($value->isavailable == 'N') {
                unset($exams[$key]);
            }
        }
        return view('courseclasses.learnerclass', compact('courseclass', 'learner', 'userrate', 'pins', 'user', 'exams'));
    }

    /** 
     * Get Pins filter content.
     */
    public function pinsFilter(Request $request)
    {
        //dd($request->all());
        $user=Auth::user();
        $pins = $this->getPinsFilterFilterData($request->classId); 
        return view('eduplaycloud.users.private-library.pins-filter', compact('pins','user'))->render();
    }

    /**
     * fetch filtering data. -Develop by WC
     */
    public function getPinsFilterFilterData($id){
        $courseclass = Courseclass::findOrFail($id);
        $user=$courseclass->teacher_userid;

        $pins= Pin::where('class_id',$id)->where('user_id', '=', $user);

        // Pin's Description search
        if(!empty(request('Description_search'))){
            if(request('Description_operator') === 'like'){
                $pins->where('description','LIKE','%'.request('Description_search').'%');
            } else {
                $pins->where('description','=',request('Description_search'));
            }
        }

        //Sorting Data by order.
        if(!empty(request('Sort_search')) && request('Sort_search') === 'Descending' ){
            $pins->orderBy('description', 'desc');
        } else {
            $pins->orderBy('description', 'asc');
        }
        return $pins->get();
    }
    
    /**
     * Show the form for editing the specified courseclass.
     */
    public function edit($id) {
        $courseclass = Courseclass::findOrFail($id);
        $classdiscipline = $courseclass->discipline()->first();
        $languages = Language::orderby('language', 'asc')->get();
        $disciplines = Discipline::select('id', 'discipline_name')->orderBy('discipline_name', 'asc')->where('approve_status', 'approved')->where('publish_status', 'published')->get();
        if (isset($classdiscipline->curriculum_gradelist_id)) {
            $grades = Grade::where('curriculum_gradelist_id', '=', $classdiscipline->curriculum_gradelist_id)->get()->pluck('grade_name', 'id');
        } else {
            $grades = array();
        }
        return view('courseclasses.edit', compact('courseclass', 'languages', 'disciplines', 'grades'));
    }

    /**
     * Update the specified courseclass in the storage.
     */
    public function update($id, Request $request) {
        try {
            if (isset($request->isavailable)) {
                $request->isavailable;
            } else {
                $request->request->set('isavailable', 'N');
            }
            $path = $this->saveimage($request);
            $data = $request->all();
            // $data = $this->getData($request);
            $start_date = $data['start_date'];
            $date = str_replace('/', '-', $start_date);
            $data['start_date'] = date('Y-m-d', strtotime($date));
            $end_date = $data['end_date'];
            $date = str_replace('/', '-', $end_date);
            $data['end_date'] = date('Y-m-d', strtotime($date));
            if ($path != '0') $data['iconurl'] = $path;
            $courseclass = Courseclass::findOrFail($id);
            $courseclass->update($data);
            return redirect()->route('courseclasses.courseclass.show', $courseclass->id)->with('success_message', Lang::get('controller.classcourse_updated'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Remove the specified courseclass from the storage.
     */
    public function destroy($id) {
        try {
            $courseclass = Courseclass::findOrFail($id);
            $courseclass->delete();
            return redirect()->route('courseclasses.courseclass.index')->with('success_message', Lang('controller.classcourse_deleted'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * user request to join a class
     */
    public function requestjpoin($classid, $guest = null) {
        try {
            $this->middleware('auth');
            $course = Courseclass::findorfail($classid);
            $data = ['message' => trans('messages.youarelareadyinclass') ];
            $useralreadyexist = Classlearner::where('class_id', '=', $classid)->where('user_id', '=', Auth::user()->id)->first();
            if (!$useralreadyexist) {
                // For xppoints Badges
                if (Auth::user()->hasRole('Learner') > 0) {
                    $this->add_xp_point (Auth::user ()->id, 'joinclass','Learner');
                }
                $newrequest = new Classlearner;
                $newrequest->class_id = $classid;
                $newrequest->user_id = Auth::user()->id;
                $newrequest->status = 'pending';
                $newrequest->joindate = Carbon::now();
                $newrequest->save();
                event(new EnrollRequested($course));
                $data = ['message' => trans('messages.thanksrequestjointoclass') ];

                $task= Pendingtask::where('user_id','=',Auth::user ()->id)
                ->where ('pending_task_description','=','Join a Class')
                ->first();
                if ($task)
                {
                    $task->status='done';
                    $task->task_type=1;
                    $task->save();
                }
            }
            if ($guest == 1) {
                return redirect()->route('courseclasses.courseclass.index');
            }
            return response()->json($data, 200);
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Save class image
     */
    private function saveimage(Request $request) {
        if ($request->file('image') != null) {
            $path = Storage::disk('images')->putFile('', $request->file('image'));
            if (!is_dir($this->photos_path)) {
                mkdir($this->photos_path, 0777);
            }
            $img = Image::make('Images/' . $path);
            $img->resize(300, 200);
            $img->save('assets/images/' . $path);
            $image_path = 'Images/' . $path; // Value is not URL but directory file path
            if (File::exists($image_path)) {
                File::delete('Images/' . $path);
            }
            return $path;
        }
        return '0';
    }

    /**
     * list my Classes only
     */
    public function listmyclasses() {
        $user = Auth::user();
        // $teacherclasses = Courseclass::where ('teacher_use rid', '=', $user->id)->get ();
        // app('App\Http\Controllers\PrintReportController')->getPrintReport();
        $enroledclasses = $user->enrolledclasses()->where([['isavailable', '=', 'Y'], ['status', '=', 'Accepted']])->get();

        $googleClasses = GoogleClassroom::where('user_id','=',Auth::user()->id)->get();

        return view('courseclasses.myclasses', compact('enroledclasses','googleClasses'));
    }

    /**
     * Get filter for class.
     */
    public function getClassFilter() {
        $paginationcount = 8;
        $modelQuery = Courseclass::where('teacher_userid', '=', Auth::user()->id);
        $courseclasses_collection = app('App\Http\Controllers\ExploreController')->fetchCourseClassesFilteredData($modelQuery, $paginationcount);
        
        if(request('SortBy_search') === 'Descending'){
          $courseclasses_collection = $this->allClassFilterSortByDesc($courseclasses_collection);
        } else if(request('SortBy_search') === 'Ascending') {
          $courseclasses_collection = $this->allClassFilterSortByAsc($courseclasses_collection);
        } else {
          $courseclasses = $courseclasses_collection;
        }
        
        $courseclasses = $this->paginate($courseclasses_collection, $paginationcount);
        
        // dd($courseclasses);
        // $courseclasses = $this->paginate($sortByData, $paginationcount);

        //This is for ajax call on filter.
        return view('courseclasses.classes', compact('courseclasses'))->render();
    }

    /**
     * Added filter sort by filter type.
     */
    public function allClassFilterSortByDesc($filter_classes){
      if(request('filter_search') === 'curriculum' ){
        $descData = collect($filter_classes)->sortByDesc(function ($class_value, $key) {
           return $class_value['discipline']['discipline_name'];
        });
      } else if(request('filter_search') === 'language'){
        $descData = collect($filter_classes)->sortByDesc(function ($class_value, $key) {
          return $class_value['language']['language'];
        });
      } else if(request('filter_search') === 'discipline'){
        $descData = collect($filter_classes)->sortByDesc(function ($class_value, $key) {
          return $class_value['topics']['topic_name'];
        });
      } else if(request('filter_search') === 'grade'){
        $descData = collect($filter_classes)->sortByDesc(function ($class_value, $key) {
          return $class_value['grade']['grade_name'];
        }); 
      } else if(request('filter_search') === 'title'){
        $descData = collect($filter_classes)->sortByDesc(function ($class_value, $key) {
          return $class_value->title;
        });
      } else if(request('filter_search') === 'number_of_learners'){ 
        $descData = collect($filter_classes)->sortByDesc(function ($class_value, $key) {
          return count($class_value->buyers_count);
        });
      } else {
        $descData = $filter_classes;
      }

      return $descData;
    }

     /**
     * Added filter sort by filter type.
     */
    public function allClassFilterSortByAsc($filter_classes){
      if(request('filter_search') === 'curriculum' ){
        $ascData = collect($filter_classes)->sortBy(function ($class_value, $key) {
            return $class_value->discipline['discipline_name'];
        });
      } else if(request('filter_search') === 'language'){
        $ascData = collect($filter_classes)->sortBy(function ($class_value, $key) {
          return $class_value->language['language'];
        });
      } else if(request('filter_search') === 'discipline'){
        $ascData = collect($filter_classes)->sortBy(function ($class_value, $key) {
          return $class_value->topics['topic_name'];
        });
      } else if(request('filter_search') === 'grade'){
        $ascData = collect($filter_classes)->sortBy(function ($class_value, $key) {
          return $class_value['grade']['grade_name'];
        }); 
      } else if(request('filter_search') === 'title'){
        $ascData = collect($filter_classes)->sortBy(function ($class_value, $key) {
          return $class_value->title;
        });
      } else if(request('filter_search') === 'number_of_learners'){ 
        $ascData = collect($filter_classes)->sortBy(function ($class_value, $key) {
          return count($class_value->buyers_count);
        });
      } else {
        $ascData = $filter_classes;
      }
      return $ascData;
    }

    /**
     * Update Teacher's about me.
     */
    public function teacherAboutUpdate() {
        $user = User::findorfail(request('user_id'));
        $teacher = User::where('id', '=', $user->id)->update(['aboutme' => request('aboutme') ]);
        return redirect()->route('courseclasses.courseclass.show', request('class_id'))->with('success_message', Lang::get('classcourse.about_teacher_msg'));
    }

    /**
     * teacher adds learner to the class
     */
    public function addlearner(Request $request, $class_id) {
        $courseclass = Courseclass::findorfail($class_id);
        $name = $request->name;
        if (strlen($name) > 0) {
            $learner = $courseclass->learners;
            $enrollid = $learner->pluck('id');
            $users = User::select('id', 'name', 'email', 'user_image')->where('email', '=',  $name )->whereNotIn('id', $enrollid)->where('id','!=',Auth::user()->id)->get();
            if (count($users) > 0) {
                return view('classlearners.addlearners', compact('courseclass', 'users'));
            } else {
                return view('classlearners.notlearners', compact('courseclass'));
            }
        } else {
            $users = null;
            return view('classlearners.addlearners', compact('courseclass', 'users'));
        }
    }

    /**
     * Invite Non-Learner
     */
    public function invitenonlearner(Request $request) {
        $course = Courseclass::findorfail($request->class_id);
        // Send mail with class details
        $email = $request->email;
        $class_url = $request->class_url;
        $register_url = $request->register_url;
        Mail::to($email)->send(new InviteNonRegistered($class_url, $register_url, $email));
        Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $email );
        Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    
        if (Mail::failures()) {
            $msg = 'Mail sent unsuccessfully!';
        } else {
            $msg = 'Mail sent successfully!';
        }
        return $msg;
    }

    /**
     * teacher invites learner to the class and throw an Event
     */
    public function invitelearner(Request $request, $class_id) {
        $user_id = $request->user_id;
        $course = Courseclass::findorfail($class_id);
        $invitelearner = New Classlearner();
        $invitelearner->user_id = $user_id;
        $invitelearner->class_id = $class_id;
        $invitelearner->status = 'Invited';
        $invitelearner->save();
        event(new InviteLearner($user_id, $course));
        $class_url = $request->class_url;
        // Send Emails to registered parent's & child for courseclass
        $userRole = RoleUser::with('users')->where('user_id', $request->user_id)->first();
        $role = Role::where('id', $userRole->role_id)->first();

        if ($role->name == "Learner") { // Child
            $email = $userRole->users['email'];
            $name = $userRole->users['name'];
            Mail::to($email)->send(new InviteChild($class_url, $name));
            Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $email );
            Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    
            if (Mail::failures()) {
                return ('no');
            } else {
                return ('yes');
            }
        } else if ($role->name == "Parent") { // Parent
            $email = $userRole->users['email'];
            Mail::to($email)->send(new InviteParent($class_url, $email));
            Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $email );
            Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    
            if (Mail::failures()) {
                return ('no');
            } else {
                return ('yes');
            }
        }
        return ('yes');
    }

    /**
     * teacher accept join request.
     */
    public function accept($id) {
        //accept a learner to a class
        try {
            $courselearner = Classlearner::findorfail($id);
            $course = Courseclass::findorfail($courselearner->class_id);

            // Pending task status update
            $task=Pendingtask::where('user_id' ,'=' ,Auth::user()->id)->where('pending_task_description' ,'=',"the Teacher ". $course->teacher()->first()->name . " has invite you to class : " . $course->class_name)
            ->where('pending_task_action' ,'=' ,'/courseclasses/show/'.$course->id)
            ->first();
            if ($task) {
                $task->status="done";
                $task->save();
            }

            if ($courselearner) {
                $courselearner->status = 'Accepted';
                $courselearner->joindate = Carbon::now();
                $courselearner->save();
                event(new Actiontaken("accepted", $courselearner));
                //$course = Courseclass::findorfail($courselearner->class_id);
                $learner = $course->learners()->findorfail($courselearner->user_id);
                $learner->courseclass_id = $course->id;
            }

            return view('courseclasses.learner', compact('learner'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * teacher rejects join request
     */
    public function reject($id) {
        //reject a learner to a class
        try {
            $courselearner = Classlearner::findorfail($id);
            if ($courselearner) {
                $courselearner->status = 'Rejected';
                $courselearner->joindate = Carbon::now();
                $courselearner->save();
                event(new Actiontaken("rejected", $courselearner));
                $course = Courseclass::findorfail($courselearner->class_id);
                $learner = $course->learners()->findorfail($courselearner->user_id);
                $learner->courseclass_id = $course->id;
            }
            return view('courseclasses.learner', compact('learner'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * add exercise to this class
     */
    public function addexercise($class_id, $exercise_id) {
        try {
            $classexercise = new Classexercise;
            $classexercise->class_id = $class_id;
            $classexercise->exercise_id = $exercise_id;
            $classexercise->save();
            $courseclass = Courseclass::findorfail($class_id);
            $myexercise = Exerciseset::findorfail($exercise_id);
            event(new ExerciseSetAdded($courseclass));
            return view('courseclasses.exercise', compact('myexercise', 'courseclass'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }
    
    /**
     * remove exercise from this class
     */
    public function removeexercise($class_id, $exercise_id) {
        try {
            $classexercise = Classexercise::where('class_id', '=', $class_id)->where('exercise_id', '=', $exercise_id)->first();
            if ($classexercise) {
                $classexercise->delete();
            }
            $courseclass = Courseclass::findorfail($class_id);
            $myexercise = Exerciseset::findorfail($exercise_id);
            return view('courseclasses.exercise', compact('myexercise', 'courseclass'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * add exam to this class
     */
    public function addexam($class_id, Request $request) {
        //return $request->all();
        try {
            $courseclass = Courseclass::findorfail($class_id);
            //dd($request->exam);
            foreach ($request->exam as $key => $dates) {
                $exam_id = $key;
                $exam_start_date = Carbon::parse($dates['startDate'])->format('Y-m-d H:m:s');
                $exam_end_date = Carbon::parse($dates['endDate'])->format('Y-m-d H:m:s');
                $classexam = new Classexam;
                $classexam->class_id = $class_id;
                $classexam->exam_id = $exam_id;
                $classexam->exam_start_date = $exam_start_date;
                $classexam->exam_end_date = $exam_end_date;
                $classexam->save();
                $exam = Exam::where('id', '=', $exam_id)->first();
                $courseclass = Courseclass::findorfail($class_id);
                event(new ExamAdded($courseclass, $exam));
            }
            return redirect()->route('courseclasses.courseclass.show', ['id' => $class_id, '#assignments'])->with('success_message', 'Exam added in your class !!');
            //return view ('courseclasses.user-exams', compact ('courseclass'))->with ('error_date', '');
            
        }
        catch(Exception $exception) {
            Storage::disk('local')->append('exam-calss-eddod.txt', $exception);
            return view('courseclasses.user-exams', compact('courseclass'))->with('error_date', 'error_date');
            return back()->withInput()->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }
    
    /**
     * remove exam from this class if not yet taken
     */
    public function removeexam($classId, $classexam_id) {
        try{
            $userexamanswer = Userexamanswer::where('exam_id', $classexam_id)->first();

            if(empty($userexamanswer)){
              $classexams = Classexam::where('class_id', $classId)->where('exam_id', $classexam_id)->first();
              $classexams->delete();
              
              //  event (new ExerciseSetAdded( $courseclass));
              return 'success';
            } else {
              return 'useranswer';
            }
            
        }
        catch(Exception $exception) {
            Storage::disk('local')->append('exam-calss-delete.txt', $exception);
            return 'fail';
        }
    }

    /**
     * check if the class is available
     */
    public function isavailableclass($class_id) {
        $class = Courseclass::findorfail($class_id);
        if ($class) {
            $class->isavailable;
            if ($class->isavailable == 'Y') $class->isavailable = 'N';
            else $class->isavailable = 'Y';
            $class->save();
        }
        return $class->isavailable;
    }

    /**
     * list my exercises to add from
     */
    public function myexercises($class_id) {
        $courseclass = Courseclass::findorfail($class_id);
        return view('courseclasses.user-exercises', compact('courseclass'));
    }

    /**
     * list my exams to add from
     */
    public function myexams($class_id) {
        $courseclass = Courseclass::findorfail($class_id);
        return view('courseclasses.user-exams', compact('courseclass'))->with('error_date', '');;
    }

    /**
     * list class exams
     */
    public function classexams($class_id) {
        $courseclass = Courseclass::findorfail($class_id);
        return view('courseclasses.class_exams', compact('courseclass'));;
    }

    /**
     * get exam dates
     */
    protected function getExamDates(Request $request) {
        $rules = ['start_date' => 'required', 'end_date' => 'required', ];
        $data = $request->validate($rules);
        return $data;
    }

    /**
     * Get the request's data from the request.
     */
    protected function getData(Request $request) {
        $rules = [
            'class_name' => 'required|string|min:1|max:250',
            'class_description' => 'required',
            'language_id' => 'required|numeric|min:0|max:4294967295',
            'start_date' => 'nullable|string|min:0',
            'end_date' => 'nullable|string|min:0',
            'discipline_id' => 'nullable',
            'grade_id' => 'nullable',
            'teacher_userid' => 'required|numeric|min:1|max:2147483647',
            'isavailable' => 'required'
        ];

        $data = $request->validate($rules);
        return $data;
    }

    /**
     * Remove learner from class.
     */
    public function removeClassLearner() {
        $classLearner = Classlearner::where('user_id', '=', request('user_id'))->where('class_id', '=', request('class_id'))->delete();
        if ($classLearner) {
            $message = 'Success';
        } else {
            $message = 'Error';
        }
        return response()->json($message);
    }

    /**
     * Get assignment filter.
     */
    public function assignmentFilter() {
        if ( !isset($_GET['class_id']) )
            return 1;
        $class_id = request('class_id');
        $courseclass = Courseclass::findorfail($class_id);
        $exams = $this->getAssigmentFilteredData($courseclass);
        return view('courseclasses.assignment-filter', compact('exams', 'class_id'))->render();
    }

    /**
     * Get filtered data from database.
     */
    protected function getAssigmentFilteredData($courseclass) {
        $exams = $courseclass->exams();
        //Fetch data by exerciseset's title.
        if (!empty(request('Title_search'))) {
            if (request('Title_operator') === 'like') {
                $exams->where('title', 'LIKE', '%' . request('Title_search') . '%');
            } else {
                $exams->where('title', '=', request('Title_search'));
            }
        }
        //Fetch Data by created date.
        if (!empty(request('start_date'))) {
            $startDate = Carbon::parse(request('start_date'))->format('Y-m-d') . " 00:00:00";
            $endDate = Carbon::parse(request('end_date'))->format('Y-m-d') . " 23:59:59";
            $exams->whereBetween('created_at', [$startDate, $endDate]);
        }
        //Sorting Data by order.
        if (!empty(request('Sort_search')) && request('Sort_search') === 'Descending') {
            $exams->orderBy('title', 'desc');
        } else {
            $exams->orderBy('title', 'asc');
        }
        return $exams->get();
    }

    /**
     * Added review for class.
     */
    public function addClassReview(Request $request) {
        $user = Auth::user();
        $id = $request->id;
        $rate = $request->score;
        if ($rate == "") {
            return response()->json('fail');
        }
        $title = ($request->title) ? $request->title : '';
        $comment = ($request->comment) ? $request->comment : '';
        $exerciseset = Courseclass::findorfail($id);
        $ratingauth = $exerciseset->ratings->where('author_id', $user->id)->first();
        if (!$ratingauth) {
            $this->add_xp_point (Auth::user ()->id, 'writereview');
            $rating = $exerciseset->rating(['title' => $title, 'body' => $comment, 'rating' => $rate, ], $user);
        } else {
            $rating = $exerciseset->updateRating($ratingauth->id, ['title' => $title, 'body' => $comment, 'rating' => $rate, ]);
        }
        return response()->json('success');
    }

    /**
     * Delete Assignment.
     */
    public function assignmentDelete($id) {
        try {
            $exam = Exam::findorfail($id);
            if (Auth::user()->can('editexam', $exam)) {
                $exam = Exam::findOrFail($id);
                $exam->delete();
                $deleteselection = Examselection::where('exam_id', '=', $id)->delete();
                return response()->json(['success_message' => 'Exam was successfully deleted!']);
            } else {
                return response()->json(['unexpected_error' => 'You cannot delete this exam']);
            }
        }
        catch(Exception $exception) {
            return response()->json(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * addexamtoclass ( New OR exist to class ) - Prepare by WC
     */
    public function addexamtoclass($id) {
        $user = Auth::user();
        $myexams = $user->myexams()->where('isavailable', 'Y')->get();
        $courseclass = Courseclass::findorfail($id);
        $courseclassexams = $courseclass->exams()->get();
        $myexams = $myexams->diff($courseclassexams);
        $myexams->unique();
        return view('courseclasses.addexamtoclass')->with(['myexams' => $myexams, 'classId' => $id]);
    }

    /**
     * Update Exam date from class.
     */
    public function updateExamDate(Request $request){

        $update = Classexam::where('id','=',$request->pivot_id)
                ->update([
                    'exam_start_date' => Carbon::parse($request->exam_startDate)->format('Y-m-d H:i:s'),
                    'exam_end_date' => Carbon::parse($request->exam_endDate)->format('Y-m-d H:i:s'),
                ]);
        
        return redirect()->route('courseclasses.courseclass.show', ['id' => $request->exam_class_id, '#assignments'])->with('success_message', Lang::get('controller.class_exam_date_update'));
    }

    /**
     * Assignment details page display.
     */
    public function classAssignmentDetails($id,$class_id){
      $examQuestions = Examquestion::where('exam_id','=',$id)->get();

      $questionIds = [];
      
      if(count($examQuestions) > 0){
        foreach($examQuestions as $question){
          array_push($questionIds,$question->question_id);
        }
  
        $questions = Question::with('skill','skillcategory','exercise','answeroptions')->whereIn('id',$questionIds)->paginate(25);
      }

      return view('courseclasses.assigment-details',compact('questions', 'class_id'));
    }

    /**
     * Import Google classroom.
     */
    public function importGoogleClasses(Request $request){
      $class = json_decode($request->gclass_selected,TRUE);
      $importClassData = [
        'user_id' => Auth::user()->id,
        'classid' => $class['id'],
        'name' => $class['name'],
        'room' => isset($class['room']) ? $class['room'] : NULL,
        'section' => isset($class['section']) ? $class['section'] : NULL,
        'alternateLink' => $class['alternateLink'],
        'courseState' => isset($class['courseState']) ? $class['courseState'] : NULL,
        'descriptionHeading' => isset($class['descriptionHeading']) ? $class['descriptionHeading'] : NULL,
        'enrollmentCode' => isset($class['enrollmentCode']) ? $class['enrollmentCode'] : NULL,
      ];

      if(isset($class['description'])){
        $importClassData['description'] = $class['description'];
      }

      $gclass = GoogleClassroom::where('user_id','=', Auth::user()->id)->where('classid','=',$class['id'])->first();
      if($gclass){
        GoogleClassroom::where('user_id','=', Auth::user()->id)->where('classid','=',$class['id'])->update($importClassData);
      } else {
        GoogleClassroom::create($importClassData);
      }
      return redirect()->route('courseclasses.courseclass.myclasses', ['#pills-gclass'])->with('success_message',  Lang::get('controller.import_success'));
    } 
    
    /**
     * Remove imported class from database.
     */
    public function gclassDestroy($gClassId){
      GoogleClassroom::where('user_id','=', Auth::user()->id)->where('id','=',$gClassId)->delete();
      return redirect()->route('courseclasses.courseclass.myclasses', ['#pills-gclass'])->with('success_message',Lang::get('controller.google_class_remove'));
    }
}

