<?php
namespace App\Http\Controllers;
use App\Models\Language;
use App\Models\Curriculum;
use App\Models\Discipline;
use App\Models\Exerciseset;
use App\Models\Country;
use App\Models\Courseclass;
use App\Models\Skill;
use App\Models\Skillcategory;
use App\Models\GoogleClassroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Topic;
use App\Http\Traits\AddXppoint;

// use Exception;
class ExploreController extends Controller {

    /**
     * Display a listing of the exercisesets in the Public Library.
     *
     * Modify by WC.
     * return void
     */
    use AddXppoint;
    public function exploreexerciseset() {
        $paginationcount = 12;
        $filter_exercisesets = $this->getPublicLibraryFilteredData($paginationcount);
        if (request('class_id')) {
            $class_id = request('class_id');
        } else {
            $class_id = null;
        }
        $ispublic = 1;
        if (request()->ajax()) {
            if (!empty(request('Rating_search'))) {
                $exercisesets_collection = $filter_exercisesets->filter(function ($exercise_value, $key) {
                    //Filter by Rating count.
                    if (!empty(request('Rating_search'))) {
                        if (request('Rating_search') === $exercise_value->averageRating(1) [0]) {
                            return $exercise_value->averageRating(1) [0] == request('Rating_search');
                        }
                    }
                });
                //Repagination by custom pagination
                $exercisesets = $this->paginate($exercisesets_collection, $paginationcount);
              } else {
                // $exercisesets = $filter_exercisesets;
                if(request('SortBy_search') === 'Descending'){
                  $sortByData = $this->allFilterSortByDesc($filter_exercisesets);
                } else {
                  $sortByData = $this->allFilterSortByAsc($filter_exercisesets);
                }

                $exercisesets = $this->paginate($sortByData, $paginationcount);
              }

              
            return view('eduplaycloud.explore.public_library.index', compact('exercisesets', 'ispublic', 'class_id'))->render();
        }

        $languages = Language::orderBy('language', 'asc')->get();
        // return view('exercisesets.index', compact('exercisesets'));
        return view('exercisesets.index', compact('class_id','languages'));
    }

     /**
     * Added filter sort by filter type.
     * 
     * 
     */
    public function allFilterSortByDesc($filter_exercises){
      if(request('filter_search') === 'curriculum' ){
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
           return $exercise_value->discipline['discipline_name'];
        });
      } else if(request('filter_search') === 'language'){
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
          return $exercise_value->language['language'];
        });
      } else if(request('filter_search') === 'topic'){
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
          return $exercise_value->topics['topic_name'];
        });
      } else if(request('filter_search') === 'grade'){
        $descData = collect($filter_exercises)->sortByDesc(function ($exercise_value, $key) {
          return $exercise_value->grade['grade_name'];
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
            return $exercise_value->discipline['discipline_name'];
        });
      } else if(request('filter_search') === 'language'){
        $ascData = collect($filter_exercises)->sortBy(function ($exercise_value, $key) {
          return $exercise_value->language['language'];
        });
      } else if(request('filter_search') === 'topic'){
        $ascData = collect($filter_exercises)->sortBy(function ($exercise_value, $key) {
          return $exercise_value->topics['topic_name'];
        });
      } else if(request('filter_search') === 'grade'){
        $ascData = collect($filter_exercises)->sortBy(function ($exercise_value, $key) {
          return $exercise_value->grade['grade_name'];
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

    /*
     * 
     *Get Exercisesets from curriculumn list. 
     * 
     * 
     */
    public function curriculumnExerciseset(){
      
        if (request('class_id')) {
            $class_id = request('class_id');
        } else {
            $class_id = null;
        }

        
        return view('exercisesets.index', compact('class_id'));

    }

    /**
     * Get public library data with filter.
     *
     * param [integer] $paginationcount
     * return void
     */
    public function getPublicLibraryFilteredData($paginationcount) {
        $exerciseset = Exerciseset::where([['publish_status', 'like', 'public']]);

        if(Auth::user()){
            $exerciseset->where('createdby', '!=', \Auth::user()->id);
        }

        //Fetch data by exerciseset's title.
        if (!empty(request('Title_search'))) {
            if (request('Title_operator') === 'like') {
                $exerciseset->where('title', 'like', '%' . request('Title_search') . '%');
            } else {
                $exerciseset->where('title', request('Title_operator'), request('Title_search'));
            }
        }
        //Fetch data by Curriculum redirection.
        if(request()->has('discipline_id')){
            $exerciseset->where('discipline_id','=',request('discipline_id'))
                        // ->where('language_id','=',request('language_id'))
                        ->where('topic_id','=',request('topic_id'));
        }

        //Fetch Data by created date.
        if (!empty(request('start_date'))) {
            $startDate = Carbon::parse(request('start_date'))->format('Y-m-d') . " 00:00:00";
            $endDate = Carbon::parse(request('end_date'))->format('Y-m-d') . " 23:59:59";
            $exerciseset->whereBetween('created_at', [$startDate, $endDate]);
        }
        //Sorting Data by order.
        if (!empty(request('Sort_search')) && request('Sort_search') === 'Descending') {
            $exerciseset->orderBy('title', 'desc');
        } else {
            $exerciseset->orderBy('title', 'asc');
        }
        //Fetch Data by Disicipline name.
        if (!empty(request('Curriculum_search'))) {
            if (request('Curriculum_search') === 'N/A') {
                $exerciseset->where('discipline_id', '=', NULL);
            } else {
                $exerciseset->whereHas('discipline', function ($discipline) {
                    if (request('Curriculum_operator') === 'like') {
                        $discipline->where('discipline_name', 'like', '%' . request('Curriculum_search') . '%');
                    } else {
                        $discipline->where('discipline_name', '=', request('Curriculum_search'));
                    }
                });
            }
        } else {
                $exerciseset->with('discipline');
        }
        //Fetch Data by Topic name.
        if (!empty(request('Disicipline_search'))) {
            $exerciseset->whereHas('topics', function ($topic) {
                if (request('Disicipline_operator') === 'like') {
                    $topic->where('topic_name', 'like', '%' . request('Disicipline_search') . '%');
                } else {
                    $topic->where('topic_name', '=', request('Disicipline_search'));
                }
            });
        } else {
            $exerciseset->with('topics');
        }
        //Fetch Data by Grade name.
        if (!empty(request('Grade_search'))) {
            if (request('Grade_search') === 'N/A') {
                $exerciseset->where('grade_id', '=', NULL);
            } else {
                $exerciseset->whereHas('grade', function ($grade) {
                    if (request('Grade_operator') === 'like') {
                        $grade->where('grade_name', 'like', '%' . request('Grade_search') . '%');
                    } else {
                        $grade->where('grade_name', '=', request('Grade_search'));
                    }
                });
            }
        } else {
            $exerciseset->with('grade');
        }
        //Fetch Data by Teacher name.
        if (!empty(request('Teacher_search'))) {
            $exerciseset->whereHas('owner', function ($teacher) {
                if (request('Teacher_operator') === 'like') {
                    $teacher->where('name', 'like', '%' . request('Teacher_search') . '%');
                } else {
                    $teacher->where('name', '=', request('Teacher_search'));
                }
            });
        } else {
            $exerciseset->with('owner');
        }

        // Fetch data by Language search.
        if (!empty(request('Language_search'))) {
            $exerciseset->whereHas('language', function ($language) {
                $language->where('id', request('Language_search'));
            });
        } else {
          $exerciseset->with(['language']);
        }

        if(Auth::user()){
            $exerciseset->with(['buyers' => function ($query) {
                $query->where('user_id', \Auth::user()->id);
                }
            ]);
        }

        $exerciseset->withCount('question');

        if(request('Question_search') != ''){
            $exerciseset->has('question', request('Question_operator'), request('Question_search'));
        }
        
        $exerciseset->withCount('buyers');
        
        if( request('Buyer_search') != ''){
            $exerciseset->has('buyers', request('Buyer_operator'), request('Buyer_search'));
        }

        return $exerciseset->get();
        return $exerciseset->paginate($paginationcount);
    }

    /**
     * Explore discipline
     *
     * return Illuminate\View\View
     */
    public function explorediscipline() {
        if (isset($_GET['searchkey'])) {
            $name = $_GET['searchkey'];
        } else {
            $name = '';
        }
        $disciplines = Discipline::with('curriculum_gradelist', 'languagePreference')->where([['discipline_name', 'like', '%' . $name . '%'], ['publish_status', 'like', 'published']])->orwhere([['description', 'like', '%' . $name . '%'], ['publish_status', 'like', 'published']])->orderBy('discipline_name', 'ASC')->paginate(25);
        $languages = Language::orderBy('language', 'asc')->get();
        return view('disciplines.index', compact('disciplines', 'languages'));
    }
    /**
     * Explore discipline filter.
     *
     * return Illuminate\View\View
     */
    public function exploreDisciplineFilter() {
        $filter_disciplines = app('App\Http\Controllers\Exercises\ExercisesetsController')->curriculumFilterData();

        
        if(request('SortBy_search') == 'Descending'){
          $disciplines = app('App\Http\Controllers\Exercises\ExercisesetsController')->allCurriculumFilterSortByDesc($filter_disciplines);
        } else {
          $disciplines = app('App\Http\Controllers\Exercises\ExercisesetsController')->allCurriculumFilterSortByAsc($filter_disciplines);
        }

        return view('disciplines.oneelement', compact('disciplines'))->render();
    }


  

    /**
     * Explore classes 
     *
     * param Request $request
     * return void
     */
    public function exploreclasses(Request $request) {
        if ($request->ajax()) {
            $paginationcount = 9;
            if(Auth::user()){
              $modelQuery = Courseclass::where('isavailable', '=', 'Y')->where('teacher_userid', '!=', auth()->id());
            } else {
              $modelQuery = Courseclass::where('isavailable', '=', 'Y');
            }

            $courseclasses_collection = $this->fetchCourseClassesFilteredData($modelQuery, $paginationcount);

            if(request('SortBy_search') === 'Descending'){
              $courseclasses_collection = $this->allClassFilterSortByDesc($courseclasses_collection);
            } else if(request('SortBy_search') === 'Ascending') {
              $courseclasses_collection = $this->allClassFilterSortByAsc($courseclasses_collection);
            } else {
              $courseclasses = $courseclasses_collection;
            }
            
            $courseclasses = $this->paginate($courseclasses_collection, $paginationcount);

            // if(request('SortBy_search') === 'Descending'){
            //   $sortByData = $this->allClassFilterSortByDesc($courseclasses);
            // } else {
            //   $sortByData = $this->allClassFilterSortByAsc($courseclasses);
            // }

            // $courseclasses = $this->paginate($sortByData, $paginationcount);
            //This is for ajax call on filter.
            return view('courseclasses.classes', compact('courseclasses'))->render();
        }

        $languages = Language::orderBy('language', 'asc')->get();
        return view('courseclasses.index',compact('languages'));
    }

    /**
     * Added filter sort by filter type.
     * 
     * 
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
     * 
     * 
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
     * 
     */
    public function curriculumnClasses(){
        
        return view('courseclasses.index');
    }

    /**
     * Fetch filter from database classes filter data.
     *
     * Develop by WC.
     *
     * param Object $courseclasses
     * param int $paginationcount
     * return Response
     */
    public function fetchCourseClassesFilteredData($courseclasses, $paginationcount) {
        //Fetch data by Curriculum redirection.
        if(request()->has('discipline_id')){
             $courseclasses->where('discipline_id','=',request('discipline_id'));
        }
        
        //Fetch data by Course ID
        if(request('CoursID_search') != ''){
            $courseclasses->where('id', '=', request('CoursID_search'));
        }

        //Fetch data by class's title.
        if (!empty(request('Title_search'))) {
            if (request('Title_operator') === 'like') {
                $courseclasses->where('class_name', 'like', '%' . request('Title_search') . '%');
            } else {
                $courseclasses->where('class_name', request('Title_operator'), request('Title_search'));
            }
        }

        //Fetch Data by created date.
        if (!empty(request('start_date'))) {
            $startDate = Carbon::parse(request('start_date'))->format('Y-m-d') . " 00:00:00";
            $endDate = Carbon::parse(request('end_date'))->format('Y-m-d') . " 23:59:59";
            $courseclasses->whereBetween('created_at', [$startDate, $endDate]);
        }
        //Sorting Data by order.
        if (!empty(request('Sort_search')) && request('Sort_search') === 'Descending') {
            $courseclasses->orderBy('class_name', 'desc');
        } else {
            $courseclasses->orderBy('class_name', 'asc');
        }
        //Fetch Data by Teacher's name.
        if (!empty(request('Teacher_search'))) {
            $courseclasses->whereHas('teacher', function ($teacher) {
                if (request('Teacher_operator') === 'like') {
                    $teacher->where('name', 'like', '%' . request('Teacher_search') . '%');
                } else {
                    $teacher->where('name', '=', request('Teacher_search'));
                }
            });
        } else {
            $courseclasses->with('teacher');
        }
        //Fetch Data by Disicipline name.
        if (!empty(request('Curriculum_search'))) {
            $courseclasses->whereHas('discipline', function ($discipline) {
                if (request('Curriculum_operator') === 'like') {
                    $discipline->where('discipline_name', 'like', '%' . request('Curriculum_search') . '%');
                } else {
                    $discipline->where('discipline_name', '=', request('Curriculum_search'));
                }
            });
        } else {
            $courseclasses->with('discipline');
        }
        //Fetch Data by Grade name.
        if (!empty(request('Grade_search'))) {
            $courseclasses->whereHas('grade', function ($grade) {
                if (request('Grade_operator') === 'like') {
                    $grade->where('grade_name', 'like', '%' . request('Grade_search') . '%');
                } else {
                    $grade->where('grade_name', '=', request('Grade_search'));
                }
            });
        } else {
            $courseclasses->with('grade');
        }
        //Fetch Data by Topic name.
        if (request('Disicipline_search') != '') {
            $courseclasses->whereHas('discipline', function ($discipline) {
                $discipline->whereHas('topics', function ($topics) {
                    if (request('Disicipline_operator') === 'like') {
                        $topics->where('topic_name', 'like', '%' . request('Disicipline_search') . '%');
                    } else {
                        $topics->where('topic_name', '=', request('Disicipline_search'));
                    }
                });
            });
        }
        $courseclasses->withCount('learners');
        //Filter by Learner count
        if (request('Learner_search') != '') {
            $courseclasses->has('learners', request('Learner_operator'), request('Learner_search'));
        }


        // Fetch data by Language search.
        if (!empty(request('Language_search'))) {           
          $courseclasses->whereHas('language', function ($language) {
              $language->where('id', request('Language_search'));
          });
        } else {
          $courseclasses->with(['language']);
        }
        // dd($courseclasses->toSql());
        return $courseclasses->get();
        return $courseclasses->paginate($paginationcount);
    }

    /**
     *
     *
     * Cretae Curriculum details.
     *
     * return Illuminate\View\View
     *
     */
    public function createCurriculumDetails() {
        $languages = Language::orderBy('language', 'asc')->get();
        $disciplines = app('App\Http\Controllers\Exercises\ExercisesetsController')->curriculumFilterData();
        //Ajax call from fileter.
        if (request()->ajax()) {
            return view('disciplines.create-filter-curriculum', compact('languages', 'disciplines'))->render();
        }
        $topics = Topic::where('approve_status', 'approved')->orderBy('topic_name', 'asc')->get();
        return view('disciplines.create-curriculum', compact('languages', 'disciplines', 'topics'));
    }

    /**
     *
     * Store curriculum details.
     *
     * param Illuminate\Http\Request $request
     * return Response
     */
    public function storeCurriculumDetails(Request $request) {
        if (Auth::user()->hasRole('Teacher')) {
            $this->add_xp_point (Auth::user ()->id, 'createcurriculum','Teacher');
        }
        $discipline = ['discipline_name' => $request->discipline_name, 'description' => $request->description, 'topic_id' => $request->topic_id, 'language_preference_id' => $request->language_preference_id, ];
        Discipline::insert($discipline);
        return 'success';
    }
    /**
     *
     * Get one Displine for cloning data.
     *
     * return Response
     */
    public function getExploreOneDiscipline() {
        $discipline = Discipline::with('topics', 'languagePreference')->findOrFail(request('discipline_id'));
        return $discipline;
    }
    
    /**
     * Developed By : WC
     * This function is used to show discpline summary page
     */
    public function disciplineSummary($discipline_id) {
        $discipline = Discipline::with('disciplinecollaborators','disciplineversions')->findorFail($discipline_id);
      
        return view('disciplines.summary',compact('discipline'));
    }

    /**
     * Developed By : WC
     * This function is used to show discipline latest published version page
     */
    public function latestPublished($discipline_id) {
        $discipline = $this->getDiscipline($discipline_id);
        return view('disciplines.published_version',compact('discipline'));
    }

    /**
     * Developed by : WC
     * This function is used to get discipline details
     */
    public function getDiscipline($id) {
        $discipline = Discipline::findorFail($id);
        return $discipline;

    }

    /**
     * Developed by : WC
     * This function is used to get latest draft details
     */
    public function latestDraft($discipline_id){
        $discipline = $this->getDiscipline($discipline_id);
        return view('disciplines.draft',compact('discipline'));
    }

    /**
     * Developed by : WC
     * This function is used to get latest draft skill wise
     */
    public function latestDraftSkillWise($discipline_id) {
        $discipline = $this->getDiscipline($discipline_id);
        return view('disciplines.draft_skill_wise',compact('discipline'));
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
        $audioPath= public_path('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/audio');
        $csvPath= public_path('assets/eduplaycloud/upload/exercisesset/user-'. Auth::user()->id.'/csv');
        
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

        $exercisesets = Exerciseset::where('id','!=',$id)->where('createdby', '=', Auth::user()->id)->get();

        return view('eduplaycloud.users.private-library.show', compact('exerciseset','exercisesets','questions' ,'ispublic', 'sectionType','skill_categories','images','audio','csvs','userrate'))->nest('nestquestion','questions/exercise_question', compact('questions' ,'passages','exerciseset'));
        // -----------------------------
    }

    /**
     * 
     * Curriculum's skill and skill-categories display.
     * 
     */
    public function getCurriculumSkillList($id){

        // $disciplines = Discipline::with(['skillcategories' => function($skill_categories){
        //         $skill_categories->with('skill');
        //     }])
        //     ->where([['id', '=', $id], ['publish_status', 'like', 'published']])
        //     ->orderBy('discipline_name', 'ASC')->first();

        $disciplines = Discipline::where([['id', '=', $id], ['publish_status', 'like', 'published']])
                                  ->with('curriculum_gradelist.grades.skillCategory.skill')->first()->toArray();

        $skill_category = Skillcategory::where('discipline_id','=', $id)
          ->where('approve_status','=','approved')->where('publish_status','=','published')
          ->with(['skill' => function($skill){
            $skill->where('approve_status','=','approved')->where('publish_status','=','published')->get();
          }])->get();

        // echo "<pre>";
        // print_r($skill_category->toArray());
        // echo "</pre>";
        // exit;

        return view('disciplines.skills-list')->with(['disciplines' => $disciplines,'skill_category' => $skill_category]);
    }

}
