<?php

use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{

    public function run()
    {
        //
        DB::table('countries')->insert([[
            'country_name'=>'Lebanon',
            'abbreviation_code'=>'LB',
            'country_flag'=>'',

        ],
        [
            'country_name'=>'United Arab Emirates',
            'abbreviation_code'=>'UAE',
            'country_flag'=>'',
        ]]);

        // DB::table('languages')->insert([
        //     ['language'=>'English'], ['language'=>'French'],
        //     ['language'=>'Arabic'],
        // ]);


    }
}
