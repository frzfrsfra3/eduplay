<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        // insert first 4 users (no password) assign them roles, then 10 random users
        DB::table('users')->insert([
            [
                'name'=>'Learner1',
                'email' => 'learner1@test.com',
                'password' => $this->hash_pass('123123'),
                'remember_token' => str_random(10),
                'is_email_active' => 1,
            ],
            [
                'name'=>'Teacher1',
                'email' => 'teacher1@test.com',
                'password' =>$this->hash_pass('123123'),
                'remember_token' => str_random(10),
                'is_email_active' => 1,
            ],
            [
                'name'=>'Parent1',
                'email' => 'omar@test.com',
                'password' => $this->hash_pass('123123'),
                'remember_token' => str_random(10),
                'is_email_active' => 1,
            ],
            [
                'name'=>'Admin',
                'email' => 'admin@eduplaycloud.com',
                'password' => $this->hash_pass('123123'), //need to encrypt a password here
                'remember_token' => str_random(10),
                'is_email_active' => 1,
            ],
            [
                'name'=>'WC Testing',
                'email' => 'kamini@webcluesinfotech.com',
                'password' => $this->hash_pass('123123'),
                'remember_token' => str_random(10),
                'is_email_active' => 1,
            ],
        ]);
        //assign the roles
        DB::table('role_user')->insert([
            [
                'role_id'=>'1', //learner
                'user_id'=>'1',
            ],
            [   'role_id'=>'2', //teacher
                'user_id'=>'2',
            ],
            [   'role_id'=>'3', //parent
                'user_id'=>'3',
            ],
            [   'role_id'=>'4', //admin
                'user_id'=>'4',
            ],
            [
                'role_id'=>'2', //Wc teacher for tester
                'user_id'=>'5',
            ],
        ]);

        // create 10 random users, give each a random role by inserting into role_user (role_id, user_id)
        // factory(App\Models\User::class, 10)->create()
        //     ->each(function ($user) {
        //             DB::table('role_user')->insert([
        //                 'role_id'=>random_int(1, 3),
        //                 'user_id'=>$user->id,
        //             ]);
        //         }
        //    );

    }


    function hash_pass($pass)
    {
        return bcrypt($pass) ;
}
}
