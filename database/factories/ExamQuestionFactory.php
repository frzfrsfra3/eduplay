<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Examquestion::class, function (Faker $faker) {
    return [
        'exam_id'   =>  random_int(1, 3),
        'question_id'  =>  random_int(1, 20),
        'points'  =>  random_int(1, 10),
        'sort_order'     =>  random_int(1, 20),
    ];
});
