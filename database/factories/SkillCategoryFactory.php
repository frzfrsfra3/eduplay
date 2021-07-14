<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Skillcategory::class, function (Faker $faker) {
    return [
        'discipline_id' => random_int(1, 3),
        'skill_category_name' => 'skillcategory-'.$faker->text(6),
        'skill_category_decsription' => 'skillcategorydescription'.$faker->text(50),
        'version' =>'1',
        'sort_order' => $faker->randomDigitNotNull,
        'approve_status' =>'not changed',
        'publish_status' =>'published',
        'createdby'=>'1',
        'updatedby'=>'1',
    ];
});
