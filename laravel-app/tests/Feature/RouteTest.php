<?php

namespace Tests\Feature;

use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RouteTest extends TestCase
{
    use WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_report_types_endpoint()
    {


        $response = $this->get('/api/report-types');


        $response->assertStatus(200);
    }

}
