<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Discipline::class, function (Faker $faker) {
    return [
        'language_preference_id' => random_int(1, 3),
        'discipline_name' => 'discipline-'.$faker->text(6),
        'description' => 'disciplinedescription'.$faker->text(50),

        'approve_status' =>'not changed',
        'publish_status' =>'published',
        'createdby'=>'1',
        'updatedby'=>'1',
    ];
});
