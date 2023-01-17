<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class RecommendationController extends Controller
{
    public function  __invoke($city)
    {
        $response =  WeatherController::getForecast($city);
        
        json_decode($response->getBody());

        $arr = [];
        $days = 0;
        $myobj = new stdClass;
        $myTime = Carbon::now()->format('Y-m-d H:00:00');
        $myobj->city = $city;
        foreach($response['forecastTimestamps'] as $key) {
            if($myTime === $key['forecastTimeUtc']){
                $days += 1;
                
                $arr2 = [
                    'date' => strtok($key['forecastTimeUtc'],' '),
                    'weather_forecast' => $key['conditionCode'],
                    'products' => ProductResource::collection(Product::all())->random(2)
                ];

                array_push($arr, $arr2);
                
                $myTime = Carbon::now()-> addDays($days)->format('Y-m-d H:00:00');
                if($days == 3){
                    break;
                }
            };
        }
        $myobj->recommendations = $arr;
        return $myobj;
    }
        
}
