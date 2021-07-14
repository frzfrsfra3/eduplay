<?php

use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * This table should be seeded online with this live data
     *
     * @return void
     */
    public function run()
    {
        DB::table('activities')->insert([
            [
                'role_type' => 'Learner',
                'activity_description' => 'login',
                'activity_action' => '/login',
                'activity_category' => 'general',
                'order' => '1',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'login',
                'activity_action' => '/login',
                'activity_category' => 'general',
                'order' => '2',
            ],
            [
                'role_type' => 'Parent',
                'activity_description' => 'login',
                'activity_action' => '/login',
                'activity_category' => 'general',
                'order' => '3',
            ],
            [
                'role_type' => 'Learner',
                'activity_description' => 'addlinkedaccount',
                'activity_action' => '/users/addchildren',
                'activity_category' => 'general',
                'order'=>'4',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description'=>'addlinkedaccount',
                'activity_action' => '/users/addchildren',
                'activity_category' => 'general',
                'order'=>'5',
            ],
            [
                'role_type' => 'Parent',
                'activity_description'=>'addlinkedaccount',
                'activity_action' => '/users/addchildren',
                'activity_category' => 'general',
                'order'=>'6',
            ],
            [
                'role_type' => 'Learner',
                'activity_description'=>'practice',
                'activity_action' => '/practice/disciplinepractice',
                'activity_category' => 'general',
                'order'=>'7',
            ],
            [
                'role_type' => 'Learner',
                'activity_description'=>'completingassignment',
                'activity_category' => 'general',
                'activity_action' => '/takeexam',
                'order'=>'8',
            ],
            [
                'role_type' => 'Learner',
                'activity_description'=>'signup',
                'activity_action' => '/register/new/user',
                'activity_category' => 'general',
                'order'=>'9',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description'=>'signup',
                'activity_action' => '/register/new/user',
                'activity_category' => 'general',
                'order'=>'10',
            ],
            [
                'role_type' => 'Parent',
                'activity_description'=>'signup',
                'activity_action' => '/register/new/user',
                'activity_category' => 'general',
                'order'=>'11',
            ],
            [
                'role_type' => 'Learner',
                'activity_description'=>'joinclass',
                'activity_action' => '/courseclasses/requestClass',
                'activity_category' => 'general',
                'order'=>'12',
            ],
            [
                'role_type' => 'Learner',
                'activity_description'=>'viewreports',
                'activity_action' => '/reports',
                'activity_category' => 'general',
                'order'=>'13',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description'=>'viewreports',
                'activity_action' => '/reports',
                'activity_category' => 'general',
                'order'=>'14',
            ],
            [
                'role_type' => 'Parent',
                'activity_description'=>'viewreports',
                'activity_action' => '/reports',
                'activity_category' => 'general',
                'order'=>'15',
            ],
            [
                'role_type' => 'Learner',
                'activity_description' => 'createexerciseset',
                'activity_action' => '/exercisesets/create',
                'activity_category' => 'creation',
                'order'=>'16',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'createexerciseset',
                'activity_action' => '/exercisesets/create',
                'activity_category' => 'creation',
                'order'=>'17',
            ],
            [
                'role_type' => 'Parent',
                'activity_description' => 'createexerciseset',
                'activity_action' => '/exercisesets/create',
                'activity_category' => 'creation',
                'order'=>'18',
            ],
            [
                'role_type' => 'Learner',
                'activity_description' => 'createpins',
                'activity_action' => '/pins/create',
                'activity_category' => 'creation',
                'order'=>'19',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'createpins',
                'activity_action' => '/pins/create',
                'activity_category' => 'creation',
                'order'=>'20',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'createclass',
                'activity_action' => '/courseclasses',
                'activity_category' => 'creation',
                'order'=>'21',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'createcurriculum',
                'activity_action' => '/discipline/create',
                'activity_category' => 'creation',
                'order'=>'22',
            ],
            [
                'role_type' => 'Learner',
                'activity_description' => 'writereview',
                'activity_action' => '/addreview',
                'activity_category' => 'creation',
                'order'=>'23',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'writereview',
                'activity_action' => '/addreview',
                'activity_category' => 'creation',
                'order'=>'24',
            ],
            [
                'role_type' => 'Parent',
                'activity_description' => 'writereview',
                'activity_action' => '/addreview',
                'activity_category' => 'creation',
                'order'=>'25',
            ],
            [
                'role_type' => 'Learner',
                'activity_description' => 'shareexerciseset',
                'activity_action' => '/mail/exerciseset',
                'activity_category' => 'sharing',
                'order'=>'26',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'shareexerciseset',
                'activity_action' => '/mail/exerciseset',
                'activity_category' => 'sharing',
                'order'=>'27',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'publishtopubliclibrary',
                'activity_action' => '/exercisesets/exerciseset',
                'activity_category' => 'sharing',
                'order'=>'28',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'publishtoclass',
                'activity_action' => '/exercisesets/pusblish-to-class',
                'activity_category' => 'sharing',
                'order'=>'29',
            ],
            [
                'role_type' => 'Learner',
                'activity_description' => 'invitefriend',
                'activity_category' => 'sharing',
                'activity_action' => '/inviteUsers',
                'order'=>'30',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'invitefriend',
                'activity_category' => 'sharing',
                'activity_action' => '/inviteUsers',
                'order'=>'31',
            ],
            [
                'role_type' => 'Parent',
                'activity_description' => 'invitefriend',
                'activity_category' => 'sharing',
                'activity_action' => '/inviteUsers',
                'order'=>'32',
            ],
            [
                'role_type' => 'Learner',
                'activity_description' => 'viewproducttour',
                'activity_category' => 'sharing',
                'activity_action' => '/tours',
                'order' => '33',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'viewproducttour',
                'activity_category' => 'sharing',
                'activity_action' => '/tours',
                'order' => '34',
            ],
            [
                'role_type' => 'Parent',
                'activity_description' => 'viewproducttour',
                'activity_category' => 'sharing',
                'activity_action' => '/tours',
                'order' => '32',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'collabrateincurriculum',
                'activity_category' => 'sharing',
                'activity_action' => '/login',
                'order'=>'36',
            ],
            [
                'role_type' => 'Learner',
                'activity_description'=>'playgame',
                'activity_category' => 'general',
                'activity_action' => '/login',
                'order'=>'37',
            ],
            [
                'role_type' => 'Admin',
                'activity_description' => 'Login',
                'activity_action' => '/login',
                'activity_category' => 'general',
                'order' => '38',
            ],

            /*
            [
                'role_type' => 'Learner',
                'activity_description' => 'sharepins',
                'activity_action' => '/login',
                'order'=>'26.',
            ],
            [
                'role_type' => 'Teacher',
                'activity_description' => 'sharepins',
                'activity_action' => '/login',
                'order'=>'27.',
            ], */
            /* [
                'role_type' => 'Teacher',
                'activity_description' => 'Complete Profile',
                'activity_action' => '/profile',
                'order' => '1',
            ],
            [
                'role_type' => 'Learner',
                'activity_description' => 'Complete Profile',
                'activity_action' => '/profile',
                'order' => '4',
            ],
            */
        ]);
    }
}
