<?php

namespace Tests\Feature;

use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_report_types_endpoint()
    {
        Sanctum::actingAs(
            \App\Models\User::factory()->create(),
            ['*']
        );

        $response = $this->get('/api/report/report-types');


        $response->assertStatus(200);
    }
}
