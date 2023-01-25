<?php

namespace App\Services;

use stdClass;
use Carbon\Carbon;
use App\Services\RecommendationService;


class FormatService
{
    public static function formatResponse($response, $city)
    {
        // array to store recommendations
        $recommendations = [];
        // Output object
        $output = new stdClass;
        
        $days = 0;
        // Current time in Lithuania
        $current_time = Carbon::now()->addHours(2)->format('Y-m-d H:00:00');

        $output->city = $city;

        // Loop for finding the recommendations for 3 days
        foreach ($response['forecastTimestamps'] as $key) {
            if ($current_time === $key['forecastTimeUtc']) {
                   
                $days += 1;

                $recommendations_for_date = [
                    'date' => strtok($key['forecastTimeUtc'], ' '),
                    'weather_forecast' => $key['conditionCode'],
                    // Get recommended products
                    'products' => RecommendationService::getRecommendation($key['conditionCode'])
                ];
                
                array_push($recommendations, $recommendations_for_date);
                $current_time = Carbon::now()->addDays($days)->format('Y-m-d H:00:00');

                if ($days === 3) {
                    $output->recommendations = $recommendations;
                    $output->source = 'Weather information source: LHMT';

                    return $output;
                }
            };
        }
        
    }
}

