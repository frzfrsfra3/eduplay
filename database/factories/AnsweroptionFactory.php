<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Answeroption::class, function (Faker $faker) {
    return [

          //'question_id' => $questionid, passed as parameter
          'answer_type' =>'text',
          'details' => 'Ans: '.$faker->text(5),
          //'iscorrect' =>'0', //trying to pass this as parameter too
          'sort_order' => random_int(1,4),
    ];
 });
