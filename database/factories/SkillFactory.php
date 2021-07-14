<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Skill;

use Faker\Generator as Faker;

$factory->define(App\Models\Skill::class, function (Faker $faker) {
    return [
        //'skill_category_id' =>function () {
        //    return factory(App\Models\Skill::class)->create()->id;
        //},
        //'skill_category_id'=>
        //'grade_id',
        'skill_name'=> 'skill'.$faker->text(10),
        'skill_description' => 'skilldescription'.$faker->text(50),
        'version' =>'1',
        'publish_status' =>'published',
        'approve_status' =>'not changed',
        'grade_id' => random_int(1, 12),
        'createdby' =>'1',
        'updatedby'=>'1',
        'sort_order' => $faker->randomDigitNotNull,
    ];
});
