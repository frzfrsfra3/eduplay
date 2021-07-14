<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Badge::class, function (Faker $faker) {
    return [
        'badgetitle' => 'Badge of '.$faker->text(7),
        'badgedescription' => $faker->text(30),
        'badgeimageurl' =>'',
        'points' => $faker->randomNumber(2),
        'isactive' => random_int(0,1),
        'badge_condition' =>str_random(10),
        'addedon' => '03/06/2018',
    ];
});
