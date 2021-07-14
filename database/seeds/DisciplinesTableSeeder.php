<?php

use Illuminate\Database\Seeder;

class DisciplinesTableSeeder extends Seeder
{
    //Discipline, Version, Collaborators
    public function run()
    {
        //insert Discipline - Topics
        DB::table('topics')->insert([[
            'topic_name' =>'Chemistry',
            'approve_status' => 'approved',
            'createdby' => '1',
            'updatedBy' => '1',
        ],
        [
            'topic_name' =>'Math',
            'approve_status' => 'approved',
            'createdby' => '1',
            'updatedBy' => '1',
        ],
            [
                'topic_name' =>'Biology',
                'approve_status' => 'approved',
                'createdby' => '1',
                'updatedBy' => '1',
            ],
        ]);
        //insert Discipline - Currilicula
        DB::table('disciplines')->insert([[
            'discipline_name' =>'Chemistry I',
            'description' =>'Chemistry for International Curriculum',
            'topic_id'=>'1',
            'curriculum_gradelist_id' =>'1',
            'iconurl'=>'',
            'language_preference_id' =>'1',
            'publish_status' => 'published',
            'approve_status' => 'approved',
            'createdby' => '1',
            'updatedBy' => '1',
        ],
        [
            'discipline_name' =>'Math I',
            'description' =>'Math for International Curriculum',
            'topic_id'=>'2',
            'curriculum_gradelist_id' =>'1',
            'iconurl'=>'',
            'language_preference_id' =>'1',
            'publish_status' => 'published',
            'approve_status' => 'approved',
            'createdby' => '1',
            'updatedBy' => '1',
        ],
        [
            'discipline_name' =>'Biology -Lebanese',
            'description' =>'Biology for Lebanese Curriculum',
            'topic_id'=>'3',
            'curriculum_gradelist_id' =>'2',
            'iconurl'=>'',
            'language_preference_id' =>'1',
            'publish_status' => 'published',
            'approve_status' => 'approved',
            'createdby' => '1',
            'updatedBy' => '1',
         ]
        ]);

        //insert Discipline Version
        // DB::table('disciplineversions')->insert([[
        //     'discipline_id'=>'1',
        //     'version'=>'1',
        //     'ispublished'=>'1',
        // ],
        // [
        //     'discipline_id'=>'2',
        //     'version'=>'1',
        //     'ispublished'=>'1',
        // ],
        // [
        //     'discipline_id'=>'3',
        //     'version'=>'1',
        //     'ispublished'=>'1',
        // ]]);

        // //insert Discipline Collaborators
        // DB::table('disciplinecollaborators')->insert([
        //     'discipline_id'=>'1',
        //     'user_id'=>'2',
        //     'message'=>'Teacher1 coordinator of Chemistry',
        //     'iscoordinator'=>'1',
        //     'approvalstatus'=>'approved'
        // ]);

    }
}
