<?php

namespace tests\Feature;


use Tests\TestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BadgeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
       // $this->assertTrue(true);
        $response = $this->get('/');
        $response->assertStatus(200);

    }
}
