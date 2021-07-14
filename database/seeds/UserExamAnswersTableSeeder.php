<?php

use Illuminate\Database\Seeder;

class UserExamAnswersTableSeeder extends Seeder
{
     // Adding User Answers to table userexamanswers:
    // ------------------------------------------------
    // select the user_ids from classlearners where class_id
    // select the exam_id, classexam_id from classexams where class_id
    // select question_ids from examquestions where exam_id
    // for each question (select random id from answer_options where question_id)
    // insert in userexamanswers:
    // 'answerdate','user_id','exam_id','class_id','classexam_id','attempt_number','question_id',
    // 'answer_id','timespent','iscorrect','teachermark','pointsgained',

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for each CourseClass ids from 1 to 15 it has 1 exercise and 1 exam
        for($i=1; $i<6; $i++){
            $learners= DB::table('classlearners')->where('class_id',$i)->get();
            $classexam= DB::table('classexams')->where('class_id',$i)->first();
            $examquestions= DB::table('examquestions')->where('exam_id',$classexam->exam_id)->get();

            foreach ($examquestions as $examquestion){
                $answeroption=DB::table('answeroptions')->where('question_id',$examquestion->question_id)->first();
                DB::table('userexamanswers')->insert([
                    //'answerdate' =>'21-3-2019',
                    'user_id' =>'25',
                    'exam_id'=> $classexam->exam_id,
                    'class_id'=>$i,
                    'classexam_id'=>$classexam->id,
                    'attempt_number'=>'1',
                    'question_id'=>$examquestion->question_id,
                    'answer_id'=>$answeroption->id,
                    'timespent'=>'50',
                    'iscorrect'=>$answeroption->iscorrect,
                    'teachermark'=>'5',
                    'pointsgained'=>'2',
                ]);
            }
        }
    }
}
