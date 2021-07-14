<?php

use Faker\Generator as Faker;

$factory->define(App\Models\UserSkillmasterylevel::class, function (Faker $faker) {
    return [
        'user_id'   =>  random_int(1, 20),
        'skill_id'  =>  random_int(1, 20),
        'classexam_id'  =>  random_int(1, 10),
        'score'     =>  random_int(1, 50),
        'masteryLevel'  =>  random_int(1, 5),
    ];
});

