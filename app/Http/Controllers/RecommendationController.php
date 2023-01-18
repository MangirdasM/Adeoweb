<?php

namespace App\Http\Controllers;

use DB;
use stdClass;
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

        $all =  RecommendationsResource::collection(Recommendation::all());
        $items = ProductResource::collection(Product::all());
        $avaible = [];

        foreach ($all as $key => $value) {
            if ($value['weather'] === $conditionCode) {
                $avaible = $value['suitable_clothes'];
            }
        }
        //dd($items);
        foreach ($items as $key => $value) {

            if (in_array($value['category'], $avaible)) {
                return ProductResource::collection(Product::all())->whereIn('category', $avaible)->random(2);
            }
        }
    }

    public function  __invoke($city)
    {
        $response =  WeatherController::getForecast($city);

        json_decode($response->getBody());

        $arr = [];
        $days = 0;
        $myobj = new stdClass;
        $myTime = Carbon::now()->format('Y-m-d H:00:00');
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
        return $myobj;
    }
}
