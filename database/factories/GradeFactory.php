<?php

// use Faker\Generator as Faker;

// $autoIncrement = autoIncrement();

// $factory->define(App\Models\Grade::class, function (Faker $faker) use ($autoIncrement) {
//     $autoIncrement->next();

//     return [
//         'grade_name' =>'Grade '.$autoIncrement->current(),
//         'curriculum_gradelist_id'=>'1',
//         'createdby'=>'1',
//     ];
// });
// // if(!function_exists('autoIncrement'))
// // {
// function autoIncrement()
// {
//     for ($i = 0; $i < 13; $i++) {
//         yield $i;
//     }
// }
// }0

use Faker\Generator as Faker;

// $autoIncrement = autoIncrement();

$factory->define(App\Models\Grade::class, function (Faker $faker)  {


    return [
        'grade_name' =>'Grade '.$faker->text(6),
        'curriculum_gradelist_id'=>'1',
        'createdby'=>'1',
    ];
});
// if(!function_exists('autoIncrement'))
// {
