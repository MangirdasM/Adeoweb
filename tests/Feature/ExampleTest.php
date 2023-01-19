<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

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

    public function test_the_application_returns_bad_request_response()
    {
        $response = $this->get('/api/products/recommend/123');

        $response->assertStatus(400);
    }

    public function test_the_application_returns_city_recommendations_source()
    {
        $response = $this->getJson('/api/products/recommend/kaunas');

        $response
        ->assertJson(fn (AssertableJson $json) =>
            $json->hasall('city', 'recommendations', 'source'));
    }

    public function test_the_application_recommendations_have_date_forecast_products()
    {
        $response = $this->getJson('/api/products/recommend/kaunas');

        $response
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('recommendations.0', fn ($json) =>
            $json->hasany('date', 'weather_forecast', 'products'))->etc()
        );
    }
}
