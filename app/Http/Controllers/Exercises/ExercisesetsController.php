<?php

namespace App\Http\Controllers\Exercises;

use App\Models\Exercisesetbuyer;
use App\Models\Skill;
use App\Models\Question;
use App\Models\Grade;
use App\Models\Language;
use App\Models\Topic;
use App\Models\Discipline;
use App\Models\Exerciseset;
use App\Models\Answeroption;
use App\Models\Courseclass;
use App\Models\Classexercise;
use App\Models\Skillcategory;
use App\Models\ExamExercises;
use App\Models\Pendingtask;
use App\Models\User;
use App\Models\Pin;
use App\Models\GoogleClassroom;
use App\Models\GoogleclassExercises;
use App\Classes\JsonSchema;
use App\Events\ExerciseSetCreated;
use App\Http\Controllers\Controller;
use App\Http\Traits\AddXppoint;
use App\Http\Requests\ExercisesetRequest;
use Log;
use Carbon\Carbon;
use Session;
use App\Helpers\LogicHelper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;



//use Exception;

class ExercisesetsController extends Controller
{
    use AddXppoint;
    private $logicHelper;
    public function __construct(LogicHelper $logicHelper)
    {
        $this->logicHelper = $logicHelper;
        $this->middleware('auth')->except('summary');
        $this->photos_path = public_path ('/images');
    }

    /**
     * Display a listing of the exercisesets in the Public Library.
     * returns index view  - Modify by WC.
     **/
        public function index()
        {
            // return excercisesets that are published to the public library
            $exercisesets = $exerciseset = Exerciseset::where([['publish_status', 'like', 'public']])->paginate(9);
            
                
            $ispublic = 1;
            
            // return view('exercisesets.index', compact('exercisesets'));
            return view('eduplaycloud.explore.public_library.index', compact('exercisesets', 'ispublic'))->render();
        }

    public function search($key)
    {
        $exercisesets = Exerciseset::with('discipline','grade','language')->where('title','like','%'.$key.'%')->paginate(25);
        return view('exercisesets.index', compact('exercisesets'));
    }

    /**
     * Display a listing of the exercisesets in the Private Library.
     * returns private view
     **/
    public function listprivatelib(){
        //list the exercisesets createdby the user or bought by the user (exercisesetbuyers)
        if (Auth::user()) {
            // Only For M1 added start
            $pendings=Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)
            //->where('status','like','pending')
            ->where('task_type',1)->orderby('sort','asc')->get();

            $profile = User::where('id', '=', Auth::user()->id)->select('id', 'name', 'mobile', 'email', 'gender', 'country_id', 'native_language','city','state','aboutme','user_image', 'grade_id', 'uilanguage_id', 'dob','linkedin_url', 'created_at')->first();
            // Only For M1 added start

            if(isset($_GET['searchkey'])){ $name = $_GET['searchkey'];}else {$name='';}

            $user=Auth::user();
            // $myExercises = $user->myexercises()
            // ->where([['title', 'like', '%'.$name.'%'],['createdby','=',$user->id]])
            // ->orwhere([['description', 'like', '%'.$name.'%'],['createdby','=',$user->id]])->get();

            $myExercises = $this->getPrivateLibFilterData();

            $exercisesBuy=$user->exercises;

            $myExercises = $myExercises->unique ();
            $exercisesBuy->unique ();
            $exerciseRatingList = $this->collectRatingsWithUser($myExercises,2);
            $exerciseBuyRatingList = $this->collectRatingsWithUser($exercisesBuy,2);

            $class_id = request()->has('class_id') ? request('class_id') : "";

            $courseclasses = Courseclass::where('teacher_userid', '=', Auth::user()->id)->select('id','class_name')->orderBy('class_name','asc')->get();
            $googleclasses = GoogleClassroom::where('user_id', '=', Auth::user()->id)->select('id','name')->orderBy('name','asc')->get();

            // Task Percentage logic
            $totalTaskPr = LogicHelper::countTask();

            // For Pins
            $pins= Pin::where('user_id', '=', Auth::user()->id)->orderBy('description', 'asc')->get();

        // return view('exercisesets.private', compact('myexercises','exercisesbuy'));

        if(Auth::user()->child_password_reset === 1){
            return view('eduplaycloud.users.private-library.index', compact('myExercises', 'exercisesBuy', 'exerciseRatingList','exerciseBuyRatingList','courseclasses','class_id','pendings','user','profile','totalTaskPr','pins','googleclasses'));
        } else {
            return redirect()->route('child-password-change');
        }
    }
    else
        {
            return view('auth.login');
        }

    }

    /**
     * Publish Exerciseset to class - Develop by WC
     */
    public function publishToClass(){
        $exercises = request('exercises');
        $class = request('class');

        if (request()->has('status')) {
            $status = 'public';
        } else {
            $status = 'private';
        }

        foreach($exercises as $exercise){
            $message = $this->storeClassExercise($class,$exercise,$status);
        }

        // Pending task status update
        $task=Pendingtask::where('user_id' ,'=' ,Auth::user()->id)->where('pending_task_description' ,'=','Add an exercise set to your class')
        ->where('pending_task_action' ,'=' ,'/courseclasses/show/'.$class)
        ->first();
        if ($task) {
            $task->status="done";
            $task->save();
        }

        return response()->json(['message' => $message, 'type' => 'exercises'], 200);
    }


    /**
     * Develop by WC
     * Publish Exerciseset to class
     * param Request
     * return Response
     */
    public function publishToGoogleclass(){
      $exercises = request('exercises');
      $class = request('class');

      if (request()->has('status')) {
          $status = 'public';
      } else {
          $status = 'private';
      }

      foreach($exercises as $exercise){
          $message = $this->storeGoogleClassExercise($class,$exercise,$status);
      }

      return response()->json(['message' => $message, 'type' => 'exercises'], 200);
  }

   /**
     * save google class exercise to publish.
     * 
     * param int class_id
     * param int exercise_id
     * param int status
     * return Response
     */
    protected function storeGoogleClassExercise($class_id,$exercise_id,$status){
      $ClassexerciseData = [
          'class_id' => $class_id,
          'exercise_id' => $exercise_id,
          'status' => $status
      ];

      $classExercise = GoogleclassExercises::where(['class_id' => $class_id,
      'exercise_id' => $exercise_id,])->first();
      
      if($classExercise == null){
          $storeClassExercise = GoogleclassExercises::insert($ClassexerciseData);

      } else {
          $storeClassExercise = NULL;
      }

      if($storeClassExercise !== NULL){
          $message = 'success';
      } else {
          $message = 'error';
      }

      return $message;
  }

       /**
     * Develop by WC
     * Publish Pins to class
     * param Request
     * return Response
     */
    
    public function pinspublishToClass(){

        $pins = request('pins');
        $class = request('class');
        
        foreach($pins as $pin){
            $message = $this->pinsInUpdateClassID($pin,$class);
        }

        return response()->json(['message' => $message,'type' => 'pin'], 200);
    }

    /**
     * Update pins table in class id for publis to pins.
     * 
     * 
     */
    public function pinsInUpdateClassID($pin,$class){

        $classPins = Pin::where('id',$pin)->where('user_id', '=', Auth::user()->id)->where('class_id',$class)->first();
        
        if($classPins == null){
            $pinsUpdate= Pin::where('id',$pin)->where('user_id', '=', Auth::user()->id)->update(['class_id' =>  $class]);
            
        } else {
            $pinsUpdate = NULL;
        }

        if($pinsUpdate !== NULL){
            $message = 'success';
        } else {
            $message = 'error';
        }

        return $message;
    }


    /**
     * save class exercise to publish.
     * 
     * param int class_id
     * param int exercise_id
     * param int status
     * return Response
     */
    protected function storeClassExercise($class_id,$exercise_id,$status){
        $ClassexerciseData = [
            'class_id' => $class_id,
            'exercise_id' => $exercise_id,
            'status' => $status
        ];

        $classExercise = Classexercise::where(['class_id' => $class_id,
        'exercise_id' => $exercise_id,])->first();
        
        if($classExercise == null){
            $storeClassExercise = Classexercise::insert($ClassexerciseData);
            // For xppoints Badges
            if (Auth::user()->hasRole('Teacher') > 0) {
                $this->add_xp_point (Auth::user ()->id, 'publishtoclass','Teacher');
            }
        } else {
            $storeClassExercise = NULL;
        }


        if($storeClassExercise !== NULL){
            $message = 'success';
        } else {
            $message = 'error';
        }

        return $message;
    }
    
    /** 
     * Get my library filter content.
     * 
     * param Request
     * return Response
     * 
     */
    public function myPrivateLibraryFilter()
    {
        // return excercisesets that are published to the public library
        $filter_exercises = $this->getPrivateLibFilterData(); 
        $ispublic = 1;

        if(request('Rating_search') != null){
            
            $myExercises = collect($filter_exercises)->filter(function ($exercise_value, $key) {
            
            //Filter by Rating count.            
            if(!empty(request('Rating_search'))){
                if(request('Rating_search') === $exercise_value->averageRating(1)[0]){
                    return $exercise_value->averageRating(1)[0] == request('Rating_search');
                } 
            }

        })->unique()->all();

        } else {

            $myExercises = $filter_exercises->unique();
        }

        
        if(request('SortBy_search') === 'Descending'){
          $myExercises = $this->allFilterSortByDesc($filter_exercises);
        } else {
          $myExercises = $this->allFilterSortByAsc($filter_exercises);
        }

        $exerciseRatingList = $this->collectRatingsWithUser($filter_exercises,2);

        return view('eduplaycloud.users.private-library.filter', compact('myExercises', 'ispublic','exerciseRatingList'))->render();
    }
    
    /**
     * Added filter sort by filter type.
     * 
     * 
     */
    public function allFilterSortByDesc($filter_exercises){
      if(request('filter_search') === 'curriculum' ){
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
            return $exercise_value->discipline->discipline_name;
        });
      } else if(request('filter_search') === 'topic'){
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
          return $exercise_value->topics->topic_name;
        });
      } else if(request('filter_search') === 'grade'){
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
          return $exercise_value->grade->grade_name;
        }); 
      } else if(request('filter_search') === 'title'){
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
          return $exercise_value->title;
        });
      } else if(request('filter_search') === 'number_of_questions'){ 
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
          return $exercise_value->question_count;
        });
      } else if(request('filter_search') === 'number_of_student'){ 
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
          return $exercise_value->buyers_count;
        });
      } else {
        $descData = $filter_exercises;
      }

      return $descData;
    }

     /**
     * Added filter sort by filter type.
     * 
     * 
     */
    public function allFilterSortByAsc($filter_exercises){
      if(request('filter_search') === 'curriculum' ){
        $ascData = collect($filter_exercises)->sortBy(function ($exercise_value, $key) {
            return $exercise_value->discipline->discipline_name;
        });
      } else if(request('filter_search') === 'topic'){
        $ascData = collect($filter_exercises)->sortBy(function ($exercise_value, $key) {
          return $exercise_value->topics->topic_name;
        });
      } else if(request('filter_search') === 'grade'){
        $ascData = collect($filter_exercises)->sortBy(function ($exercise_value, $key) {
          return $exercise_value->grade->grade_name;
        }); 
      } else if(request('filter_search') === 'title'){
        $ascData = collect($filter_exercises)->sortBy(function ($exercise_value, $key) {
          return $exercise_value->title;
        });
      } else if(request('filter_search') === 'number_of_questions'){ 
        $ascData = collect($filter_exercises)->sortBy(function ($exercise_value, $key) {
          return $exercise_value->question_count;
        });
      } else if(request('filter_search') === 'number_of_student'){ 
        $ascData = collect($filter_exercises)->sortBy(function ($exercise_value, $key) {
          return $exercise_value->buyers_count;
        });
      } else {
        $ascData = $filter_exercises;
      }

      return $ascData;
    }
    
    /**
     * fetch filtering data.
     *
     * return void
     * Develop by WC
     */
    public function getPrivateLibFilterData(){
        

        $myExercises = Exerciseset::withCount('question');

          if(!Auth::user()->hasRole('Admin')){
            $myExercises = $myExercises->where('createdby','=', Auth::user()->id);
          }


          $myExercises->withCount('buyers');

            //Fetch data by exerciseset's title.
            if(!empty(request('Title_search'))){
                if(request('Title_operator') === 'like'){
                    $myExercises->where('title','LIKE','%'.request('Title_search').'%');
                } else {
                    $myExercises->where('title','=',request('Title_search'));                            
                }
            }

            //Fetch Data by created date.
            if(!empty(request('start_date'))){
                $startDate = Carbon::parse(request('start_date'))->format('Y-m-d')." 00:00:00";
                $endDate = Carbon::parse(request('end_date'))->format('Y-m-d')." 23:59:59";
                $myExercises->whereBetween('created_at', [$startDate, $endDate]);
            }
            
            // Fetch data between minage and maximum age
            if (request('min_age') != "" && request('max_age') != "") {
                $myExercises->where('minimum_age','>=',request('min_age'))->where('maximum_age','<=',request('max_age'));
            }
            // //Sorting Data by order.
            // if(!empty(request('Sort_search')) && request('Sort_search') === 'Descending' ){
                
            //     $myExercises->orderBy('title', 'desc');
            // } else {
            //     $myExercises->orderBy('title', 'asc');
            // }
            
            //Fetch Data by Disicipline name.
            if(!empty(request('Curriculum_search'))){

                if(request('Curriculum_search') === 'N/A') {
                    $myExercises->where('discipline_id','=',NULL);
                } else {
                    $myExercises->whereHas('discipline',function($discipline){
                        if(request('Curriculum_operator') === 'like'){
                            $discipline->where('discipline_name','like','%'.request('Curriculum_search').'%');
                        } else {
                            $discipline->where('discipline_name','=',request('Curriculum_search'));
                        }
                    });
                }
            } else {
                $myExercises->with('discipline');
            }

            //Fetch Data by Topic name.
            if(!empty(request('Disicipline_search'))){
                $myExercises->whereHas('topics',function($topic){
                    if(request('Disicipline_operator') === 'like'){
                        $topic->where('topic_name','like','%'.request('Disicipline_search').'%');
                    } else {
                        $topic->where('topic_name','=',request('Disicipline_search'));
                    }
                });
              
            } else {
                $myExercises->with('topics');
            }
                //Fetch Data by Grade name.
            if(!empty(request('Grade_search'))){
                if(request('Grade_search') === 'N/A') {
                    $myExercises->where('grade_id','=',NULL);
                } else {
                    $myExercises->whereHas('grade',function($grade){
                        if(request('Grade_operator') === 'like'){
                            $grade->where('grade_name','like','%'.request('Grade_search').'%');
                        } else {
                            $grade->where('grade_name','=',request('Grade_search'));
                        }
                    });
                }
            } else {
                $myExercises->with('grade');
            }
                       
            //Filter by Questions count
            if(request('Question_search') != ''){
              $myExercises->having('question_count',request('Question_operator'),request('Question_search'));
            }
            
            //Filter by Buyer count.
            if(request('Buyer_search') != ''){
              $myExercises->having('buyers_count',request('Buyer_operator'),request('Buyer_search'));
            }
            
            return $myExercises->get();
    }


    /** 
     * Get Pins filter content.
     *
     * param Request $request
     * return View 
     */
    public function pinsFilter(Request $request)
    {
        //return $request->all();
        // return excercisesets pins
        $user=Auth::user();
        $pins = $this->getPinsFilterFilterData(); 
        return view('eduplaycloud.users.private-library.pins-filter', compact('pins','user'))->render();
    }

    /**
     * fetch filtering data.
     *
     * return void
     * Develop by WC
     */
    public function getPinsFilterFilterData(){
        $pins= Pin::where('user_id', '=', Auth::user()->id);

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
     * Show the form for creating a new exerciseset.
     * 
     * Modify By WC.
     * 
     * return View
     */
    public function create()
    {
        $lang=\Session::get('local');
        if($lang == 'en' || $lang == 'ar' || $lang == null ){
            $topics = Topic::where('approve_status','approved')->orderBy('topic_name','ASC')->get();
        }else{
            $topics = Topic::where('approve_status','approved')->Select('topic_name_'.$lang.' as topic_name', 'id')->orderBy('topic_name','ASC')->get();
        }
        $languages = Language::orderBy('language', 'asc')->get();
        return view('eduplaycloud.users.private-library.create', compact('topics','languages') );

    }

    /**
     * Import form is shown to paste the questions content inside the Editor and specify parameters
     */
    public function importform($id)
    {
        // Find Folder size
        $userid=Auth::user()->id;
        $path=public_path('assets/eduplaycloud/upload/exercisesset/user-'.$userid);
        $directories = File::allFiles($path);
        $file_size = 0;
        foreach($directories as $data){
            // Count Size
            $file_size += $data->getSize();
        }
        $file_size = number_format($file_size / 1000000,2);

        $exerciseset = Exerciseset::with('discipline','grade','language')->findOrFail($id);

        return view('eduplaycloud.users.private-library.importform', compact('exerciseset','file_size'));
        // return view('exercisesets.importform', compact('exerciseset'));
    }

    /**
     * 
     * Import Question bulk store.
     * 
     */
    public function storeImportBulkQuestion(Request $request){

        $input_data = $request->all();
        $validationArray = [];

        if ($request->hasFile('parameter')) {
            foreach ($request->file('parameter') as $key => $file) {
                $validationArray['parameter.'.$key.'.max'] = 'The ' .  $file->getClientOriginalName() . ' should not be greater than 120 KB.';
                $validationArray['parameter.'.$key.'.mimes'] = 'The ' .  $file->getClientOriginalName() . ' File(s) must be of type: :values.';
            }
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $imgkey => $imagefile) {
                $validationArray['image.'.$imgkey.'.max'] = 'The ' .  $imagefile->getClientOriginalName() . ' should not be greater than 120 KB.';
                $validationArray['image.'.$imgkey.'.mimes'] = 'The ' .  $imagefile->getClientOriginalName() . ' File(s) must be of type: :values.';
            }
        }

        $validator = \Validator::make (
            $input_data, 
            [
                'josn' => 'required|json',
                'parameter.*' => 'max:120|mimes:csv,txt',
                'image.*' => 'max:120|mimes:jpeg,jpg,png',
            ], 
        $validationArray);


        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator->getMessageBag()->toArray());
           
        }



        $questionArrayBulk = json_decode($request->josn);
        $exersice_id = $request->exercise_id;
        $resultArray = [];

        //Request in parameter file.
        $perameterFiles = [];
        if($request->hasfile('parameter'))
        {
            foreach($request->file('parameter') as $file)
            {
                $name = $file->getClientOriginalName();
                $perameterFiles[$name] = $file;
            }
        }

        //Request in Image file.
        $imageFiles = [];
        if($request->hasfile('image'))
        {
            foreach($request->file('image') as $imgfile)
            {
                $imgName = $imgfile->getClientOriginalName();
                $imageFiles[$imgName] = $imgfile;  
            }
        }

        //Question Each.
        foreach($questionArrayBulk as $quesKey => $mainJson){
            
            //Call JSON match method.
            $matchJson = $this->matchInputJsonStructure($mainJson);
            // When error fetch push error in result array.
            
            if($matchJson->valid != True){
                //Push error in one array.
                $matchJson->errors[0]['json'] = json_encode($mainJson,TRUE);
                $matchJson->errors[0]['status'] = Lang::get('controller.error');;
                $resultArray['Q'.(++$quesKey)] = $matchJson->errors[0];
                
            } else {
                
                $message['status'] = Lang::get('controller.success');
                $message['message'] =  Lang::get('controller.question_add_message');
                
                $resultArray['Q'.(++$quesKey)] = $message;
                
                
                
                $this->logicHelper->dbStart();
                try{
                    //Parameter section
                    if(count($mainJson->Parameters) > 0 && !empty($perameterFiles) && !empty($mainJson->Parameters[0]->value->filename) ){
                        $perameter =  $mainJson->Parameters[0];
                        
                        $filenameExtCheck = $mainJson->Parameters[0]->value->filename;
                        // echo "<pre>";

                        $ext = substr(strrchr($filenameExtCheck,'.'),1);
                        
                        if($ext != 'csv'){
                            $perameterFilename = $filenameExtCheck.".csv";
                        } else {
                            $perameterFilename = $filenameExtCheck;
                        }
                        
                        if (array_key_exists($perameterFilename,$perameterFiles)){
                            $file = $perameterFiles[$perameterFilename];
                        } else {
                            $file = '';
                        }
                        
                        if(!empty($file)){
                            $name = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                            $ext = pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
                            
                            //Match file name for perameter.
                            $filename = str_replace(' ', '_',$name.".".$ext);
                            $storePath = public_path('assets/eduplaycloud/upload/exercisesset/user-'.Auth::user()->id.'/csv/');

                            $file->move($storePath."/",$filename);
                            // $file->storeAs($storePath."/",$slug.".".$ext);
                            $pathd = str_replace(public_path(),'',$storePath."/".$filename);
                            $filePath = asset($pathd);

                            //Write here code for store question param.
                            $perameter->value->filename = $filename;
                            $perameter->value->filepath = $filePath;
                                
                        }
                    }
                        
                        $questionDetails = "";
                        //Question Section in Image upload.
                        foreach($mainJson->Questions as $qkey => $question){

                            //Question other attributes store.
                            $otherAttributes = [
                                'param' => $mainJson->Parameters[0]->value->filename,
                                'exercise_id' => (int) $exersice_id,
                                'maxtime' => (int) $mainJson->Questions[$qkey]->Attributes->MaxTime,
                                'mintime' => (int) $mainJson->Questions[$qkey]->Attributes->MinTime,
                                'tag' => $mainJson->Questions[$qkey]->Attributes->Tag,
                                'difficultylevel' => $mainJson->Questions[$qkey]->Attributes->Difficulty
                            ];
                            
                            //Question store without json details.
                            $questionStore = Question::create($otherAttributes);
                            
                            //Question id use every where.
                            $question_id = $questionStore->id;
                            $mainJson->Questions[$qkey]->question_id = $question_id;

                            foreach($question->Question_Description->Sections as $qskey => $qsection){
                                    //Text insert for title
                                    if($question->Question_Description->Sections[$qskey]->SectionType == 'text'){
                                        $questionDetails .= $question->Question_Description->Sections[$qskey]->Value;
                                        Question::where('id','=',$question_id)->update(['details' => $questionDetails]);
                                    }
                                    
                                   
                                    //Check question image availeble or not.
                                    if(array_key_exists($question->Question_Description->Sections[$qskey]->Value,$imageFiles)){
                                        
                                        $quesimagefile = $imageFiles[$question->Question_Description->Sections[$qskey]->Value];
                                        if($question->Question_Description->Sections[$qskey]->SectionType == 'Plugin'){
                                            if(isset($question->Question_Description->Sections[$qskey]->Plugin) && $question->Question_Description->Sections[$qskey]->Plugin == 'image'){
                                                $quesimagePath  = $this->uploadFile($quesimagefile,Auth::user()->id,$exersice_id,$question_id);
                                                
                                                $question->Question_Description->Sections[$qskey]->Value = $quesimagePath;
                                                // $question->Question_Description->Sections[$qskey]->Attributes->sectionvalue = $quesimagePath;
                                            }
                                        }
                                    
                                    }
        
                                //Question title update.
                                if($question->Question_Description->Sections[$qskey]->SectionType == 'text'){
                                    Question::where('id','=',$question_id)->update(['details' => $questionDetails]);
                                }
                            }

                    }

                    //Answer Section In image upload.
                    if(isset($mainJson->Questions[$qkey]->Answers->Choices)){
                        foreach($mainJson->Questions[$qkey]->Answers->Choices as $chkey => $choices){
                            foreach($choices->Sections as $chsecKey => $ansSection){
                                if($mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections[$chsecKey]->SectionType == 'Plugin'){
                                    if($mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections[$chsecKey]->Plugin == 'image'){
                                        //check answare image file availeble or not.
                                        if(array_key_exists($mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections[$chsecKey]->Value,$imageFiles)){
                                            $ansimagefile = $imageFiles[$mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections[$chsecKey]->Value];
                                            
                                            $ansimagePath  = $this->uploadFile($ansimagefile,Auth::user()->id,$exersice_id,$question_id);
                                            $mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections[$chsecKey]->Value = $ansimagePath;
                                            // $mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections[$chsecKey]->Attributes->sectiontype = 'image';
                                            // $mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections[$chsecKey]->Attributes->sectionvalue = $ansimagePath;
                                        }
                                    }                                
                                }


                            //Update Answare table id here.
                            //Make array for using answer store.
                            $correct = $mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Attributes->IsCorrect == 1 ? 1 : 0;
                            $answerJson = json_encode($mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections);
                            
                            //answer store method.
                            $answare_options =new Answeroption();
                            $answare_options['question_id'] =  $question_id;
                            $answare_options['details'] = $mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections[$chsecKey]->Value;
                            $answare_options['json_details'] = $answerJson;
                            $answare_options['answer_type'] = $mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Sections[$chsecKey]->SectionType;
                            $answare_options['iscorrect'] = $correct;
                            $answare_options['sort_order'] = ++$chsecKey;
                            $answare_options->save();
                            
                            $mainJson->Questions[$qkey]->Answers->Choices[$chkey]->Attributes->id =  $answare_options->id;

                            }

                        }
                    }

                    //Hint Section In Image Upload.
                    foreach($mainJson->Questions[$qkey]->Hints->HintList as $hkey => $hints){
                        foreach($hints->Sections as $hSkey => $hintSection){

                            if($hintSection->SectionType == 'Plugin'){
                                if($hintSection->Plugin == 'image'){
                                    //check image array in hint image avalible or not.
                                    if(array_key_exists($mainJson->Questions[$qkey]->Hints->HintList[$hkey]->Sections[$hSkey]->Value,$imageFiles)){

                                        $hintimagefile = $imageFiles[$mainJson->Questions[$qkey]->Hints->HintList[$hkey]->Sections[$hSkey]->Value];
    
                                        $hintimagePath  = $this->uploadFile($hintimagefile,Auth::user()->id,$exersice_id,$question_id);
                                        $mainJson->Questions[$qkey]->Hints->HintList[$hkey]->Sections[$hSkey]->Value = $hintimagePath;
                                        // $mainJson->Questions[$qkey]->Hints->HintList[$hkey]->Sections[$hSkey]->Attributes->sectionvalue = 'image';
                                        // $mainJson->Questions[$qkey]->Hints->HintList[$hkey]->Sections[$hSkey]->Attributes->sectionvalue = $hintimagePath;
                                    }
                                }

                            }
                        }
                        
                    }

                    //Convert Array to json.
                    $newJson = json_encode($mainJson,TRUE);
                    //Update json details.
                    $questionUpdate = Question::where('id','=',$question_id)->update(['json_details' => $newJson]);                    
                    $this->logicHelper->dbEnd();
                } catch(\Exeception $e){
                    $this->logicHelper->dbRollBack();
                    array_push($resultArray,$newJson);

                }
            }
        }
       
        Session::put('bulk_result',$resultArray);
        return redirect()->route('exercisesets.importbulk.result',['exercise_id' => $exersice_id]);
    }

    /**
     * Match input json structure.
     */
    public function matchInputJsonStructure($json){

        $schema = json_decode($this->getDefaultstructure());

        if(!$schema) {
            trigger_error('Could not parse the SCHEMA object.',E_USER_ERROR);
        }

        JsonSchema::$checkMode = JsonSchema::CHECK_MODE_TYPE_CAST;

        $result = JsonSchema::validate(
            $json,
            $schema
        );

        return $result;

    }

    /**
     * 
     * Get Import bulk result.
     * 
     */
    public function getImportBulkResult($exercise_id){

        if(Session::has('bulk_result')){
            $results = Session::get('bulk_result');
        } else {
            $results = NULL;
        }

        return view('eduplaycloud.users.private-library.importbulk-result',compact('results','exercise_id'));
    }

    public function getDefaultstructure(){

        // $json = '{"type":"object","properties":{"ItemType":{"type":"string"},"Attributes":{"type":["object","null"]},"Parameters":{"type":"array","properties":{"parameter":{"type":"string"},"value":{"type":"object","properties":{"type":{"type":"string"},"filename":{"type":"string"}}}}},"Questions":{"type":"array","properties":{"ItemType":{"type":"string"},"Attributes":{"type":"object","properties":{"Difficulty":{"type":"string"},"MinTime":{"type":"string"},"MaxTime":{"type":"string"},"Tag":{"Type":"string"},"Type":{"Type":"string"}}},"Question_Description":{"type":"object","properties":{"Attribute":{"type":["object","null"]},"Sections":{"type":"Array","properties":{"SectionType":{"type":"string"},"Attributes":{"type":"null"},"Value":{"type":"string"}}}}},"Answers":{"type":"object","properties":{"Attributes":"null","Choices":{"type":"Array","properties":{"Attributes":{"type":"object","properties":{"IsCorrect":""}},"Sections":{"type":"Array","properties":{"SectionType":{"type":"string"},"Attributes":{"type":["object","null"]},"Value":{"type":"string"}}}}}}},"Hints":{"type":"object","properties":{"Attributes":"null","HintList":{"type":"array","properties":{"type":"string","Attributes":"null","Sections":{"type":"object","properties":{"SectionType":{"type":"string"},"Attributes":{"type":["object","null"]},"Value":{"type":"string"}}}}}}}}}}}';
        $json = '{"type":"object","properties":{"ItemType":{"type":"string"},"Attributes":{"type":["object","null","string"]},"Parameters":{"type":"array","properties":{"parameter":{"type":"string"},"value":{"type":"object","properties":{"type":{"type":"string"},"filename":{"type":"string"}}}}},"Questions":{"type":"array","properties":{"ItemType":{"type":"string"},"Attributes":{"type":["object"],"properties":{"Difficulty":{"type":"string"},"MinTime":{"type":"string"},"MaxTime":{"type":"string"},"Tag":{"Type":"string"},"Type":{"Type":"string"}}},"Question_Description":{"type":"object","properties":{"Attribute":{"type":["object","null","string"]},"Sections":{"type":"Array","properties":{"SectionType":{"type":"string"},"Attributes":{"type":["object","null","string"]},"Value":{"type":"string"}}}}},"Answers":{"type":"object","properties":{"Attributes":{"type":["object","null","string"]},"Choices":{"type":"Array","properties":{"Attributes":{"type":["object","null","string"],"properties":{"IsCorrect":""}},"Sections":{"type":"Array","properties":{"SectionType":{"type":"string"},"Attributes":{"type":["object","null","string"]},"Value":{"type":"string"}}}}}}},"Hints":{"type":"object","properties":{"Attributes":{"type":["object","null","string"]},"HintList":{"type":"array","properties":{"type":"string","Attributes":{"type":["object","null","string"]},"Sections":{"type":"object","properties":{"SectionType":{"type":"string"},"Attributes":{"type":["object","null","string"]},"Value":{"type":"string"}}}}}}}}}}}';
        return $json;

    }


    public function QuestionAjaxCall(){
        dd(request()->all());

        return request()->all();
    }

    // import is the action of the import form, it converts content in json that is then converted into onjects saved in the DB
    public function import($exersice_id ,Request $request)
    {

        $option = [
            'exercise_id' => (int) $exersice_id,
            'maxtime' => (int) $request->max_time,
            'mintime' => (int) $request->min_time,
            'tag' => $request->tags,
            'difficultylevel' => $request->difficultylevel
        ];

        $this->logicHelper->dbStart();
        try{


        //Question store without json details.
        $questionStore = Question::create($option);

        //Question id use every where.
        $question_id = $questionStore->id;

        $questionArray = json_decode($request->json_details,TRUE);

        
        //This Parameters.
         if(isset($request->parameter_brows) && $request->file('parameter_brows')) {
            $folderSize = app('App\Http\Controllers\AssetsController')->calculateDirectorySize();

            if($folderSize > 500){
                Session::flash('unexpected_error', Lang::get('controller.quota_limit_error'));
                Session::put('tab', 'detail');
                return redirect()->back();
            } else {

                $file = $request->parameter_brows;
    
                $path = public_path().'/assets/eduplaycloud/upload/exercisesset/user-'.Auth::user()->id.'/csv';
                $fileName = str_replace(' ', '_',$file->getClientOriginalName());
                $filepath =  asset('/assets/eduplaycloud/upload/exercisesset/user-'.Auth::user()->id.'/csv'.'/'.$fileName);
    
                // echo $fileName;
                if (file_exists($path.'/'.$fileName)){
    
                } else {
                    $file->move($path, $fileName);
                }
                $questionArray['Parameters'][0]['value']['filename'] = $fileName;
                $questionArray['Parameters'][0]['value']['filepath'] = $filepath;
            }


         } else {
            $questionArray['Parameters'][0]['value']['filename'] = $questionArray['Parameters'][0]['value']['filename'];
         } 
        
        if(isset($questionArray['Parameters'][0]['value']['filename']) && $questionArray['Parameters'][0]['value']['filename'] != '' ){
            // Parameter file name store.
            Question::where('id','=', $question_id)->update([
                'param' =>  $questionArray['Parameters'][0]['value']['filename'],
            ]);
        }

        
        $questionDetails = "";
        //This each use for mulitple question add.
        foreach($questionArray['Questions'] as $qkey => $questions){

            //Question Id Append with attribute.
            $questionArray['Questions'][$qkey]['question_id'] = $question_id;

            $questionArray['Questions'][$qkey]['Attributes']['Difficulty'] =  $request->difficultylevel;
            $questionArray['Questions'][$qkey]['Attributes']['MinTime'] =  $request->min_time;
            $questionArray['Questions'][$qkey]['Attributes']['MaxTime'] =  $request->max_time;
            $questionArray['Questions'][$qkey]['Attributes']['Tag'] =  $request->tags;

            //Questions. 
            foreach($questions['Question_Description']['Sections'] as $qskey => $questionSection){
                


                //Store orignal test when paramater added.
                if($questionSection['SectionType'] == 'text'){
                    // $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'] = $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Attributes']['sectionvalue'];
                    $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'] = $request->question[($qskey+1)]['description'];
                    $questionDetails .= $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'];
                }
                if(strtolower($questionSection['SectionType']) == 'plugin'){
                    $value =  $request->question[($qskey+1)]['description'];
                    $value = explode("\Plugin_math\Attr{caption:'(1)'}{", $value)[1];
                    $value = explode("}_", $value)[0];
                    $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'] = $value;
                    $questionDetails .= $questionArray['Questions'][$qkey]['Question_Description']['Sections'][$qskey]['Value'];
                }

                //if($questionSection['SectionType'] == 'text'){
                    //Update Question in details for filter by question work.
                    Question::where('id','=', $question_id)->update([
                        'details' => $questionDetails,
                    ]);
                //}
            }

           
            //Answer
            foreach($questions['Answers']['Choices'] as $chkey =>$choices){
                //Answer Section each.
                foreach($choices['Sections'] as $chSkey => $ansSection){
                    //Store orignal test when paramater added.
                    if($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['SectionType'] == 'text'){
                        // $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Value'] = $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Attributes']['sectionvalue'];
                        $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections'][$chSkey]['Value'] = $request->answer['op_'.($chkey+1)][($chSkey+1)]['description'];

                    }
                }

                // //Make array for using answer store.
                $anstype = head($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']);
                $details = head($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']);
                $correct = $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Attributes']['IsCorrect'] == 1 ? 1 : 0;
                $answerJson = json_encode(head($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']));
                // //Call answer store method.
                $ansId = $this->answerStore($question_id,$anstype,$details,$answerJson,$correct,($chkey + 1));
                //Append answer id in question json for using practies.
                $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Attributes']['id'] = $ansId;
            }


            //Hints
            foreach($questions['Hints']['HintList'] as $hintkey => $hintList){
                //Hints Section
                foreach($hintList['Sections'] as $hskey => $hintSection){
                 

                    // hint in storage original input text.
                    if($questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['SectionType'] == 'text'){
                        // $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Value'] = $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Attributes']['sectionvalue'];
                        $questionArray['Questions'][$qkey]['Hints']['HintList'][$hintkey]['Sections'][$hskey]['Value'] = $request->hint[($hintkey+1)][($hskey+1)]['description'];
                    }
                }
            }


        }
        //Make Question Array to final json.
        $question_json = json_encode($questionArray, TRUE);
         Question::where('id','=', $question_id)->update([
            'json_details' => $question_json
        ]);
        
            $this->logicHelper->dbEnd();
            Session::flash('success_message', Lang::get('controller.question_add_message'));
            Session::put('tab', 'simple_editor');
    
        } catch(\Exeception $e){
            $this->logicHelper->dbRollBack();
            Session::flash('unexpected_error', Lang::get('controller.unexpected_error'));
            Session::put('tab', 'simple_editor');
        }
        
        return redirect()->back();

//         // echo "<pre>";
//         // print_r($questionArray);
//         // echo "</pre>";

//         // exit;
// // -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//         $json = $request->input ('jsonString');
//         $tags='';


//         $data=json_decode($json);
//         $difficulty_level = array('easy', 'medium', 'hard');
//         foreach ($data as $obj){

//             $question=new Question();
//             $question-> exercise_id=$id;
//             $qu=str_replace('&lt;','<',$obj->content);
//             $qu=str_replace('&gt;','/>',$qu);
//             $question->details=$qu." ";
//             $question->questiontype='richtext';
//             $question->maxtime=60;
//             $at=count($obj->Attrs);

//                 for ($j=0 ;$j < $at ;$j++){

//                     switch ($obj->Attrs[$j]->name)
//                         {
//                             case ('T'): $question->maxtime=$obj->Attrs[$j]->value;break;
//                             case ('D'): if ((in_array($obj->Attrs[$j]->value, $difficulty_level))){$question->difficultylevel=$obj->Attrs[$j]->value;} else {$question->difficultylevel='easy';}break;
//                             case ('H'): $question-> hint =$obj->Attrs[$j]->value;break;
//                             case ('tag'):$tags=$obj->Attrs[$j]->value; break;
//                         }
//                 }

                
//                 $question->save();
//             $qid=$question->id;
//             //add tags to the taggeble system
//             if(strlen($tags)>0) {$question->tag( $tags);}

//             $nbr=count($obj->Ans);
//             for($i = 0; $i < $nbr; $i++) {
//                 $answer=new Answeroption();
//                 $answer->details = $obj->Ans[$i]->content;
//                 $answer->answer_type = 'richtext';
//                 if (count($obj->Ans[$i]->Attrs) > 0) {
//                     $answer->iscorrect = 1;
//                 } else {
//                     $answer->iscorrect = 0;
//                 }
//                 $answer->question_id = $qid;
//                 $answer->sort_order = $i+1;
//                 $answer->save();
//             }
//         }
//         $ispublic=0;
//         $exerciseset = Exerciseset::with('discipline','grade','language')->findOrFail($id);
//         $questions = Question::with('skill','skillcategory','exercise','answeroptions')->where('exercise_id','=',$id)->paginate(6);
        
//         return view('exercisesets.show', compact('exerciseset','question'))->nest('nestquestion','questions/exercise_question', compact('questions'));
//     
    }
    
    /**
     * Display the specified exerciseset summary in preparation for practicing or generating an exam.
     */
    public function summary($id , $ispublic)
    {
      //  $this->middleware('auth');
        $exerciseset = Exerciseset::with('discipline','grade','language')->findOrFail($id);

        $userrate=0;
        $userrate = $this->collectOneSetRatingsWithUser($exerciseset);
        $addtoprivatelibrary = false; // Intialize variable
        if ($exerciseset) { // Check if exerciseset found or not           
            $exercisesetbuyersExists = false;
            if ( Auth::check() ) {
                $exercisesetbuyersExists = Exercisesetbuyer::where('exerciseset_id',$exerciseset->id)->where('user_id',Auth::user()->id)->select('id')->first();
            }
            if ($exercisesetbuyersExists) { // Check if exercisesetbuyers found or not
                $addtoprivatelibrary = true;
            }            
        }

        
        // return view('exercisesets.summary', compact('exerciseset' ,'userrate' ,'ispublic'));
        return view('eduplaycloud.explore.public_library.summary', compact('exerciseset' ,'userrate' ,'ispublic','addtoprivatelibrary'));
    }

    public function answerSection($answer){
        dd($answer);
    }
    
    /**
     * 
     * Develop by WC
     * 
     * Upload files function for question create.
     */
    public function uploadFile($file,$uid,$id,$questionId){
        $name = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
        $ext = pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);        
        $slug = Str::slug($name, '_');
        $storePath = public_path('assets/eduplaycloud/upload/exercisesset/user-'.Auth::user()->id.'/image');
        //$storePath = public_path()."/assets/eduplaycloud/question/user-$uid/ex-$id/que-$questionId";
        /* if(!File::isDirectory($storePath))
        {
            File::makeDirectory($storePath, 0777, true, true);
        } */
        $file->move($storePath."/",$slug.".".$ext);
        // $file->storeAs($storePath."/",$slug.".".$ext);
        $pathd = str_replace(public_path(),'',$storePath."/".$slug.".".$ext);
        $path = 'src:'.asset($pathd);
        return $path;
    }

    /**
     * 
     * Develop by Wc
     * 
     * Answer store with question create;
     * 
     */
    public function answerStore($question_id,$anstype,$details,$answerJson,$correct,$order){

        $answare_options =new Answeroption();
        $answare_options['question_id'] =  $question_id;
        $answare_options['details'] = $details['Value'];
        $answare_options['json_details'] = $answerJson;
        $answare_options['answer_type'] = $anstype['Value'];
        $answare_options['iscorrect'] = $correct;
        $answare_options['sort_order'] = $order;
        $answare_options->save();
        return $answare_options->id;
    }


    public function addrate(Request $request){

        $user = Auth::user ();
        $id= $request->id;
        $rate =$request->value;
        $exerciseset = Exerciseset::findorfail($id);
        $ratingauth=$exerciseset->find( $user);
        if (!$ratingauth)  {

        $rating = $exerciseset->rating([
            'title' => '',
            'body' => '',
            'rating' => $rate,
        ], $user);

        }
        else
        {
            $rating = $exerciseset->updateRating($ratingauth->id, [

                'rating' =>  $rate,
            ]);
        }

        return response()->json($exerciseset->find( $user)->rating);
    }

    public function addreview(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        $rate = $request->score;
        if ($rate == "")  {
            return response()->json('fail');
        }
        $title = ($request->title) ? $request->title : ' ';

        $comment = ($request->comment) ? $request->comment : '';

        $exerciseset = Exerciseset::findorfail($id);
        // $ratingauth=$exerciseset->find( $user);
        $ratingauth=$exerciseset->ratings->where('author_id', $user->id)->first();
        if (!$ratingauth)  {
            $this->add_xp_point (Auth::user ()->id, 'writereview');
            $rating = $exerciseset->rating([
                'title' => $title,
                'body' => $comment,
                'rating' => $rate,
            ], $user);
        }
        else
        {
            $rating = $exerciseset->updateRating($ratingauth->id, [
                'title' => $title,
                'body' => $comment,
                'rating' =>  $rate,
            ]);
        }

        return response()->json('success');

    }
    /**
     * Display the specified exerciseset with all questions in preparation for editing.
     */
    public function show($id , $ispublic=null)
    {
        if ($ispublic == null) {
            $ispublic = 0;
        }
        $this->middleware('auth');
        $exerciseset = Exerciseset::with('discipline','grade','language')->findOrFail($id);
        $userrate = $this->collectOneSetRatingsWithUser($exerciseset);
        $passages=$exerciseset->passages()->get();
        $questions = Question::with('skill','skillcategory','exercise','answeroptions')->where('exercise_id','=',$id)->paginate(25);

        if(request('type') === 'Edit'){
            \Session::flash('success_message', Lang::get('controller.exerciseset_update_msg'));
        } else if(request('type') === 'Create New') {
            \Session::flash('success_message', Lang::get('controller.exerciseset_add_msg'));
        }
        // return view('exercisesets.show', compact('exerciseset','question' ,'ispublic'))->nest('nestquestion','questions/exercise_question', compact('questions' ,'passages'));
        // Develop By WC ---------------
        $sectionType = ['text' => 'Text', 'image' => 'Image', 'video' => 'Video', 'audio' => 'Audio','plugin' => 'Plugins'];

        $skill_categories = SkillCategory::where('discipline_id','=',$exerciseset->discipline_id)->get();

        $path= public_path('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/image');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        
        $audioPath= public_path('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/audio');
        if(!File::isDirectory($audioPath)){
            File::makeDirectory($audioPath, 0777, true, true);
        }

        $csvPath= public_path('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/csv');
        if(!File::isDirectory($csvPath)){
            File::makeDirectory($csvPath, 0777, true, true);
        }
        
        $images = File::files($path);
        $audio = File::files($audioPath);
        $csvs = File::files($csvPath);
        
        
        // foreach($images as $image){

        //     $file = new SplFileInfo($image);
        //     dd($file->size);
        //     $path_parts = pathinfo($image);
            // echo $path_parts['dirname'], "\n";
            // echo "<img src='('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/image'".$path_parts['basename']."' >";
            // echo $path_parts['extension'], "\n";
            // echo $path_parts['filename'], "\n";
           
        // }

        $skills = $exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->all();

        $skillIds = [];
        foreach($skills as $key => $skill){
          array_push($skillIds,$key);
        }
        
        $associatedSkills = Skill::whereIn('id',$skillIds)->get();
        
        if(!Auth::user()->hasRole('Admin')){
          $exercisesets = Exerciseset::where('createdby', '=', Auth::user()->id)->get();
        } else {
          $exercisesets = Exerciseset::all();
        }

        return view('eduplaycloud.users.private-library.show', compact('exerciseset','exercisesets','questions' ,'ispublic', 'sectionType','skill_categories','images','audio','csvs','userrate','associatedSkills'))->nest('nestquestion','questions/exercise_question', compact('questions' ,'passages','exerciseset'));
        // -----------------------------
    }

    /**
     * Develop by WC
     * 
     * Filter in on change skill categories get all skill by below method.
     */
    public function getSkillsBySkillCateId(){

        $skills = Skill::where('skill_category_id','=',request('skill_category'))->get();

        return $skills;

    }

  
    public function listofquestion ($exercise_id ,Request $request) {

        $exercise=Exerciseset::where('id','=',$exercise_id)->where('publish_status', '=', 'public')->first();
        $exercise=Exerciseset::where('id','=',$exercise_id)->first();

        $questions=$exercise->question()->paginate(25);


        return view ('questions.exercise_question_public',compact ('questions'));
    }



    /**
     * Show the form for editing the specified exerciseset.
     */
    public function edit($id)
    {
        if (Auth::user ()) {
        $exerciseset = Exerciseset::findOrFail($id);

        $disciplines = Discipline::pluck('discipline_name','id')->all();
        
        if($exerciseset->discipline_id){
            $discipline=Discipline::findorfail($exerciseset->discipline_id);
            if(isset($discipline)) {
                if (isset($discipline->curriculum_gradelist) && isset($discipline->curriculum_gradelist->grades)) {
                    $grade=$discipline->curriculum_gradelist->grades;
                    $grades = $grade->pluck('grade_name','id');
                } else {
                    $grade = "";
                    $grades = null;    
                }
            }
        }
        else  {
            $grades =null;
        }

        //$topics = Topic::get();
        $lang=Session::get('local');
        if($lang == 'en' || $lang == 'ar' || $lang == null ){
            $topics = Topic::where('approve_status','approved')->orderBy('topic_name','ASC')->get();
        }else{
            $topics = Topic::where('approve_status','approved')->Select('topic_name_'.$lang.' as topic_name', 'id')->orderBy('topic_name','ASC')->get();
        }
        $languages = Language::orderBy('language', 'asc')->get();

        if(Auth::user()->id == $exerciseset->createdby){
            // return view('exercisesets.edit', compact('exerciseset','curricula','disciplines','grades','skillCategories','languages'));
            return view('eduplaycloud.users.private-library.edit', compact('exerciseset','curricula','disciplines','grades','skillCategories','languages','topics'));
        } else {
            return back()->withInput()
            ->withErrors(['unexpected_error' => Lang::get('controller.unexpected_error')]);
        }

        }
        
        return view ('auth.login');
    }

    /**
     * Store a new exerciseset in the storage.
     */
    public function store(ExercisesetRequest $request)
    {
        try {
            $data = $request->all();
            // if (!array_key_exists('publish_status', $data)) {
                //     $data['publish_status']='private';
                // }

                if ($request->hasFile('exerciseset-image')) {
                    $image = $request->file('exerciseset-image');
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $name = $image->getClientOriginalName();
                    $destinationPath = public_path('/uploads/exercisesets');
                    $image->move($destinationPath, $name);
                    $data['exerciseset_image'] = $name;
            }


            $ispublic=0;
            $pid=Exerciseset::create($data);
            $this->add_xp_point (Auth::user ()->id, 'createexerciseset');

            //Tags explorer.
            if($request->has('tags') && !is_null($request->tags)){
                $pid->tag(explode(',', $request->tags));
            }

            $id=$pid->id;
            $language_id = $pid->language_id;
            $topicId = request('topic_id');

            event(new ExerciseSetCreated($pid));
            $type = 'Create New';


            // return redirect()->route('exercisesets.exerciseset.show',compact('id' ,'ispublic'))
                // ->with('success_message', 'Exerciseset was successfully added!');

            return redirect()->route('exercisesets.exerciseset.select-curriculum',compact('id' ,'ispublic', 'topicId','type','language_id'))
                ->with('success_message',Lang::get('controller.exerciseset_add_msg'));

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => Lang::get('controller.unexpected_error')]);
        }
    }

    /**
     * Display select Curriculum page for select Curriculum.
     *
     * Develop By WC.
     * return void
     */
    public function selectCurriculum(){

        $id = request('id');
        $ispublic = request('ispublic');
        $topicId = request('topicId');
        $type = request('type');
        $language_id = request('language_id');
        
        $exerciseset = Exerciseset::with('language')->findOrFail($id);
        $disciplines=Discipline::where('approve_status','approved')
                                // ->where('language_preference_id','=',$language_id)
                                ->where('topic_id','=',$topicId)
                                ->where('publish_status','=','published')
                                ->with('topics')->orderBy('discipline_name', 'asc')
                                ->get();

        $languages = Language::orderBy('language', 'asc')->get();

        return view('eduplaycloud.users.private-library.select-curriculum',compact('disciplines','topicId','id','ispublic','exerciseset','languages','type','language_id'));
    }
    
    /**
     * Select curriculum.
     *
     * return void
     */
    public function selectCurriculumFilter(){
        $id = request('exercise_id');
        $exerciseset = Exerciseset::findOrFail($id);
        $filter_disciplines = $this->curriculumFilterData();

        if(request('SortBy_search') == 'Descending'){
          $disciplines = $this->allCurriculumFilterSortByDesc($filter_disciplines);
        } else {
          $disciplines = $this->allCurriculumFilterSortByAsc($filter_disciplines);
        }

        return view('eduplaycloud.users.private-library.filter-curriculum',compact('disciplines','exerciseset'))->render();
    }

     /**
     * Added filter sort by filter type.
     * 
     * 
     */
    public function allCurriculumFilterSortByDesc($filter_curriculum){
      if(request('filter_search') == 'name' ){
        $descData = collect($filter_curriculum)->sortByDesc(function ($curriculum_value, $key) {
           return $curriculum_value['discipline_name'];
        });
      } else if(request('filter_search') == 'language'){
        $descData = collect($filter_curriculum)->sortByDesc(function ($curriculum_value, $key) {
          return $curriculum_value['language']['language'];
        });
      } else if(request('filter_search') == 'number_of_exercise_set'){ 
        $descData = collect($filter_curriculum)->sortByDesc(function ($curriculum_value, $key) {
          return $curriculum_value->exercisesets_count;
        });
      } else if(request('filter_search') == 'number_of_classes'){ 
        $descData = collect($filter_curriculum)->sortByDesc(function ($curriculum_value, $key) {
          return $curriculum_value->courseclasses_count;
        });
      } else {
        $descData = $filter_curriculum;
      }

      return $descData;
    }

     /**
     * Added filter sort by filter type.
     * 
     * 
     */
    public function allCurriculumFilterSortByAsc($filter_curriculum){

      if(request('filter_search') == 'name' ){
        $ascData = collect($filter_curriculum)->sortBy(function ($curriculum_value, $key) {
          return $curriculum_value['discipline_name'];
        });
      } else if(request('filter_search') == 'language'){
        $ascData = collect($filter_curriculum)->sortBy(function ($curriculum_value, $key) {
          return $curriculum_value['language']['language'];
        });
      } else if(request('filter_search') == 'number_of_exercise_set'){
        $ascData = collect($filter_curriculum)->sortBy(function ($curriculum_value, $key) {
          return $curriculum_value->exercisesets_count;
        });
      } else if(request('filter_search') == 'number_of_classes'){ 
        $ascData = collect($filter_curriculum)->sortBy(function ($curriculum_value, $key) {
          return $curriculum_value->courseclasses_count;
        });
      } else {
        $ascData = $filter_curriculum;
      }
      return $ascData;
    }

    /**
     * Select curriculum filter data.
     *
     * return void
     */
    public function curriculumFilterData(){

        $disciplines = Discipline::with(['courseclasses','exercisesets','languagePreference'])->where('publish_status', 'like', 'published');

        if(!empty(request('topic_id'))){
            $disciplines->where('topic_id','=',request('topic_id'));
        }

        //Fetch Data by Topic name.
        if(request('Disicipline_search') != ''){
            $disciplines->whereHas('topics',function($topic){
                if(request('Topic_operator') === 'like'){
                    $topic->where('topic_name','like','%'.request('Disicipline_search').'%');
                } else {
                    $topic->where('topic_name','=',request('Disicipline_search'));
                }
                });
            } else {
            $disciplines->with('topics');
        }


        //Fetch data by discipline's name.
        if(!empty(request('Name_search'))){
            if(request('Name_operator') === 'like'){
                $disciplines->where('discipline_name','like','%'.request('Name_search').'%');
            } else {
                $disciplines->where('discipline_name',request('Name_operator'),request('Name_search'));
            }
        }

        //Fetch data by Language's name.
        if(!empty(request('Language_search'))){           
           $disciplines->where('language_preference_id','=',request('Language_search'));    
        }
       
        
        $disciplines->withCount('exercisesets');
        $disciplines->withCount('courseclasses');

        //Filter by Exercisesets count.
        if(request('Exercisesets_search') != ''){
          $disciplines->having('exercisesets_count',request('Exercisesets_operator'),request('Exercisesets_search'));
        }
        
        //Filter by Classes count.
        if(request('Classes_search') != ''){
            $disciplines->having('courseclasses_count',request('Classes_operator'),request('Classes_search'));
        }

        return $disciplines->get();
    }
    
    
    /**
     * Selected grade update on exercisesets. 
     *
     * Develop By WC.
     * return void
     */
    public function selectGradeWithCurriculum(){
        try {
            $exerciseset = Exerciseset::findOrFail(request('exercise_id'));
            $data = ['discipline_id' => request('discipline_id'),'grade_id' => request('grade_id') ];       
            $exerciseset = Exerciseset::where('id',request('exercise_id'))->update($data);
            
          
            if(request('type') === 'Edit'){
                $msg = Lang::get('controller.exerciseset_update_msg');
            } else {
                $msg = Lang::get('controller.exerciseset_add_msg');
            }
            return redirect()->route('exercisesets.exerciseset.show',['id' => request('exercise_id') ,'ispublic'=>request('ispublic')])
                ->with('success_message', $msg);

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => Lang::get('controller.unexpected_error')]);
        }
    }

    public function savetext(Request $request)
    {
        try {

            $data = $this->getData($request);
            $pid=Exerciseset::create($data);
            $id=$pid->id;
            $ispublic=0;
            return redirect()->route('exercisesets.exerciseset.show',compact('id' ,'ispublic'))
                ->with('success_message', Lang::get('controller.exerciseset_add_msg'));

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => Lang::get('controller.exerciseset_add_msg')]);
        }
    }
    /**
     * Update the specified exerciseset in the storage.
     */
    public function update($id, ExercisesetRequest $request)
    {
        try {
            $exerciseset = Exerciseset::findOrFail($id);
            if($exerciseset->topic_id != $request->topic_id){
                $exerciseset = Exerciseset::findOrFail($id);
                $exerciseset->discipline_id = NULL;
                $exerciseset->grade_id = NULL;
                $exerciseset->save();
            }

            //Tags explorer.
            if($request->has('tags') && !is_null($request->tags)){
                $exerciseset->tag(explode(',', $request->tags));
            }
            //Image upload.
            if ($request->hasFile('exerciseset-image')) {
                $image = $request->file('exerciseset-image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $name = $image->getClientOriginalName();
                $destinationPath = public_path('/uploads/exercisesets');
                $image->move($destinationPath, $name);
                request()->request->add(['exerciseset_image' => $name]);
            }
            
            $exerciseset->fill(request()->all());

            if($exerciseset['publish_status'] == 'public'){
                if (Auth::user()->hasRole('Teacher') > 0) {
                    $this->add_xp_point (Auth::user ()->id, 'publishtopubliclibrary','Teacher');
                }
            }
            $exerciseset->save();
            
            
            
            // $data = $request->all();
            // $exerciseset->update($data);

            $language_id = $exerciseset->language_id;
            $ispublic=0;
            $topicId = request('topic_id');
            $type = 'Edit';
            
            // return redirect()->route('exercisesets.exerciseset.show',compact('id' ,'ispublic'))
            //                  ->with('success_message', 'Exerciseset was successfully updated!');
            return redirect()->route('exercisesets.exerciseset.select-curriculum',compact('id' ,'ispublic', 'topicId','type','language_id'))
            ->with('success_message',  Lang::get('controller.exerciseset_update_msg'));
            
        } catch (Exception $exception) {
            
            return back()->withInput()
            ->withErrors(['unexpected_error' =>  Lang::get('controller.unexpected_error')]);
        }        
    }
    
    public function ownerDestroy($id){
        try {
            $exerciseset = Exerciseset::findOrFail($id);
            //Check exercise in class.
            $classExercise = Classexercise::where('exercise_id','=',$exerciseset->id)->get();
            if(!empty($classExercise)){
                // Check exercise using in exam.
                $examexercisesets=ExamExercises::where('exerciseset_id','=',$id)->get();
                if(!empty($examexercisesets)){
                    //check exercise have question or not.
                    if(count($exerciseset->question) > 0){
                        return redirect()->route('exercisesets.exerciseset.private')
                        ->with(['error_message' => Lang::get('controller.not_able_to_delete')]);
                    } else {
                        $exerciseset->delete();
                        return redirect()->route('exercisesets.exerciseset.private')
                            ->with('success_message', Lang::get('controller.exerciseset_delete_msg'));
                    }
                
                } else {
                    return redirect()->route('exercisesets.exerciseset.private')
                    ->with(['error_message' => Lang::get('controller.used_in_exercise')]);
                }
            } else {
                return redirect()->route('exercisesets.exerciseset.private')
                ->with(['error_message' => Lang::get('controller.first_delete_from_class')]);
            }
            
        } catch (Exception $exception) {
            
            return redirect()->route('exercisesets.exerciseset.private')
            ->with(['error_message' => Lang::get('controller.unexpected_error')]);
        }

    }
    
    /**
     * Remove the specified exerciseset from the storage.
     */
    public function destroy($id)
    {
        try {
            $exerciseset = Exerciseset::findOrFail($id);
            $exerciseset->delete();
            
            return redirect()->route('exercisesets.exerciseset.index')
            ->with('success_message', Lang::get('controller.exerciseset_delete_msg'));
            
        } catch (Exception $exception) {
            
            return back()->withInput()
            ->withErrors(['unexpected_error' => Lang::get('controller.unexpected_error')]);
        }
    }
    
    public function addtomylibrary ($id){
        
        try {
            $this->middleware ('auth');
            $exercisesetbuyers = New Exercisesetbuyer;
            $exercisesetbuyers->user_id = Auth::user ()->id;
            $exercisesetbuyers->exerciseset_id = $id;
            $exercisesetbuyers->save ();

            $task= Pendingtask::where('user_id','=',Auth::user ()->id)
                    ->where ('pending_task_description','=','Create or buy an exercise set')
                    ->first();
            if ($task)
            {
                $task->status='done';
                $task->save();
            }

            Storage::disk ('local')->append ('addddddd.txt', 'done');
            return "done";
        }catch (Exception $exception) {
            Storage::disk ('local')->append ('addddddd.txt', $exception);
            return $exception;
        }
    }
    
    public function removefrommylibrary($id)
    {
        try {

            $this->middleware('auth');
            $exercisesetBuyer = Exercisesetbuyer::where('exerciseset_id' , $id )->where('user_id' , Auth::user()->id );
            $exercisesetBuyer->delete();

            return back();

        }
        catch (Exception $exception) {

            return back();

        }
    }

    public function getgrades ($discipline_id,$language_id){
        if ($discipline_id == 0) {
            $grade = array();
        } else {
            $discipline=Discipline::findorfail($discipline_id);
            //$grade=$discipline->curriculum_gradelist->grades;
            $grade = Grade::with('curriculum_gradelist.disciplines')
            ->whereHas('curriculum_gradelist.disciplines',function($q) use ($discipline_id){
                $q->where('id',$discipline_id);
            })
            ->withcount(['exerciseset'=>function($q) use ($discipline_id,$language_id){
                $q->where(['discipline_id'=>$discipline_id,'language_id' => $language_id]);
            }])
            ->having('exerciseset_count','>',0)
            ->get();
        }
        
        return Response($grade);
    }

    // Class dropdown
    public function getClassgrades ($discipline_id){
        $discipline=Discipline::findorfail($discipline_id);
        $grade=$discipline->curriculum_gradelist->grades;
        return Response($grade);
    }

    /**
     * 
     * This function in return disciplies list by laungauge id.
     * 
     */
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

    public function show1 ($discipline_id){

        $discipline=Discipline::findorfail($discipline_id);
        dd($discipline);

        return "0";
    }

    /**
     * Get the temp folder in uploaded image file by question in ajax call.
     */
    public function getQuestionImageUpload(){
        
        $image = request('image');

        dd($image);

    }
    
    
    /**
     * Get the request's data from the request.
     */
    protected function getData(Request $request)
    {
        $rules = [
            'title' => 'required|string|min:1|max:250',
            'discipline_id' => 'nullable',
            'grade_id' => 'nullable',
            'skill_category_id' => 'nullable',
            'language_id' => 'required|numeric|min:0|max:4294967295',
            'description' => 'required',
            'publish_status' => 'nullable',
            'createdby' => 'required|numeric|min: 0|max:2147483647',
            'price'=>'nullable|numeric|min: 0|max:2147483647',
            
        ];
        
        $data = $request->validate($rules);
        return $data;
    }

    /**
     * 
     * Question copy from other exersice
     * 
     * 
     */
     public function QuestionsCopy(Request $request){

        $exercise = $request->select_exercisesets;

        $questionIds = explode(",",$request->copyQuestionIds);

        $questions = Question::whereIn('id', $questionIds)->get();

        $questionData = [];
        foreach($questions as $question){
            $question->exercise_id = $exercise;
            array_push($questionData,$question);
        }

        foreach($questionData as $questionUpdate){
            $questionCreated = Question::create($questionUpdate->toArray());
            //update question json with answare store.
            $this->copyQuestionJsonUpdate($questionCreated->id);
        }

        return redirect()->route('exercisesets.exerciseset.show',['id' => $exercise,'ispublic'=> 1,'#detail'])
            ->with('success_message',  Lang::get('controller.copy_message'));

     }

     /**
      * This method using for already question added and live server. client help. 
      *
      */
     public function checkAndUpdateQuestionJSON(){
        $questions = Question::get();

        foreach($questions as $qkey => $question){
            $questionArray = json_decode($question['json_details'],TRUE);

            if($question->id != $questionArray['Questions'][0]['question_id']){
                echo "<pre> Belove question not match, This question's updating..";
                echo "<br/> Primary id : ";
                print_r($question->id);
                echo "<br/> Json Id : ";
                print_r($questionArray['Questions'][0]['question_id']);
                echo "</pre>";
                //update question json with answare store.
                $updated = $this->copyQuestionJsonUpdate($question->id);
                echo $updated;
                echo "</br></br>";
            } else {

                echo "<pre> Belove question in JSON question_id and question table primary id same no need to update.";
                echo "<br/> Primary id : ";
                print_r($question->id);
                echo "<br/> Json Id : ";
                print_r($questionArray['Questions'][0]['question_id']);
                echo "</pre></br></br>";
            }
                
            
        }

     }
     /**
      *
      * Update question after moving.
      *
      */
     public function copyQuestionJsonUpdate($questionId){

        $newQuestionData = Question::where('id','=',$questionId)->first();

        $questionArray = json_decode($newQuestionData['json_details'],TRUE);


        //This each use for mulitple question add.
        foreach($questionArray['Questions'] as $qkey => $questions){
            //Question Id Append with attribute.
            $questionArray['Questions'][$qkey]['question_id'] = $questionId;
           
            //Answer
            foreach($questions['Answers']['Choices'] as $chkey =>$choices){
                //Answer Section each.

                // //Make array for using answer store.
                $anstype = head($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']);
                $details = head($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']);
                $correct = $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Attributes']['IsCorrect'] == 1 ? 1 : 0;
                $answerJson = json_encode(head($questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Sections']));
                // //Call answer store method.
                $ansId = $this->answerStore($questionId,$anstype,$details,$answerJson,$correct,($chkey + 1));
                //Append answer id in question json for using practies.
                $questionArray['Questions'][$qkey]['Answers']['Choices'][$chkey]['Attributes']['id'] = $ansId;
            }
        }
        //Make Question Array to final json.
        $question_json = json_encode($questionArray, TRUE);
        
        Question::where('id','=', $questionId)->update([
            'json_details' => $question_json
        ]);

        return $questionId . " Updated successfully.";
     }

    /**
     * 
     * Question move from other exersice
     * 
     * 
     */
    public function QuestionsMove(Request $request){

        $exercise = $request->select_exercisesets;

        $questionIds = explode(",",$request->moveQuestionIds);

        $data = Question::whereIn('id', $questionIds)->update(['exercise_id' =>  $exercise]);

        return redirect()->route('exercisesets.exerciseset.show',['id' => $exercise,'ispublic'=> 1,'#detail'])
            ->with('success_message',  Lang::get('controller.move_message'));

     }

     /**
      * 
      * Admin exercise list
      */
     public function getAdminExerciseList(){
        
        $exercisesets = Exerciseset::with('discipline','grade','language')->paginate(25);
        return view('admin.exercisesets.index')->with(['exercisesets' => $exercisesets]);
     }

      /**
      * 
      * Admin exercise create
      */
      public function getAdminExerciseCreate(){
        $topics = Topic::where('approve_status','approved')->orderBy('topic_name','ASC')->get();
        $languages = Language::orderBy('language', 'asc')->get();
        $disciplines = Discipline::orderBy('discipline_name', 'asc')->get();
        $grades = Grade::orderBy('grade_name', 'asc')->get();
        $users = User::orderBy('name','ASC')->get();
        return view('admin.exercisesets.create',compact('topics','languages','disciplines','grades','users'));
     }

      /**
      * 
      * Admin exercise store
      */
      public function getAdminExerciseStore(ExercisesetRequest $request){
        
        $data = $request->all();
          if ($request->hasFile('exerciseset-image')) {
              $image = $request->file('exerciseset-image');
              $name = time().'.'.$image->getClientOriginalExtension();
              $name = $image->getClientOriginalName();
              $destinationPath = public_path('/uploads/exercisesets');
              $image->move($destinationPath, $name);
              $data['exerciseset_image'] = $name;
          }

        $pid=Exerciseset::create($data);
        $this->add_xp_point ($request->createdby, 'createexerciseset');

        //Tags explorer.
        if($request->has('tags') && !is_null($request->tags)){
            $pid->tag(explode(',', $request->tags));
        }

        $id=$pid->id;
        $language_id = $pid->language_id;
        $topicId = request('topic_id');

        event(new ExerciseSetCreated($pid));

        return redirect ()->route ('admin.exercise.index')
        ->with ('success_message', 'Exercise was successfully added!');  
     }


      /**
      * 
      * Admin exercise show
      */
      public function getAdminExerciseShow($id){
        $exerciseset = Exerciseset::findorfail($id);
        return view('admin.exercisesets.show',compact('exerciseset'));
     }

      /**
      * 
      * Admin exercise edit
      */
      public function getAdminExerciseEdit($id){
        $exercise = Exerciseset::findorfail($id);
        $topics = Topic::where('approve_status','approved')->orderBy('topic_name','ASC')->get();
        $languages = Language::orderBy('language', 'asc')->get();
        $disciplines = Discipline::orderBy('discipline_name', 'asc')->get();
        $grades = Grade::orderBy('grade_name', 'asc')->get();
        $users = User::orderBy('name','ASC')->get();
        return view('admin.exercisesets.edit',compact('exercise','topics','languages','disciplines','grades','users'));
     }

      /**
      * 
      * Admin exercise update
      */
      public function getAdminExerciseUpdate(Request $request,$id){

            $exerciseset = Exerciseset::findOrFail($id);
           
            //Tags explorer.
            if($request->has('tags') && !is_null($request->tags)){
                $exerciseset->tag(explode(',', $request->tags));
            }
            //Image upload.
            if ($request->hasFile('exerciseset-image')) {
                $image = $request->file('exerciseset-image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $name = $image->getClientOriginalName();
                $destinationPath = public_path('/uploads/exercisesets');
                $image->move($destinationPath, $name);
                request()->request->add(['exerciseset_image' => $name]);
            }
            
            $exerciseset->fill(request()->all());
            $exerciseset->save();
        
        return redirect ()->route ('admin.exercise.index')
        ->with ('success_message', 'Exercise was successfully updated!');  
     }

     /**
      * 
      * Admin exercise delete
      */
      public function getAdminExerciseDestroy($id){
        
        $exerciseset = Exerciseset::findOrFail($id);
        //Check exercise in class.
        $classExercise = Classexercise::where('exercise_id','=',$exerciseset->id)->get();
        if(!empty($classExercise)){
            //Check exercise using in exam.
            $examexercisesets=ExamExercises::where('exerciseset_id','=',$id)->get();
            if(!empty($examexercisesets)){
                //check exercise have question or not.
                if(count($exerciseset->question) > 0){
                    return redirect()->route('admin.exercise.index')
                    ->with(['error_message' => Lang::get('controller.not_able_to_delete')]);
                } else {
                    $exerciseset->delete();
                    return redirect()->route('admin.exercise.index')
                        ->with('success_message', Lang::get('controller.exerciseset_delete_msg'));
                }
            
            } else {
                return redirect()->route('admin.exercise.index')
                ->with(['error_message' => Lang::get('controller.used_in_exercise')]);
            }
        } else {
            return redirect()->route('admin.exercise.index')
            ->with(['error_message' => Lang::get('controller.first_delete_from_class')]);
        }

      }

      /**
       * validation for admin exercise data.
       * 
       */
      public function exerciseData(Request $request,$mode){
        $maxAge = request('minimum_age') + 1;
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'description' => 'required',
            'description' => 'required',
            'description' => 'required',
            'description' => 'required',
            'description' => 'required',
            'description' => 'required',
        ];

        if($mode == 'create') {
          $rules['image'] = 'required';
        }

        $data = $request->validate($rules);
        return $data;
      }
}
