<?php

use Faker\Generator as Faker;

$autoIncrement = autoIncrement();

$factory->define(App\Models\Grade::class, function (Faker $faker) use ($autoIncrement) {
    $autoIncrement->next();

    return [
        'grade_name' =>'Grade '.$autoIncrement->current(),
        'curriculum_gradelist_id'=>'1',
        'createdby'=>'1',
    ];
});

function autoIncrement()
{
    for ($i = 0; $i < 13; $i++) {
        yield $i;
    }
}
