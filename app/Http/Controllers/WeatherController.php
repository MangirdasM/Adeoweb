<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductResource;

class WeatherController extends Controller
{
    static function  getForecast($city)
    {
        return Cache::remember('city' . $city, 60*5, function () use ($city) {
            $response = Http::get('https://api.meteo.lt/v1/places/' . $city . '/forecasts/long-term');

            if ($response->successful()) {
                
                return $response ;
            }

            return response()->json([],$status = 400);
        });
    }
}
