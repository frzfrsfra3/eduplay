<?php

use Illuminate\Database\Seeder;

class UserExamAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Userexamanswer::class, 20)->create();
    }
}
