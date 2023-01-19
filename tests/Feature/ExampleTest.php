<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/api/products/recommend/kaunas');

        $response->assertStatus(200);
    }

    // public function test_the_application_returns_bad_request_response()
    // {
    //     $response = $this->get('/api/products/recommend/123');

    //     $response->assertStatus(400);
    // }
}
