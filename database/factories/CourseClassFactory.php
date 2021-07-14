<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Courseclass::class, function (Faker $faker) {
    return [
        'class_name' => 'Class of '.$faker->text(5),
        'class_description' => $faker->text(25),
        'language_id'=>'1',
        'start_date'=>$faker->date(),
        'end_date' =>$faker->date(),
        'discipline_id' => random_int(1,2),
        'grade_id'=> random_int(1,14),
        'teacher_userid' => random_int(2,10),
        'isavailable' =>'1',
        'iconurl'=>$faker->imageUrl(),
    ];
 });
