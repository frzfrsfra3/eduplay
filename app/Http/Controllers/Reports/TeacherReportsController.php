<?php
namespace App\Http\Controllers\Reports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Discipline;
use App\Models\Useractivitylog;
use App\Models\Role;
use App\Models\Exercisesetbuyer;
use App\Models\Badge;
use App\Models\Userbadge;
use App\Models\Courseclass;
use App\Models\Classlearner;
use App\Models\Exam;
use App\Helpers\LogicHelper;
use App\Models\Skillmasterylevel;
use App\Models\Question;
use App\Models\Skill;
use App\Models\UserSkillmasterylevel;
use App\Models\Classexam;
use DB;
use App\Http\Traits\AddXppoint;

class TeacherReportsController extends Controller {

    protected $user;
    protected $Useractivitylog;
    protected $Exercisesetbuyer;
    protected $Badge;
    protected $Userbadge;
    protected $Classlearner;
    protected $Courseclass;
    protected $Exam;
    protected $Question;
    protected $Skill;
    protected $UserSkillmasterylevel;
    protected $Classexam;

    /**
     * Create a new controller instance
     *
     * param User $user
     * param Useractivitylog $Useractivitylog
     * param Exercisesetbuyer $Exercisesetbuyer
     * param Badge $Badge
     * param Userbadge $Userbadge
     * param Classlearner $Classlearner
     * param Courseclass $Courseclass
     * param Exam $Exam
     * param Question $Question
     * param Skill $Skill
     * param UserSkillmasterylevel $UserSkillmasterylevel
     */
    use AddXppoint;
    public function __construct(User $user, Useractivitylog $Useractivitylog, Exercisesetbuyer $Exercisesetbuyer, Badge $Badge, Userbadge $Userbadge, Classlearner $Classlearner, Courseclass $Courseclass, Exam $Exam, Question $Question, Skill $Skill, UserSkillmasterylevel $UserSkillmasterylevel, Classexam $Classexam) {
        $this->user = $user;
        $this->Useractivitylog = $Useractivitylog;
        $this->Exercisesetbuyer = $Exercisesetbuyer;
        $this->Badge = $Badge;
        $this->Userbadge = $Userbadge;
        $this->Classlearner = $Classlearner;
        $this->Courseclass = $Courseclass;
        $this->Exam = $Exam;
        $this->Question = $Question;
        $this->Skill = $Skill;
        $this->UserSkillmasterylevel = $UserSkillmasterylevel;
        $this->Classexam = $Classexam;
    }

    /**
     * Display a listing of the resource
     *
     * return void
     */
    public function index(Request $request) {
        $this->add_xp_point(Auth::user ()->id, 'viewreports');
        if (Auth::check()) {
            $id = Auth::user()->id;
            $userId = Auth::id();
            // Get classes data user wise
            $classObj = $this->Courseclass->select('id', 'class_name')->where('teacher_userid', $userId)->orderBy('class_name')->get();
            if (isset($request->classId) && !empty($request->classId)) {
                $classId = $request->classId;
            } else {
                if (isset($classObj[0]['id']) && !empty($classObj[0]['id'])) {
                    $classId = $classObj[0]['id'];
                } else {
                    $classId = 0;
                }
            }
            // Average performance of students by classes
            $userAvgPerformance = $this->averagePerformanceOfStudents($userId);
            // Learner performance
            $userAvgArr = $this->learnerPerformanceLineChart($userId, $classId);
            // Recent activities
            $recentActivity = $this->recentActivities($id);
            // Total points
            $totalPoints = $this->totalPoints($id);
            // Total exercise
            $totalExercise = $this->totalExercise($id);
            // Total badges
            $totalBadges = $this->totalBadges($id);
            // Total classes
            $totalClasses = $this->totalClasses($id);
            // Get user object
            $user = User::findOrFail($id);
            // Get user roles
            $userRoles = $user->roles()->orderBy('sort')->get()->toArray();
            // Average performance by classes
            $userAvgByClass = $this->averagePerformanceByClassesLineChart($userId);
            // Average performance classes
            $averagePerformanceClasses = $this->averagePerformanceClasses($userId);
            // Get parent child's
            $parentChildsArr = $this->getParentChilds($userId);
            // Learner progress
            // Get class id for the progress bar chart
            if (isset($request->progressClassId) && !empty($request->progressClassId)) {
                $progressClassId = $request->progressClassId;
            } else {
                if (isset($averagePerformanceClasses[0]['class_id']) && !empty($averagePerformanceClasses[0]['class_id'])) {
                    $progressClassId = $averagePerformanceClasses[0]['class_id'];
                } else {
                    $progressClassId = 0;
                }
            }
            $learnerProgress = $this->learnerProgress($userId, $progressClassId);
            // Return data when ajax request
            if ($request->ajax()) {
                if ($request->type == 'progress') {
                    return view('eduplaycloud.users.reports.learner-progress', compact('learnerProgress'));
                } else {
                    return view('eduplaycloud.users.reports.learner-performance', compact('userAvgArr', 'classId'));
                }
            }
            // Return data to reports view
            return view('eduplaycloud.users.reports.reports', compact('user', 'userAvgArr', 'totalPoints', 'totalExercise', 'totalBadges', 'totalClasses', 'recentActivity', 'classObj', 'userAvgPerformance', 'userAvgByClass', 'parentChildsArr', 'userRoles', 'classId', 'learnerProgress', 'averagePerformanceClasses'));
        } else {
            abort(419, 'The page has been expired due to inactivity.');
        }
    }

    /**
     * For teacher activity
     *
     * return void
     */
    public function allActivities(Request $request, $userId) {
        $reqUserId = $userId;
        if (Auth::user()->hasRole('Parent'))
            $userId = Auth::user()->id;
        else
            $userId = 0;
        $user = $this->user->find($reqUserId);
        $childArr = $this->user->where('parent_id', $userId)->select('id', 'name')->get();
        if ($request->ajax()) {
            $selDate = $request->date;
            $activity = $this->Useractivitylog->where('user_id', $user->id)->whereDate('created_at', 'LIKE', $selDate)->orderBy('created_at', 'desc')
            //->whereNotIn('activity_id', [7, 8, 9, 10])
            ->take(6)->get();
            return view('eduplaycloud.users.reports.date-activities', compact('childArr', 'user', 'activity', 'selDate'));
        }
        return view('eduplaycloud.users.reports.all-activities', compact('childArr', 'user', 'activity'));
    }

    /**
     * Generate data for the average performance of students by classes this user is enrolled in
     *
     * param int $userId
     * param int $classId
     * return array
     */
    public function averagePerformanceOfStudents($userId) {
        
        // Get All Classes of user
        $courseClasses = User::findOrFail($userId)->teacherClasses;
        $data = [];
        $data[] = ["Class","Average",["role"=>"style"]];

        //for each class get the average of all students
        foreach ( $courseClasses as $courseClass )
        {
            $learners = $courseClass->learners;
            $sum = 0;
            foreach ($learners as $learner) 
            {
                $avg = $this->calculateExamsAvgForLearner($courseClass->id, $learner->id);
                $sum += $avg; 
            }

            $avg = $sum / count($learners);

            $colorsArr = [ "#FFCA86" , "#FFB55A" , "#FFA53E"];
            $color = $colorsArr[random_int(0,count($colorsArr) - 1)];
            $data[] = [$courseClass->class_name , $avg , $color];
        }

        return $data;
    }

    /**
     * Generate data for the learner performance
     *
     * param int $id
     * param int $userId
     * return array
     */
    public function learnerPerformanceLineChart($userId, $classId) {

        $courseClass = CourseClass::find($classId);
        if ( !$courseClass )
        {
            return [[]];
        }
        $learners = $courseClass->learners;

        $viewData = [];

        foreach ($learners as $learner) 
        {
                $avg = $this->calculateExamsAvgForLearner($classId, $learner->id);
                $viewData[0][] = $learner->name . "|" . $learner->id . "|" . $avg;
                $viewData[1][] = $this->getExamScoresTable($classId, $learner->id);
        }

        return $viewData;

        /*
        $totalExamsArr = [];
        $totalUsersArr = [];
        $examsUsersArr = [];
        $usersScoresArr = [];
        $usersScoresSumArr = [];
        $class = $this->Courseclass->with(['getLearner' => function ($query) {
            $query->select('name', 'user_id');
        }, 'exams' => function ($query) use ($userId) {
            $query->select('exams.id', 'teacheruser_id')->where('teacheruser_id', $userId)->orderBy('id');
        }, 'exams.getUserExamScore' => function ($query) {
            $query->select('exam_id', 'user_id', 'classexam_id', 'score');
        }
        ])->where('teacher_userid', $userId)->select('id', 'class_name')->where('id', $classId)->get();
        for ($a = 0;$a < count($class);$a++) {
            $examArr = $class[$a]['exams'];
            for ($b = 0;$b < count($examArr);$b++) {
                array_push($totalExamsArr, $b);
                $userExamScoreArr = $class[$a]['exams'][$b]['getUserExamScore'];
                for ($c = 0;$c < count($userExamScoreArr);$c++) {
                    $userId = $class[$a]['exams'][$b]['getUserExamScore'][$c]->user_id;
                    array_push($totalUsersArr, $userId);
                }
            }
        }
        // Create exam wise user array
        $totalUsersArr = array_values(array_unique($totalUsersArr));
        for ($z = 0;$z < count($totalExamsArr);$z++) {
            array_push($examsUsersArr, $totalUsersArr);
        }
        for ($r = 0;$r < count($class);$r++) {
            $getLearnerObj = $class[$r]->getLearner;
            $examArr = $class[$r]['exams'];
            for ($x = 0;$x < count($examArr);$x++) {
                // Flip key to value form $examsUsersArr array
                $examsUsersArr[$x] = array_flip($examsUsersArr[$x]);
                // Reset value to 0
                foreach ($examsUsersArr[$x] as $key => $value) {
                    $examsUsersArr[$x][$key] = 0;
                }
                $userExamScoreArr = $class[$r]['exams'][$x]['getUserExamScore'];
                for ($y = 0;$y < count($userExamScoreArr);$y++) {
                    $userId = $class[$r]['exams'][$x]['getUserExamScore'][$y]->user_id;
                    $userScore = $class[$r]['exams'][$x]['getUserExamScore'][$y]->score;
                    $examsUsersArr[$x][$userId] = $userScore;
                }
            }
        }
        // Sum users scores and divide by total exams
        foreach ($examsUsersArr AS $value) {
            foreach ($value AS $key => $secondValue) {
                if (!isset($usersScoresSumArr[$key])) {
                    $usersScoresSumArr[$key] = 0;
                }
                $usersScoresSumArr[$key]+= round($secondValue / count($examArr));
            }
        }
        // Append user name with avg scores
        foreach ($usersScoresSumArr as $key => $value) {
            $name = User::where('id', $key)->get(['name'])->toArray();
            if (isset($name[0]['name']) && !empty($name[0]['name'])) {
                $name = $name[0]['name'] . '|' . $key . '|' . $value;
            } else {
                $name = '';
            }
            $usersScoresSumArr[$key] = $name;
        }
        $usersScoresArr = array($usersScoresSumArr);
        $userAvgArr = array_merge($usersScoresArr, $examsUsersArr);
        $userAvgArr = array_map('array_values', $userAvgArr);
        if (!isset($userAvgArr) || empty($userAvgArr)) {
            $userAvgArr = [];
        }
        return $userAvgArr;*/
    }

    public function calculateExamsAvgForLearner($classID, $learnerID)
    {
        $courseClass = CourseClass::findOrFail($classID);
        
        $exams = $courseClass->exams;

        $userScores = [];

        // Get All Scores
        foreach ( $exams as $exam )
        {
            foreach ( $exam->getUserExamScore as $userExamScore) 
            {
                if ( $userExamScore->user_id == $learnerID ) 
                {
                    $userScores[] = $userExamScore->score;
                }
            }
        }

        // Calculate Scores Avg
        $sum = array_sum($userScores);
        $userScoreAvg = ($sum == 0 ) ? 0 :  $sum / count($userScores);

        return $userScoreAvg;
    }


    public function getExamScoresTable($classID, $learnerID)
    {
        $courseClass = CourseClass::findOrFail($classID);
        
        $exams = $courseClass->exams;

        $userScores = [];

        // Get All Scores
        $index = 0;
        foreach ( $exams as $exam )
        {
            foreach ( $exam->getUserExamScore as $userExamScore) 
            {
                if ( $userExamScore->user_id == $learnerID ) 
                {
                        $userScores[$index]["score"] = $userExamScore->score;
                        $userScores[$index]["examTitle"] = $exam->title;
                        $index++;
                }
            }
        }

        print_r($userScores);
        // convert data to text
        $scoresDataText = "";
        foreach( $userScores as $key => $userScore) 
        {
            $scoresDataText .= ",";
            // Data Syntax "TITLE&SCORE,TITLE&SCORE,..etc
            $scoresDataText .= $userScore["examTitle"] . "&" . $userScore["score"]; 
        
        }

        return $scoresDataText;
    }

    /**
     * Recent activities
     *
     * param int $id
     * return object
     */
    public function recentActivities($id) {
        $activity = $this->Useractivitylog->where('user_id', $id)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at', 'desc')->whereNotIn('activity_id', [7, 8, 9, 10])->take(6)->get();
        return $activity;
    }

    /**
     * Total points
     *
     * param int $id
     * return object
     */
    public function totalPoints($id) {
        $totalPoints = $this->Useractivitylog->where('user_id', $id)->orderBy("id", 'desc')->first();
        return $totalPoints;
    }

    /**
     * Total exercise
     *
     * param int $id
     * return int
     */
    public function totalExercise($id) {
        $totalExercise = $this->Exercisesetbuyer->where('user_id', $id)->count();
        return $totalExercise;
    }

    /**
     * Total badges
     *
     * param int $id
     * return int
     */
    public function totalBadges($id) {
        $totalBadges = $this->Userbadge->where('user_id', $id)->count();
        return $totalBadges;
    }

    /**
     * Total Classes
     *
     * param int $id
     * return int
     */
    public function totalClasses($id) {
        $totalClass = $this->Classlearner->where('user_id', $id)->count();
        return $totalClass;
    }

    /**
     * Generate data for the average performance by classes
     *
     * param int $id
     * param int $userId
     * return array
     */
    public function averagePerformanceByClassesLineChart($userId) {
        $chartFixedDataArr = [];
        $classArr = [];
        $totalClassArr = [];
        $totalExamArr = [];
        $classExamsScores = [];
        $classObj = $this->Classlearner->with(['courseclass' => function ($query) {
            $query->select('id', 'class_name');
        }, 'getClassExam' => function ($query) {
            $query->select('id', 'exam_id', 'class_id');
        }, 'getClassExam.exam' => function ($query) {
            $query->select('id');
        }, 'getClassExam.exam.getUserExamScore' => function ($query) use ($userId) {
            $query->select('id', 'user_id', 'exam_id', 'score')->where('user_id', $userId);
        }
        ])->select('id', 'class_id', 'user_id')->where('user_id', $userId)->get();
        for ($a = 0;$a < count($classObj);$a++) {
            $classId = $classObj[$a]->class_id;
            $className = $classObj[$a]->courseclass->class_name;
            $learnerCounts = 1;
            $classExamsObj = json_decode(json_encode($classObj[$a]['getClassExam']), true);
            array_push($totalClassArr, $a);
            if (count($classExamsObj) > 0) {
                $examsArr = [];
                for ($b = 0;$b < count($classExamsObj);$b++) {
                    //if (count($classExamsObj[$b]['exam']) > 0) {
                    if (!empty($classExamsObj[$b]['exam'])) {
                        array_push($totalExamArr, $b);
                        if (isset($classExamsObj[$b]['exam']['get_user_exam_score'][0]) && !empty($classExamsObj[$b]['exam']['get_user_exam_score'][0])) {
                            $userExamScoreArr = $classExamsObj[$b]['exam']['get_user_exam_score'][0];
                            if (count($userExamScoreArr) > 0) {
                                $examId = $userExamScoreArr['exam_id'];
                                $score = $userExamScoreArr['score'];
                                $examsArr[$examId] = $score;
                            }
                        } else {
                            $examsArr = [];
                        }
                    } else {
                        $examsArr = [];
                    }
                }
            } else {
                $examsArr = [];
            }
            if(array_sum($totalExamArr) == 0) {
                $totalExamArr[0] = 1;
            }

            if (count($examsArr) > 0) {
                $examsArr = array_sum($examsArr) / array_sum($totalExamArr);
            }
            $classArr[$a]['0'] = $className;
            if (!empty($examsArr)) {
                $classArr[$a]['1'] = $examsArr;
            } else {
                $classArr[$a]['1'] = 0;
            }
            $classArr[$a]['2'] = LogicHelper::barColorCodes($a);
        }
        (object)$googleChartObj = ['role' => 'style'];
        $chartFixedDataArr = [['Class', 'Average', $googleChartObj], ];
        if (empty($classArr)) {
            $chartFixedDataArr = [];
        }
        $userAvgPerformance = array_merge($chartFixedDataArr, $classArr);
        return $userAvgPerformance;
    }
    /**
     * Get parent child's
     *
     * param int $userId
     * return array
     */
    public function getParentChilds($userId) {
        $usermail = $this->user->where('id', $userId)->select('email')->first();
        $childArr = User::where('parent_id', $userId)->orWhere('parentmail',$usermail->email)->select('id', 'name')->get()->toArray();
        return $childArr;
    }

    /**
     * Skill performance details
     *
     * param [int] $id
     * return void
     */
    public function skillPerformance($classId, $userId) {
        $skilldata = $this->skillPerformanceFilterData($userId, $classId);
        // For Class Learner
        $learnerCount = $this->Classlearner->where('class_id', $classId)->count();
        $user = $this->user->where('id', $userId)->select('id', 'name')->first();
        return view('eduplaycloud.users.reports.skill-performance', compact('user', 'skilldata', 'learnerCount', 'classId', 'userId'));
    }

    /**
     * Get skill performance filter by ajax.
     *
     * develop by WC.
     * return void
     */
    public function getSkillPerformanceFilter() {
        $userId = request('user_id');
        $classId = request('class_id');
        $skilldata = $this->skillPerformanceFilterData($userId, $classId);
        // For Class Learner
        $learnerCount = $this->Classlearner->where('class_id', $classId)->count();
        $user = $this->user->where('id', $userId)->select('id', 'name')->first();
        return view('eduplaycloud.users.reports.filter.skill-performance-filter', compact('skilldata', 'userId', 'classId', 'user', 'learnerCount'));
    }

    /**
     * Get Skill Performance filter date
     * 
     * param int $userId
     * param int $classId
     * return Response
     */
    public function skillPerformanceFilterData($userId, $classId) {
        // For Skill detial, que/ans and masatery level
        $skilldata = $this->Classlearner->select('id', 'class_id', 'user_id')->with(['courseclass' => function ($query) {
            $query->select('id', 'class_name', 'discipline_id');
        }, 'courseclass.discipline' => function ($query) {
            $query->select('id', 'discipline_name');
        }, 'courseclass.skillCategory' => function ($query) {
            $query->select('id', 'skill_category_name', 'discipline_id');
        }, 'courseclass.skillCategory.skill' => function ($query) {
            $query->select('id', 'skill_name', 'skill_category_id');
            //Fetch data by skill's name.
            if (!empty(request('Name_search'))) {
                if (request('Name_operator') === 'like') {
                    $query->where('skill_name', 'like', '%' . request('Name_search') . '%');
                } else {
                    $query->where('skill_name', request('Name_operator'), request('Name_search'));
                }
            }
            //Sorting Data by order.
            if (!empty(request('Sort_search')) && request('Sort_search') === 'Descending') {
                $query->orderBy('id', 'desc');
            } else {
                $query->orderBy('id', 'asc');
            }
        }, 'courseclass.skillCategory.skill.skillQuestion' => function ($query) {
            $query->select('id', 'skill_id')->orderBy('id');
        }, 'courseclass.skillCategory.skill.skillQuestion.getUserExamAnswere' => function ($query) use ($userId) {
            $query->select('id', 'question_id', 'answer_id', 'iscorrect')->where('iscorrect', 1)->where('user_id', $userId)->orderBy('id');
        }
        ])->where('user_id', $userId)->where('class_id', $classId);
        return $skilldata->first();
    }

    /**
     * All Activity chart   ( Not require for now )
     *
     * param [int] $id
     * return void
     */
    public function userActivity($userId) {
        $userActivity = $this->Useractivitylog->select('id', 'created_at', 'activity_id')->selectRaw('date(created_at) as date, COUNT(*) as count')->where("created_at", ">", Carbon::now()->subMonths(6))->groupBy("created_at")->where('user_id', $userId)->get();
        return view('eduplaycloud.users.reports.all-activities', compact('userActivity'));
    }

    /**
     * Generate data for the learner progress chart
     *
     * param int $userId
     * param int $progressClassId
     * return object
     */
    public function learnerProgress($userId, $progressClassId) {
        // Static mastery levels array
        $defaultArr = [['Effort' => 'Amount given']];
        $masteryLevelsArr = [['Not Started' => 0.01], ['Needs More Practice' => 0.01], ['Under Acquisition' => 0.01], ['Acquired' => 0.01], ['Mastered' => 0.01]];
        // Change default array index
        $masteryLevelsIndexArr = [];
        foreach ($masteryLevelsArr as $key => $val) {
            $masteryLevelsIndexArr[$key + 1] = $val;
        }
        // Collect data
        $classData = $this->Classlearner->select('id', 'class_id', 'user_id')->with(['courseclass' => function ($query) {
            $query->select('id', 'class_name', 'discipline_id', 'grade_id');
        }, 'courseclass.skillCategory' => function ($query) {
            $query->select('id', 'skill_category_name', 'discipline_id');
        }, 'courseclass.skillCategory.skill' => function ($query) {
            // $query->select('id', 'skill_name', 'skill_category_id');
            $query->selectRaw('skill_category_id, count(*) as count');
        }, 'getClassExam' => function ($query) {
            $query->select('id', 'class_id', 'exam_id');
        }, 'getClassExam.getUserSkillMasteryLevel' => function ($query) use ($userId) {
            // $query->select('id', 'user_id', 'skill_id', 'classexam_id', 'masteryLevel')
            $query->selectRaw('id, user_id, skill_id, classexam_id, masteryLevel, count(*) as count')->orderBy('skill_id')
            // ->distinct('skill_id')
            ->groupBy('skill_id')->where('user_id', $userId);
        }
        ])->where('class_id', $progressClassId)->where('user_id', $userId)->get()->toArray();
        // Push count as per mastery levels
        if (count($classData) > 0) {
            if (count($classData[0]['get_class_exam']) > 0) {
                $classArr = $classData[0]['get_class_exam'];
                for ($a = 0;$a < count($classArr);$a++) {
                    $levelArr = $classArr[$a]['get_user_skill_mastery_level'];
                    $tmp = [];
                    if (count($levelArr) > 0) {
                        for ($b = 0;$b < count($levelArr);$b++) {
                            $masteryLevel = $levelArr[$b]['masteryLevel'];
                            $count = $levelArr[$b]['count'];
                            array_push($masteryLevelsIndexArr[$masteryLevel], $count);
                        }
                    }
                }
            }
        }
        // Sum the progress
        foreach ($masteryLevelsIndexArr as $key1 => $value1) {
            if (count($masteryLevelsIndexArr[$key1]) > 0) {
                $sumArr = [];
                foreach ($masteryLevelsIndexArr[$key1] as $key2 => $value2) {
                    if (is_numeric($key2)) {
                        array_push($sumArr, $value2);
                        unset($masteryLevelsIndexArr[$key1][$key2]);
                    }
                }
                $firstKey = key($masteryLevelsIndexArr[$key1]);
                $masteryLevelsIndexArr[$key1][$firstKey] = array_sum($sumArr);
            }
        }
        $masteryLevelsIndexArr = array_merge($defaultArr, $masteryLevelsIndexArr);
        $otherArrKeysSum = $masteryLevelsIndexArr[2]['Needs More Practice'] + $masteryLevelsIndexArr[3]['Under Acquisition'] + $masteryLevelsIndexArr[4]['Acquired'] + $masteryLevelsIndexArr[5]['Mastered'];
        $notStarted = 100 - $otherArrKeysSum;
        $masteryLevelsIndexArr[1]['Not Started'] = $notStarted;
        return array_values($masteryLevelsIndexArr);
    }

    /**
     * Exercise set reports
     *
     * param int $skillId
     * return void
     */
    public function exerciseSetReport($classId, $userId, $skillId) {
        $uid = \Auth::user()->id;
        $classList = $this->Courseclass->where('teacher_userid', $uid)->select('id', 'class_name')->orderBy('class_name')->get();
        // Learner class - CourseLearner tbl
        $classListLearnervise = $this->Classlearner->where('user_id', $userId)->select('id', 'class_id', 'user_id')->get();
        $userId = $this->user->find($userId);
        $learnerCount = $this->Classlearner->where('class_id', $classId)->count();
        $questions = $this->Question->with(['skill' => function ($query) {
            $query->select('id', 'skill_name');
        }, 'skillcategory', 'exercise', 'answeroptions'])->where('skill_id', $skillId)->select('id', 'details', 'skill_id')->get();
        return view('eduplaycloud.users.reports.exerciseSetReport', compact('questions', 'userId', 'learnerCount', 'classList', 'classListLearnervise'));
    }

    /**
     * Get average performance by classes
     *
     * param int $id
     * param int $userId
     * return array
     */
    public function averagePerformanceClasses($userId) {
        return $this->Classlearner->with(['courseclass' => function ($query) {
            $query->select('id', 'class_name');
        }
        ])->select('id', 'class_id', 'user_id')->where('user_id', $userId)->get()->toArray();
    }

    /**
     * Skill performance details
     *
     * param [int] $id
     * return void
     */
    public function skillPerformanceViewbyTest($classId, $userId) {
        $skilldata = $this->Classlearner->where('user_id', $userId)->where('class_id', $classId)->with(['getClassExam'])->select('id', 'class_id', 'user_id')->first();
        // For Class Learner
        $learnerCount = $this->Classlearner->where('class_id', $classId)->count();
        $user = $this->user->where('id', $userId)->select('id', 'name')->first();
        return view('eduplaycloud.users.reports.skill-performance-view-by-test', compact('user', 'skilldata', 'learnerCount'));
    }


    /**
     * Exerciseset Report Test
     * 
     * param int $classId
     * param int $userId
     * param int $examId
     * return Illuminate\View\View
     */
    public function exerciseSetReportTest($classId, $userId, $examId) {
        $uid = \Auth::user()->id;
        // Teacher class - Courseclass tbl
        $classList = $this->Courseclass->where('teacher_userid', $uid)->select('id', 'class_name')->orderBy('class_name')->get();
        // Learner class - CourseLearner tbl
        $classListLearnervise = $this->Classlearner->where('user_id', $userId)->select('id', 'class_id', 'user_id')->get();
        $learnerCount = $this->Classlearner->where('class_id', $classId)->count();
        $userId = $this->user->find($userId);
        $questions = $this->Classexam->with(['getExamquestion','getExamquestion.answereoption'])
        ->where('exam_id', $examId)
        ->where('class_id', $classId)->first();
        return view('eduplaycloud.users.reports.exerciseSetReport', compact('questions', 'userId', 'learnerCount', 'classList', 'classListLearnervise'));
    }
}
