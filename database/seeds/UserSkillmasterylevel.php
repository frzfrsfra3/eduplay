<?php

use Illuminate\Database\Seeder;

class UserSkillmasterylevel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\UserSkillmasterylevel::class, 15)->create();
    }
}
