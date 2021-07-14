<?php

use Illuminate\Database\Seeder;

class CurriculaGradeTablesSeeder extends Seeder
{

    public function run()
    {
        //inserting curricula
        DB::table('curricula_gradelists')->insert([[
            'curriculum_gradelist_name'=>'12 Grades List',
            'description'=>'',
            'country_id'=>'1',
            'approve_status'=> 'approved',
            'createdby' =>'1',
            'updatedby' =>'1',
        ],
        [
            'curriculum_gradelist_name'=>'13 Grades List',
            'description'=>'',
            'country_id'=>'1',
            'approve_status'=> 'approved',
            'createdby' =>'1',
            'updatedby' =>'1',
        ]]);
        //creating grades of curriculum 1
        factory(App\Models\Grade::class, 12)->create();
        //inserting grades for curriculum 2
        DB::table('grades')->insert([[
            'grade_name' =>'Grade 1A',
            'curriculum_gradelist_id'=>'2',
            'createdby'=>'1',
        ],
        [
            'grade_name' =>'Grade 2A',
            'curriculum_gradelist_id'=>'2',
            'createdby'=>'1',
         ]]);


    }
}
