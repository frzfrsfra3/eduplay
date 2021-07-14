<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Input As Inputt;
use App\Models\User;
use Request;
class InsertionTest extends TestCase
{

    //  use Inputt;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    public function test_that_a_task_can_be_added()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/register', [

            'name' => 'mhdferas',
            'email' => 'mhd@localhost',
            'password' => bcrypt('12345'),
            'remember_token' => str_random(10),
            'is_email_active' => 1,
        ]);
        $response->assertStatus(200);
        $this->assertTrue(count(User::all()) > 1);
    }
}
