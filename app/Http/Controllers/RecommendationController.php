<?php

namespace App\Http\Controllers;

use DB;
use stdClass;
use Exception;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RecommendationsResource;

class RecommendationController extends Controller
{   
        
    /**
     * getRecommendation
     *
     * @param  mixed $conditionCode
     * @return void
     */
    public function getRecommendation($conditionCode)
    {   
        // Get suitable clothes for current weather
        $suitable_clothes = Recommendation::where('weather', $conditionCode)->get();
        // Return collection of suitable clothes
        $clothes =  RecommendationsResource::collection($suitable_clothes);

        // Return 2 random products that suit current weather
        return ProductResource::collection(Product::all())->whereIn('category', $clothes[0]['suitable_clothes'])->random(2);
    }

    public function formatResponse($response, $city)
    {
        // array to store recommendations
        $arr = [];
        // Output object
        $myobj = new stdClass;
        
        $days = 0;
        // Current time in Lithuania
        $myTime = Carbon::now()->addHours(2)->format('Y-m-d H:00:00');

        $myobj->city = $city;

        // Loop for finding the recommendations for 3 days
        foreach ($response['forecastTimestamps'] as $key) {
            if ($myTime === $key['forecastTimeUtc']) {
                $days += 1;

                $arr2 = [
                    'date' => strtok($key['forecastTimeUtc'], ' '),
                    'weather_forecast' => $key['conditionCode'],
                    // Get recommended products
                    'products' => RecommendationController::getRecommendation($key['conditionCode'])
                ];

                array_push($arr, $arr2);

                $myTime = Carbon::now()->addDays($days)->format('Y-m-d H:00:00');
                if ($days == 3) {
                    break;
                }
            };
        }
        $myobj->recommendations = $arr;
        $myobj->source = 'Weather information source: LHMT';

        return $myobj;
    }

    public function  index($city)
    {
        // Get forecast for city
        $response =  WeatherController::getForecast($city);

        json_decode($response->getBody());

        // Get formated response
        $data = RecommendationController::formatResponse($response, $city);

        return response()->json($data, $statuscode = 200);  
    }
}
