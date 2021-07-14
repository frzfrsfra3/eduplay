<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Userexamanswer::class, function (Faker $faker) {
    return [
        'answerdate'    =>  $faker->date(),
        'user_id'   =>  random_int(10, 15),
        'exam_id'   =>  random_int(1, 3),
        'class_id'  =>  random_int(10, 15),
        'classexam_id'  =>  random_int(1, 3),
        'attempt_number'    =>  random_int(0, 2),
        'question_id'   =>  random_int(1, 20),
        'answer_id' =>  random_int(1, 10),
        'iscorrect' =>  random_int(0, 1),
    ];
});

















