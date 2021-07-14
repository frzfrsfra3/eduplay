<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Exam::class, function (Faker $faker) {
    return [

        'examtype' => $faker->randomElement(['test','homework']),
        'title' => 'Exam of '.$faker->text(15),
        'teacheruser_id'=> random_int(2,13),  //teachers ids are between 8 and 13, Teacher1 id='2'
        'isavailable' => 'True',
        //'skillcategory_id' => $faker->text(250),
        //'skill_id' => $faker->randomElement(['public','private']),

    ];
 });
