<?php

use Illuminate\Database\Seeder;

class SkillMasteryLevelsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('skillmasterylevels')->insert([[
            'levelname'=>'Not started',
            'level_massage'=>'You didn’t start practicing this skill',
            'min_score'=>'0',
            'max_score'=>'0',
            'min_consecutive_value'=>'0',
            'max_consecutive_value'=>'0',
            ],
            [
                'levelname'=>'Needs More Practice',
                'level_massage'=>'You started practicing but you are struggling',
                'min_score'=>'0',
                'max_score'=>'50',
                'min_consecutive_value'=>'0',
                'max_consecutive_value'=>'2',
            ],
            [
                'levelname'=>'Under Acquisition',
                'level_massage'=>'You are able to answer questions that depend on this skill',
                'min_score'=>'50',
                'max_score'=>'80',
                'min_consecutive_value'=>'3',
                'max_consecutive_value'=>'4',
            ],
            [
                'levelname'=>'Acquired',
                'level_massage'=>'You are answering correctly majority of questions but not with the required time',
                'min_score'=>'80',
                'max_score'=>'90',
                'min_consecutive_value'=>'5',
                'max_consecutive_value'=>'100',
            ],
            [
                'levelname'=>'Mastered',
                'level_massage'=>'You are answering majority questions correctly and within the required time in a consistent manner',
                'min_score'=>'95',
                'max_score'=>'100',
                'min_consecutive_value'=>'5',
                'max_consecutive_value'=>'100',
            ]]);
    }

}