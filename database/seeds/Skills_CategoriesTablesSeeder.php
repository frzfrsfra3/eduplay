<?php

use Illuminate\Database\Seeder;

class Skills_CategoriesTablesSeeder extends Seeder
{
    // Run the database seeds on 2 tables skillcategories and skills. should change when trying to merge both
    public function run()
    {
        // creating 3 skills for each skillcategory
        factory(App\Models\Skillcategory::class, 50)->create() //;
            ->each(function ($skillcategory) {
            //$u->skill()->save(factory(App\Models\Skill::class,3)->make());
            factory(App\Models\Skill::class, 3)->create(['skill_category_id' => $skillcategory->id]);
            //use when merging skill & skill category
            // factory(App\Models\Skill::class, 1)->create();
            // factory(App\Models\Skill::class, random_int(1,5))->create(['parentskill_id' => $skillcategory->id]);
        });
    }
}
