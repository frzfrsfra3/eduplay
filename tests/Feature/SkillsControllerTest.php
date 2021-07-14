<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Skill;
use App\Models\Skillcategory;
use App\Model\User;
class SkillsControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }
    public function it_can_show_the_create_carousel_page()
    {
       $skillcat = factory(Skillcategory::class)->create();
        $this
            ->actingAs($skillcat, 'admin')
            ->get(route('admin.carousel.create'))
            ->assertStatus(200)
            ->assertSee('Title')
            ->assertSee('Subtitle')
            ->assertSee('Link')
            ->assertSee('Link Text')
            ->assertSee('Image');
    }
    // public function for_admin()
    // {
    //    $employee = factory(User::class)->create();
    //     $this
    //         ->actingAs($employee, 'admin')
    //         ->get(route('admin.carousel.create'))
    //         ->assertStatus(200)
    //         ->assertSee('Title')
    //         ->assertSee('Subtitle')
    //         ->assertSee('Link')
    //         ->assertSee('Link Text')
    //         ->assertSee('Image');
    // }

}
