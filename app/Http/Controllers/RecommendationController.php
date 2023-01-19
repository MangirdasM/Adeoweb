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
    public function getRecommendation($conditionCode)
    {
        $suitable =  RecommendationsResource::collection(Recommendation::where('weather', $conditionCode)->get());

        return ProductResource::collection(Product::all())->whereIn('category', $suitable[0]['suitable_clothes'])->random(2);
    }

    public function formatResponse($response, $city)
    {
        $arr = [];
        $days = 0;
        $myobj = new stdClass;
        $myTime = Carbon::now()->addHours(2)->format('Y-m-d H:00:00');
        $myobj->city = $city;

        foreach ($response['forecastTimestamps'] as $key) {
            if ($myTime === $key['forecastTimeUtc']) {
                $days += 1;

                $arr2 = [
                    'date' => strtok($key['forecastTimeUtc'], ' '),
                    'weather_forecast' => $key['conditionCode'],
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
        $response =  WeatherController::getForecast($city);

        json_decode($response->getBody());

        $data = RecommendationController::formatResponse($response, $city);

        return response()->json($data, $statuscode = 200);  
    }
}
