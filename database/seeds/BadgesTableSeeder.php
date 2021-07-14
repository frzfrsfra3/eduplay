<?php

use Illuminate\Database\Seeder;

class BadgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds on badges.
     */
    public function run()
    {
      //factory(App\Models\Badge::class, 40)->create();
      DB::table('badges')->insert([
        [
            'badgetitle'  =>  'White Belt',
            'badgedescription'  =>  'White Belt badges',
            'points'  =>  '',
            'isactive'  =>  '1',
            'badge_type' =>  'skill',
            'badge_info' =>  'learning',
        ],
        [
          'badgetitle'  =>  'Yellow Belt',
          'badgedescription'  =>  'Yellow Belt badges',
          'points'  =>  '',
          'isactive'  =>  '1',
          'badge_type' =>  'skill',
          'badge_info' =>  'learning',
        ],
        [
          'badgetitle'  =>  'Green Belt',
          'badgedescription'  =>  'Green Belt badges',
          'points'  =>  '',
          'isactive'  =>  '1',
          'badge_type' =>  'skill',
          'badge_info' =>  'learning',
        ],
        [
          'badgetitle'  =>  'Black Belt',
          'badgedescription'  =>  'Black Belt badges',
          'points'  =>  '',
          'isactive'  =>  '1',
          'badge_type' =>  'skill',
          'badge_info' =>  'learning',
        ],
        [
            'badgetitle'  =>  'Team Worker',
            'badgedescription'  =>  'Team Worker badges',
            'points'  =>  '1000',
            'isactive'  =>  '1',
            'badge_type' =>  'point',
            'badge_info' =>  'learning',
        ],
        [
            'badgetitle'  =>  'Collaborator',
            'badgedescription'  =>  'Collaborator badges',
            'points'  =>  '3000',
            'isactive'  =>  '1',
            'badge_type' =>  'point',
            'badge_info' =>  'learning',
        ],
        [
            'badgetitle'  =>  'Social guy',
            'badgedescription'  =>  'Social guy badges',
            'points'  =>  '5000',
            'isactive'  =>  '1',
            'badge_type' =>  'point',
            'badge_info' =>  'learning',
        ],
        [
          'badgetitle'  =>  'Activity',
          'badgedescription'  =>  'Activity badges',
          'points'  =>  '',
          'isactive'  =>  '1',
          'badge_type' =>  'activity',
          'badge_info' =>  'learning',
        ],
      ]);
    }
}
