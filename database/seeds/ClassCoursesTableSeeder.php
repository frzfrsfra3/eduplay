<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ClassCoursesTableSeeder extends Seeder
{
    // Creating Classes, adding Learners, Adding Exercises, Adding Exams
    public function run()
    {
        // creating 15 Classes, adding a random learner
        factory(App\Models\Courseclass::class, 15)->create()
         ->each(function ($Course)  {
             DB::table('classlearners')->insert([
                 'class_id'=> $Course->id,
                 'user_id'=> random_int(8,13), // teachers ids between 8-13
             ]);
             //adding a random number of learners <10. ids between 14 and 24
             for ($i=1; $i<random_int(1,14); $i++ ){
                 DB::table('classlearners')->insert([
                     'class_id'=> $Course->id,
                     'user_id'=> $i,
                     'status'=>'Accepted'
                 ]);
             }
             // CourseClass creator adds his exercises to his class
             $exercise=DB::table('exercisesets')->where('createdby',$Course->teacher_userid)->first();
             if($exercise !=null) {
                 DB::table('classexercises')->insert([
                     'class_id' => $Course->id,
                     'exercise_id' => $exercise->id,
                 ]);
             }

             // CourseClass creator adds his exams to his class
             $exam=DB::table('exams')->where('teacheruser_id',$Course->teacher_userid)->first();
             if ($exam != null) {
                 DB::table('classexams')->insert([
                     'class_id' => $Course->id,
                     'exam_id' => $exam->id
                     //'exam_startdate' => '3-3-2019',   //$faker->dateTimeBetween('','')
                     //'exam_enddate' => '10-10-2019'
                 ]);
             }
         }
            );
    }
}
