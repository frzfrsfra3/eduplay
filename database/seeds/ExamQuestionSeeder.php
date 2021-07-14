<?php

use Illuminate\Database\Seeder;

class ExamQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Examquestion::class, 20)->create();
    }
}
