<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        DB::table('roles')->insert([[
            'name' => 'Learner',
            'description' => '1',
            'sort' => '3'
        ],
        [
            'name' => 'Teacher',
            'description' => '1',
            'sort' => '2'
        ],
        [
            'name' => 'Parent',
            'description' => '1',
            'sort' => '4'
        ],
        [
            'name' => 'Admin',
            'description' => '1',
            'sort' => '1'
        ]]);
    }
}
