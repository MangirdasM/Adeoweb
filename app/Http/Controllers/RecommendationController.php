<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Services\FormatService;
use App\Services\WeatherService;
use Spatie\FlareClient\Http\Response;

class RecommendationController extends Controller
{   
    public function  index(string $city)
    {
        // Get forecast for city
        $response =  WeatherService::getForecast($city);

        json_decode($response->getBody());
        
        // Get formated response
        $data = FormatService::formatResponse($response, $city);

        return response()->json($data, $statuscode = 200);  
    }
}
