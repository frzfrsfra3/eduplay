<?php
namespace App\Http\Controllers\Disciplines;
use App\Models\Topic;
use App\Models\Discipline;
use App\Models\Userinterest;
use App\Models\Grade;
use App\Models\Language;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Session;
use App\Models\Exerciseset;
use Illuminate\Support\Facades\Lang;
use function GuzzleHttp\json_encode;
use App\Models\Skill;
use App\Models\Skillcategory;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TopicsController extends Controller {

    public function __construct() {
        // Topics is the Disciplines View
        // If trying to access this controller without being authenticated, it will ask him for authentication
        // $this->middleware('auth');
        // $this->middleware ('auth');

    }

    /**
     * Display a listing of the topics.
     *
     * return Illuminate\View\View
     */
    public function index(Request $request) {
        if (!Auth::guest()):
            $authUserId = Auth::user()->id;
        else:
            $authUserId = 0;
        endif;
        $paginate = 25;
        $topicsData = $this->getTopicsByFilter($paginate);

        if(request('SortBy_search') === 'Descending'){
          $topicsData = $this->allTopicFilterSortByDesc($topicsData);
        } else if(request('SortBy_search') === 'Ascending') {
          $topicsData = $this->allTopicFilterSortByAsc($topicsData);
        } else {
        }

        $topics = $this->paginate($topicsData, 20);


        $grades = Grade::orderBy('id', 'asc')->get();
        $languages = Language::orderBy('language', 'asc')->get();
        $userinterest = Userinterest::where('topic_id', '=', 0)->where('user_id', '=', $authUserId)->first();
        $disciplines = Discipline::where('approve_status', '=', 'approved')->where('publish_status', '=', 'published')->get();
        $grade_id = 0;
        if ($userinterest) {
            if (($userinterest->discipline_id) != 0) {
                $discipline = Discipline::where('id', '=', $userinterest->discipline_id)->where('approve_status', '=', 'approved')->where('publish_status', '=', 'published')->first();
                $grades = Grade::where('curriculum_gradelist_id', '=', $discipline->curriculum_gradelist_id)->select('grade_name', 'id')->orderBy('id', 'asc')->get();
                $grade_id = $userinterest->grade_id;
            }
        }
        if ($request->ajax()) {
            // This is for ajax call on filter.
            return view('topics.onetopics', compact('topics'))->render();
        }
        return view('topics.index', compact('userinterest', 'disciplines', 'languages', 'grades', 'grade_id', 'topics'));
    }

     /**
     * Added filter sort by filter type.
     *
     *
     */
    public function allTopicFilterSortByDesc($filter_topic){
      if(request('filter_search') === 'language'){
        $descData = collect($filter_topic)->sortByDesc(function ($topic_value, $key) {
          return $topic_value['topic_name'];
        });
      } else if(request('filter_search') === 'number_of_exercise_set'){
        $descData = collect($filter_topic)->sortByDesc(function ($topic_value, $key) {
          return  count($topic_value['exercisesets']);
        });
      } else if(request('filter_search') === 'number_of_curriculum'){
        $descData = collect($filter_topic)->sortByDesc(function ($topic_value, $key) {
          return  count($topic_value['discipilnes']);
        });
      } else {
        $descData = $filter_topic;
      }
      return $descData;
    }

     /**
     * Added filter sort by filter type.
     *
     *
     */
    public function allTopicFilterSortByAsc($filter_topic){

      if(request('filter_search') === 'language'){
        // dd(request('filter_search'));
        $ascData = collect($filter_topic)->sortBy(function ($topic_value, $key) {
          return $topic_value['topic_name'];
        });
      } else if(request('filter_search') === 'number_of_exercise_set'){
        $ascData = collect($filter_topic)->sortBy(function ($topic_value, $key) {
          return  count($topic_value['exercisesets']);
        });
      } else if(request('filter_search') === 'number_of_curriculum'){
        $ascData = collect($filter_topic)->sortBy(function ($topic_value, $key) {
          return  count($topic_value['discipilnes']);
        });
      } else {
        $ascData = $filter_topic;
      }
      return $ascData;
    }

    /**
     * Get topic's with filtered data from database.
     *
     * Develop By WC.
     *
     * param int $paginate
     * return Response
    */
    public function getTopicsByFilter($paginate) {
        $topics = Topic::where('approve_status', '=', 'approved');
        // Fetch data by Topic's title.
        if (!empty(request('Title_search'))) {
            if (request('Title_operator') === 'like') {
                $topics->where('topic_name', 'like', '%' . request('Title_search') . '%');
            } else {
                $topics->where('topic_name', request('Title_operator'), request('Title_search'));
            }
        }

        $topics->withCount('discipilnes');
        //Filter by Curriculum count
        if (request('Curriculum_search') != '') {
            $topics->has('discipilnes', request('Curriculum_operator'), request('Curriculum_search'));
        }
        // Fetch data by Language search.
        if (!empty(request('Language_search'))) {
            /*$topics->withcount(['discipilnes' => function ($query) {
                $query->where('language_preference_id', request('Language_search'));
            }]);*/
            $topics->whereHas('discipilnes', function ($query) {
                $query->where('language_preference_id', request('Language_search'));
            });
        }

        $topics->withCount(['exercisesetsfilter']);

        //Filter by Exercisesets count
        if (request('Exercisesets_search') != '') {
            //$topics->has('exercisesets', request('Exercisesets_operator'), request('Exercisesets_search'));
            $topics->has('exercisesetsfilter', request('Exercisesets_operator'), request('Exercisesets_search'));
        }

        return $topics->get();
        return $topics->paginate($paginate);
    }

    /**
     * Show the form for creating a new topic.
     *
     * return Illuminate\View\View
     */
    public function create() {
        $disciplines = Discipline::pluck('discipline_name', 'id')->all();
        return view('topics.create', compact('disciplines'));
    }

    /**
     * Developed by : WC
     *
     * param Illuminate\Http\Request $request
     * return Illuminate\View\View
     */
    public function add(Request $request) {
        $newDesclipline = new Topic();
        $newDesclipline->topic_name = $request['name'];
        $newDesclipline->createdby = Auth::user()->id;
        if ($newDesclipline->save()) {
            return json_encode(array('status' => true));
        } else {
            return json_encode(array('status' => false));
        }
    }

    /**
     * Store a new topic in the storage.
     *
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        try {
            $data = $this->getData($request);
            Topic::create($data);
            return redirect()->route('topics.topic.index')->with('success_message', Lang::get('controller.topic_added_successfully'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => Lang::get('controller.unexpected_error') ]);
        }
    }

    /**
     * Display the specified topic.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function show($id) {
        $topic = Topic::with('discipline')->findOrFail($id);
        return view('topics.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified topic.
     *
     * param int $id
     *
     * return Illuminate\View\View
     */
    public function edit($id) {
        $topic = Topic::findOrFail($id);
        $disciplines = Discipline::pluck('discipline_name', 'id')->all();
        return view('topics.edit', compact('topic', 'disciplines'));
    }

    /**
     * Update the specified topic in the storage.
     *
     * param  int $id
     * param Illuminate\Http\Request $request
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request) {
        try {
            $data = $this->getData($request);
            $topic = Topic::findOrFail($id);
            $topic->update($data);
            return redirect()->route('topics.topic.index')->with('success_message', Lang::get('controller.topic_updated_successfully'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => Lang::get('controller.unexpected_error') ]);
        }
    }

    /**
     * Remove the specified topic from the storage.
     *
     * param  int $id
     *
     * return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        try {
            $topic = Topic::findOrFail($id);
            $topic->delete();
            return redirect()->route('topics.topic.index')->with('success_message', Lang::get('controller.topic_deleted_successfully'));
        }
        catch(Exception $exception) {
            return back()->withInput()->withErrors(['unexpected_error' => Lang::get('controller.unexpected_error') ]);
        }
    }

    /**
     * Get the request's data from the request.
     *
     * param Illuminate\Http\Request\Request $request
     * return array
     */
    protected function getData(Request $request) {
        $rules = ['topic_name' => 'required|string|min:1|max:250', 'discipline_id' => 'required', 'approve_status' => 'required', 'publish_status' => 'required', 'iconurl' => 'string', 'createdby' => 'required|numeric|min:-2147483648|max:2147483647', 'updatedby' => 'required|numeric|min:-2147483648|max:2147483647', ];
        $data = $request->validate($rules);
        return $data;
    }

    /**
     * View settings/preferences for the topics
     *
     * param Request $request
     * return void
     */
    public function viewSettings(Request $request) {
        if ($request->ajax()) {
            $topic_id = $request->topic_id;
            $topic_name = $request->topic_name;
            $userinterest = Userinterest::where('topic_id', '=', $request->topic_id);
            if (Auth::user()):
                $userinterest->where('user_id', '=', Auth::user()->id);
            endif;
            $userinterest = $userinterest->first();
            $disciplines = Discipline::where('topic_id', '=', $request->topic_id)->where('approve_status', '=', 'approved')->orderBy('discipline_name', 'asc')->get();

            if ($disciplines) {
                $grades = Grade::orderBy('id', 'asc')->get();
                $topicList=Topic::with(['exercisesets' => function ($query) use($topic_id) {
                    $query->Where('topic_id','=',$topic_id);
                    $query->Where('publish_status','!=','private');
                    if (Auth::user()) {
                        $query->Where('createdby', '!=', Auth::user()->id);
                    }
                    $query->with('language');
                }])->where('id',$topic_id)->first();
                //$topicList=Topic::with('exercisesets.language')->where('id',$topic_id)->first();
                $languages=[];
                foreach($topicList->exercisesets as $topic){
                    array_push($languages, $topic->language_id);
                }
                $languages=array_unique($languages);

                $languages = Language::whereIn('id',$languages)->orderBy('language', 'asc')->get();

                $grade_id = 0;
                if ($userinterest) {
                    if (($userinterest->discipline_id) != 0) {
                        $discipline = Discipline::where('id', '=', $userinterest->discipline_id)->first();
                        //$grades = Grade::where('curriculum_gradelist_id', '=', $discipline->curriculum_gradelist_id)->get();
                        $grade_id = $userinterest->grade_id;
                        $discipline_id = $userinterest->discipline_id;
                        $language_id = $userinterest->language_id;
                        $grades = Grade::with('curriculum_gradelist.disciplines')->whereHas('curriculum_gradelist.disciplines', function ($q) use ($discipline_id) {
                            $q->where('id', $discipline_id);
                        })->withcount(['exerciseset' => function ($q) use ($discipline_id, $language_id) {
                            $q->where('publish_status', '!=', 'private');
                            if (Auth::user()) {
                                $q->where('createdby', '!=', Auth::user()->id);
                            }
                            $q->where(['discipline_id' => $discipline_id, 'language_id' => $language_id]);
                        }
                        ])->having('exerciseset_count', '>', 0)->get();
                    }
                }
                return view('topics.auth-settings', compact('userinterest', 'disciplines', 'languages', 'grades', 'grade_id', 'topic_id', 'topic_name'));
            } else {
                return response()->json(['status' => false, 'icon' => 'info', 'message' => Lang::get('controller.no__discipline') ]);
            }
        }
    }

    /**
     * Undocumented function
     *
     * param Request $request
     * return void
     */
    public function exercisesets(Request $request) {
        if (session('discipline_id') == "notlinked") {
            $disciplineId = session('discipline_id');
        } elseif (session('discipline_id') == 0) {
            $disciplineId = NULL;
        } else {
            $disciplineId = session('discipline_id');
        }
        if (session('topic_id') == 0) {
            $topicId = NULL;
        } else {
            $topicId = session('topic_id');
        }
        if (session('grade_id') == 0) {
            $grade_id = NULL;
        } else {
            $grade_id = session('grade_id');
        }
        // Sign Up data
        $topics = Topic::where('approve_status', '=', 'approved')->paginate(25);
        //dd(session('language_id'),$disciplineId,session('grade_id'));
        $exercisets = $this->getPreferenceData($disciplineId, $topicId, $grade_id);
        return view('topics.exercise-sets', compact('exercisets', 'topics'));
    }

    /**
     * Discipline preference query
     */
    public function getPreferenceData($disciplineId, $topicId, $grade_id) {
        //dd($disciplineId, $topicId, $grade_id);
        $exercisets = Exerciseset::where('language_id', '=', session('language_id'))->where('publish_status', 'public');
        if ($disciplineId == 'notlinked') {
            $exercisets->whereNull('discipline_id');
        } elseif ($disciplineId != null) {
            $exercisets->Where('discipline_id', '=', $disciplineId);
        } else {
            //$exercisets->whereNotNull('discipline_id');
        }
        if ($grade_id != null) {
            $exercisets->Where('grade_id', '=', $grade_id);
        } else {
            //$exercisets->whereNotNull('grade_id');
        }
        if ($topicId != null) {
            $exercisets->Where('topic_id', '=', $topicId);
        }
        if (Auth::user()) {
            $exercisets->Where('createdby', '!=', Auth::user()->id);
        }
        return $exercisets->get();
    }

    /**
     *
     * Develop by wc
     *
     * Topic filter blade retrive.
     */
    public function topicExerciseFilter() {
        if (session('discipline_id') == 0) {
            $disciplineId = NULL;
        } else {
            $disciplineId = session('discipline_id');
        }
        if (session('topic_id') == 0) {
            $topicId = NULL;
        } else {
            $topicId = session('topic_id');
        }
        if (session('grade_id') == 0) {
            $grade_id = NULL;
        } else {
            $grade_id = session('grade_id');
        }

        // Sign Up data
        $topics = Topic::where('approve_status', '=', 'approved')->paginate(25);
        $exercisets = $this->topicExerciseFilterData($disciplineId, $topicId, $grade_id);
        return view('topics.filter-exercise', compact('exercisets'))->render();
    }

    /**
     *
     * Get fitered exersice data related topics.
     *
     */
    protected function topicExerciseFilterData($disciplineId, $topicId, $grade_id) {
        $myExercises = Exerciseset::where('language_id', '=', session('language_id'));
        if ($disciplineId != null) {
            $myExercises->Where('discipline_id', '=', $disciplineId);
        } else {
            $myExercises->whereNotNull('discipline_id');
        }
        if ($grade_id != null) {
            $myExercises->Where('grade_id', '=', $grade_id);
        } else {
            $myExercises->whereNotNull('grade_id');
        }
        if ($topicId != null) {
            $myExercises->Where('topic_id', '=', $topicId);
        }
        //Fetch data by exerciseset's title.
        if (!empty(request('Title_search'))) {
            if (request('Title_operator') === 'like') {
                $myExercises->where('title', 'LIKE', '%' . request('Title_search') . '%');
            } else {
                $myExercises->where('title', '=', request('Title_search'));
            }
        }
        //Fetch Data by created date.
        if (!empty(request('start_date'))) {
            $startDate = Carbon::parse(request('start_date'))->format('Y-m-d') . " 00:00:00";
            $endDate = Carbon::parse(request('end_date'))->format('Y-m-d') . " 23:59:59";
            $myExercises->whereBetween('created_at', [$startDate, $endDate]);
        }
        //Sorting Data by order.
        if (!empty(request('Sort_search')) && request('Sort_search') === 'Descending') {
            $myExercises->orderBy('title', 'desc');
        } else {
            $myExercises->orderBy('title', 'asc');
        }
        //Fetch Data by Disicipline name.
        if (!empty(request('Curriculum_search'))) {
            $myExercises->whereHas('discipline', function ($discipline) {
                if (request('Curriculum_operator') === 'like') {
                    $discipline->where('discipline_name', 'like', '%' . request('Curriculum_search') . '%');
                } else {
                    $discipline->where('discipline_name', '=', request('Curriculum_search'));
                }
            });
        } else {
            $myExercises->with('discipline');
        }
        //Fetch Data by Grade name.
        if (!empty(request('Grade_search'))) {
            $myExercises->whereHas('grade', function ($grade) {
                if (request('Grade_operator') === 'like') {
                    $grade->where('grade_name', 'like', '%' . request('Grade_search') . '%');
                } else {
                    $grade->where('grade_name', '=', request('Grade_search'));
                }
            });
        } else {
            $myExercises->with('grade');
        }
        return $myExercises->get();
    }

    /**
     *
     * Get user intersted data
     *
     * param Illuminate\Http\Request $request
     * return Response
     */
    public function getUserIntrested(Request $request) {
        $userinterest = Userinterest::findOrFail($request->user_intrest);
        if (!empty($userinterest)) {
            session(['language_id' => $userinterest['language_id']]);
            session(['discipline_id' => $userinterest['discipline_id']]);
            session(['exercise_type' => $userinterest['exercise_type']]);
            session(['topic_id' => $userinterest['topic_id']]);
            session(['grade_id' => $userinterest['grade_id']]);
            return ['status' => true];
        } else {
            return ['status' => false];
        }
    }

    /**
     *
     * Get skill categories by exercise sets.
     *
     * param Illuminate\Http\Request $request
     * return Illuminate\View\View
     */
    public function getskillCategoriesByExercisesets() {
        $topics = Topic::where('approve_status', '=', 'approved')->paginate(25);
        $exercisets_ids = explode(",", request('exercises'));

        $exercisets = Exerciseset::whereIn('id', $exercisets_ids)->groupBy('grade_id')->get();

        $disciplineIds = [];

        foreach($exercisets as $exercise){
          $skill_category = Skillcategory::where('discipline_id','=', $exercise->discipline_id)
                              ->where('approve_status','=','approved')->where('publish_status','=','published')
                              ->with(['skill' => function($skill) use($exercise){
                                $skill->where('grade_id','=', $exercise->grade_id)
                                      ->where('approve_status','=','approved')->where('publish_status','=','published')
                                      ->groupby('skill_category_id')->get();
                              }])->get();

          if(!in_array($exercise->discipline_id,$disciplineIds)){
              array_push($disciplineIds,$exercise->discipline_id);
          }

          $exercise['skill_category'] = $skill_category;

        }

        $skillExercisets = Discipline::whereIn('id', $disciplineIds)->with(['skillcategories' => function ($skillcategories) {
            $skillcategories->with(['skill' => function ($skill) {
                $skill->with(['grade','skillQuestion']);
            }
            ])->get();
        }
        ])->get();

        return view('topics.skill')->with(['topics' => $topics, 'exercisets' => $exercisets, 'exercisets_ids' => request('exercises'), 'skillExercisets' => $skillExercisets ]);
    }

     /**
     *
     * Get practice by exercise sets.
     *
     * param Illuminate\Http\Request $request
     * return Illuminate\View\View
     *
     */
    public function getPracticeByExercisesets(){
        $exerciseid = request('exercises');
        $exercisets_ids = explode(",", $exerciseid);
        $exerciseset = Exerciseset::whereIn('id',$exercisets_ids)->get()->all();
        $nextquestionid = 0;
        $questions = new Collection();

        foreach ($exerciseset as $exercise) {
            $questions = $questions->merge ($exercise->question);
        }

        $questions = $questions->shuffle ();
        $questions = $questions->take (6);

        $nextquestionid = 0;
        if (count($questions) > 0) {
          // Create final JSON Object
          $jsonArr = array();
          foreach ($questions as $question) {
            $jsonArr[] = json_decode($question->json_details,TRUE);
          }
          // Shuffle Answers
          foreach ($jsonArr as $key =>  $val) {
            $shuffleAns = $val['Questions'][0]['Answers']['Choices'];
            shuffle($shuffleAns);
            $jsonArr[$key]['Questions'][0]['Answers']['Choices'] = $shuffleAns;
          }

          // Store JSON Array in session
          Session (['jsonQuesions' => $jsonArr]);

          // JSON Encode array
          $jsonDetail = json_encode($jsonArr);
        } else {
          Session (['jsonQuesions' => array()]);
          $jsonDetail = array();
        }

        // Get questions count;
        $questionCount = count($questions);
        $discpline_url = route('topics.topic.index');
        $topic_name = $exerciseset[0]->topics->topic_name;
        $practice_type = 'disciplines_no_curriculum';
        $exerciseset_url = null;

        return view('practice.index',compact('jsonDetail','nextquestionid','questionCount','exerciseid','discpline_url','practice_type','topic_name','topics','exerciseset_url'));
    }
}
