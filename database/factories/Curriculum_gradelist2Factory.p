<?php

namespace Database\Factories;

use App\Models\Curriculum_gradelist;
use Illuminate\Database\Eloquent\Factories\Factory;

class Curriculum_gradelist2Factory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Curriculum_gradelist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'country_id' => random_int(1, 3),
            'curriculum_gradelist_name' => 'curriculum_gradelist-'.$faker->text(6),
            'description' => 'curriculum_gradelist_description'.$faker->text(50),

            'approve_status' =>'not changed',

            'createdby'=>'1',
            'updatedby'=>'1',
        ];
    }
}
