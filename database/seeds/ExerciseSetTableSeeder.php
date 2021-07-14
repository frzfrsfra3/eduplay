<?php

use Illuminate\Database\Seeder;
use App\Models\Skill;

class ExerciseSetTableSeeder extends Seeder
{
   // Creating 50 ExerciseSet with random number of Questions each
    public function run()
    {
        //creating 45 exams
        factory(App\Models\Exam::class, 45)->create();
        
        // creating 50 Exercises and for each ExerciseSet 10 Questions (each having 2 answeroptions)
        factory(App\Models\Exerciseset::class, 50)->create()
         ->each(function ($exercise) {
            $skill = Skill::where('id','=', random_int(1,45))->first();
             // creating 10 questions for this exercise
              factory(App\Models\Question::class, random_int(1,10))->create([
                'exercise_id' => $exercise->id,
                'skillcategory_id' => $skill->skill_category_id,
                'skill_id' => $skill->id,
                ])
                 ->each(function ($question) {
                    factory(App\Models\Answeroption::class, 3)->create(['question_id' => $question->id, 'iscorrect'=>'0']);
                    factory(App\Models\Answeroption::class, 1)->create(['question_id' => $question->id, 'iscorrect'=>'1']);
                    //add this question in a random exam
                    DB::table('examquestions')->insert([
                         [
                             'exam_id' =>random_int(1,45),
                             'question_id'=>$question->id,
                             'points'=>'5',
                         ]
                     ]);
                    }
                );
            }
        );
        DB::table('exercisesetbuyers')->insert([
            [
                'exerciseset_id' =>'1',
                'user_id'=>'1',
                'joindate'=>'2018-04-13 15:09:22',
            ],
            [
                'exerciseset_id' =>'2',
                'user_id'=>'2',
                'joindate'=>'2018-04-13 15:09:22',
            ]
        ]);

    }
}
