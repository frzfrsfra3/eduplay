<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Curriculum_gradelist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory ;
use Request;
class Disciplines extends TestCase
{
    use HasFactory;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testing()
    {
         $Curriculum_gradelist= factory(Curriculum_gradelist::class)->create();
        $discipline    = factory(Discipline::class)->create(['curriculum_gradelist_id'=>$Curriculum_gradelist->id]);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->exercisesets);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->courseclasses);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->exercisesets);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->classes);
         $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $discipline->curriculum_gradelist);
    }
}
