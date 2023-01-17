<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use stdClass;

class WeatherController extends Controller
{
    static function  getForecast($city)
    {
        return Cache::remember('city' . $city, 0, function() use ($city) {
            $response = Http::get('https://api.meteo.lt/v1/places/'.$city.'/forecasts/long-term');

            if ($response->successful()) {

                return $response;
            }

            return response()->json([]);
        });
    }
}
