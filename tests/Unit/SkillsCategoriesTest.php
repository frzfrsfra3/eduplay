<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Skillcategory;
use App\Models\Skill;
use App\Models\Discipline;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use App\Models\Grade;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory ;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Request;
class SkillsCategoriesTest extends TestCase
{
    use HasFactory;
    // use RefreshDatabase;
    // use DatabaseMigrations;
    // use RefreshDatabase, WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function skill()
    // {
    //     return $this->hasMany('App\Models\Skill','skill_category_id','id');
    // }

/** @var \Illuminate\Database\Eloquent\Factory $factory */
/** @var \Illuminate\Database\Eloquent\HasFactory $hfactory */
    public function testing()
    {

        $this->assertTrue(
            Schema::hasColumns('skillcategories', [
                'id',
              'discipline_id',
              'skill_category_name',
              'skill_category_decsription',
              'description_Fr',
              'description_Ar',
              'version',
              'sort_order',
              'duration',
              'moderatedby',
              'approve_status',
              'publish_status',
              'createdby',
              'updatedby',
              'origin_id'
          ]), 1);
       $discipline    = factory(Discipline::class)->create();
         $SkillCategory    = factory(Skillcategory::class)->create(['discipline_id' => $discipline->id]); // on Laravel 5.6
        // $SkillCategory    =  Skillcategory::create(Skillcategory::factory()->create()); // laravel 8
        $Skill    = factory(Skill::class)->create(['skill_category_id' => $SkillCategory->id]);
        // $Skill    = Skill::factory()->create(['skill_category_id' => $SkillCategory->id]);
        // $skillCategory = SkillCategory::factory()->make();
        // $SkillCategory    =  new Skillcategory();
        // $Skill= new Skill();
        // $this->assertTrue($SkillCategory->skills->contains($Skill));
        // $this->assertTrue( $SkillCategory->Skill->contains($SkillCategory));
        // Method 1: Count that a Skills within category collection exists.
        // $this->assertEquals(1, $post->comments->count());
        $this->assertEquals(1, $discipline->skillcategories->count());
        $this->assertEquals(1, $SkillCategory->Skill->count());
        // $this->assertEquals(1, $Skill->skillcategory->count());
        // Method 3: Comments are related to posts and is a collection instance.
        // $this->assertTrue($skillCategory->Skill->contains($SkillCategory));
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->skillcategories);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $SkillCategory->Skill);
        $this->assertInstanceOf(Skillcategory::class,$Skill->SkillCategory);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->exercisesets);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->courseclasses);
        // $this->assertTrue(true);

    }

}
