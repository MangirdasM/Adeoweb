<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
        
    /**
     * Get forecast for city from Meteo API
     *
     * @param  city - city code
     * @return response -json response
     */
    public static function  getForecast(string $city)
    {
        return Cache::remember('city' . $city, 0, function () use ($city) {
            $response = Http::get('https://api.meteo.lt/v1/places/' . $city . '/forecasts/long-term');

            if ($response->successful()) {
                return $response ;
            }

            return response()->json([],$status = 400);
        });
    }
}