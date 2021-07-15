<?php

namespace Tests\Unit;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;
use App\Models\Curriculum_gradelist;
use App\Models\Discipline;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory ;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Request;
use App\Models\Skill;
use App\Models\Grade;
class DisciplinesTest extends TestCase
{
    use HasFactory;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @var \Illuminate\Database\Eloquent\Factory $factory */
/** @var \Illuminate\Database\Eloquent\HasFactory $hfactory */

    public function testing()
    {
        $this->assertTrue(true);
        $Skill    = factory(Skill::class)->create();
        // $discipline     = factory(Discipline::class)->create();

        // $discipline    = factory(Discipline::class)->create();
         $Curriculum_gradelist= factory(Curriculum_gradelist::class)->create();
         $grade= factory(Grade::class)->create(['curriculum_gradelist_id'=>$Curriculum_gradelist->id]);
        // $discipline    = factory(Discipline::class)->create(['curriculum_gradelist_id'=>$Curriculum_gradelist->id]);
        // $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->exercisesets);
        // $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->courseclasses);
        // $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->exercisesets);
        // $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->classes);
        //  $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->curriculum_gradelist);
    }
}
