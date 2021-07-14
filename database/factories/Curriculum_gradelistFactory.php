<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Curriculum_gradelist::class, function (Faker $faker) {
    return [
        'country_id' => random_int(1, 3),
        'curriculum_gradelist_name' => 'curriculum_gradelist-'.$faker->text(6),
        'description' => 'curriculum_gradelist_description'.$faker->text(50),

        'approve_status' =>'not changed',

        'createdby'=>'1',
        'updatedby'=>'1',
    ];
});
