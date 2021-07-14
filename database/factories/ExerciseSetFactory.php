<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Exerciseset::class, function (Faker $faker) {
    return [

        'title' => 'Exercise of '.$faker->text(15),
        'price'=> random_int(0,10),
        'discipline_id' => random_int(1,3),
        'grade_id' => random_int(1, 12) ,
        'language_id' => '1',
        'description' => $faker->text(250),
        'publish_status' => $faker->randomElement(['public','private']),
        'createdby' => random_int(1,7),

    ];
 });
