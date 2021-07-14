<?php

namespace App\Helpers;

use Auth;
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
use App\Models\Pendingtask;
use App\Models\Examquestion;
use App\Models\Question;
use DB;
class LogicHelper
{
    /**
     * Bar chart color codes by array index
     *
     * param int $codeIndex
     * return string
     */
    static function barColorCodes($codeIndex)
    {
        $colorArr = [
            '#FFCA86',
            '#FFB55A',
            '#FFA53E',
            '#FF8B2A',
            '#FC7B27',
            '#F46C23'
        ];

        if (isset($colorArr[$codeIndex]) && !empty($colorArr[$codeIndex])) {
            $colorCode = $colorArr[$codeIndex];
        } else {
            $colorCode = '#F46C23';
        }

        return $colorCode;
    }

    /**
     * Generate data for the child average performance by classes
     *
     * param int $userId
     * param int $childId
     * return array
     */
    static function childAvgPerformance($childId)
    {
        $chartFixedDataArr = [];
        $classArr = [];
        $totalClassArr = [];
        $totalExamArr = [];
        $classExamsScores = [];

        $classObj = Classlearner::with(['courseclass'=> function ($query) {
            $query->select('id', 'class_name');
        },'getClassExam' => function ($query) {
            $query->select('id', 'exam_id', 'class_id');
        },'getClassExam.exam' => function ($query) {
            $query->select('id');
        },'getClassExam.exam.getUserExamScore' => function ($query) use ($childId) {
            $query
            ->select('id','user_id','exam_id','score')
            ->where('user_id', $childId);
        }])
        ->select('id', 'class_id', 'user_id')
        ->where('user_id', $childId)->get();

        for ($a=0; $a<count($classObj); $a++) {
            $classId = $classObj[$a]->class_id;
            $className = $classObj[$a]->courseclass->class_name;
            $learnerCounts = 1;
            $classExamsObj = json_decode(json_encode($classObj[$a]['getClassExam']), true);

            array_push($totalClassArr, $a);
            if (count($classExamsObj) > 0) {
                $examsArr = [];
                for ($b=0; $b<count($classExamsObj); $b++) {
                    if (count($classExamsObj[$b]['exam']) > 0) {
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
        $chartFixedDataArr = [
            ['Class', 'Average', $googleChartObj],
        ];
        if (empty($classArr)) {
            $chartFixedDataArr = [];
        }
        $userAvgPerformance = array_merge($chartFixedDataArr, $classArr);

        return $userAvgPerformance;
    }

    /**
     * Get class data by name
     *
     * param int $className
     * return array
     */
    static function getAllClasses()
    {
        $classObj = Courseclass::select('id', 'class_name')->get()->toArray();

        return $classObj;
    }

    static function countTask()
    {
        $pendingTask=Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)->where('status','like','done')->where('task_type',1)->count();

        $totalPendings=Pendingtask::with('user')->where('user_id', '=', Auth::user()->id)->where('task_type',1)->count();

        if($pendingTask === 0 && $totalPendings === 0){
            return $totalPr=0;
        }
        else{
            return $totalPr=($pendingTask*100)/$totalPendings;
        }
    }

    /**
     * Get exam
     * 
     */
    static function getExamDuration($examId)
    {
        $examquestion = Examquestion::where('exam_id', $examId)->get();
        return $examquestion;
    }


    /**
     * Get exam question Duration
     * 
     */
    static function getQuestionDuration($queId)
    {
        $questions = Question::where('id', $queId)->select('maxtime')->get();
        //dd($questions);
        return $questions;
    }


    // DB Transaction
    public function dbStart(){
        DB::beginTransaction();
    }

    public function dbEnd(){
        DB::commit();
    }
    public function dbRollBack(){
        DB::rollback();
    }

     // End DB Transaction
}