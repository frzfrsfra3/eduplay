<?php

use Illuminate\Database\Seeder;

class XPpointsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('xp_points')->insert([
            [
                'activity_name'=>'login',
                'point'=>'2',
            ],
            [
                'activity_name'=>'Create Exercise Set',
                'point'=>'75',
            ],
            [
                'activity_name'=>'Create Class',
                'point'=>'100',
            ],
            [
                'activity_name'=>'Practice',
                'point'=>'10',
            ],
            [
                'activity_name'=>'Invite friend',
                'point'=>'200',
            ],
            [
                'activity_name'=>'View product Tour',
                'point'=>'5',
            ],
            [
                'activity_name'=>'Add linked account',
                'point'=>'50',
            ],
            [
                'activity_name'=>'Completing Assignment',
                'point'=>'30',
            ],
            [
                'activity_name'=>'Signup',
                'point'=>'50',
            ],
            [
                'activity_name'=>'Join Class',
                'point'=>'20',
            ],
            [
                'activity_name'=>'Play Game',
                'point'=>'1',
            ],
            [
                'activity_name'=>'View Reports',
                'point'=>'2',
            ],
            [
                'activity_name'=>'Create Pins',
                'point'=>'50',
            ],
            [
                'activity_name'=>'Create Curriculum',
                'point'=>'150',
            ],
            [
                'activity_name'=>'Write Review',
                'point'=>'75',
            ],
            [
                'activity_name'=>'Share Exercise Set',
                'point'=>'100',
            ],
            [
                'activity_name'=>'Publish to public Library',
                'point'=>'100',
            ],
            [
                'activity_name'=>'Publish to Class',
                'point'=>'100',
            ],
            [
                'activity_name'=>'Collaborate in Curriculum',
                'point'=>'150',
            ],
        ]);
    }
}