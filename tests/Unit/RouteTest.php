<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
       
        $response=$this->get("/");
        $response->assertStatus(200);
        // $this->assertTrue(true);
        
    // /asas
    $response=$this->get("/asas");
        $response->assertStatus(404);
    }
    public function testRoute()
    {
        $response=$this->get("/api/gamepack/1.0/topics");
        $response->assertStatus(200);
    }
}
