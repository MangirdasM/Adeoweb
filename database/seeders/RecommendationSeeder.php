<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Recommendation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $items = Product::all()->pluck('name')->toArray();
        $suitable_weather = [
            'clear' => ['Pants', 'Hat', 'Sweater', 'Shorts'],
            'partly-cloudy' => ['Pants', 'Hat', 'Sweater', 'Shorts'],
            'cloudy-with-sunny-intervals' => ['Pants', 'Hat', 'Sweater', 'Shorts'],
            'cloudy' => ['Pants', 'Hat', 'Sweater', 'Coat'],
            'thunder' => ['Pants', 'Sweater', 'Coat'],
            'isolated-thunder' => ['Pants', 'Sweater', 'Coat'],
            'thunderstorms' => ['Pants', 'Sweater', 'Coat'],
            'heavy-rain-with-thunderstorms' => ['Pants', 'Sweater', 'Coat', 'Umbrella'],
            'light-rain' => ['Pants', 'Sweater', 'Coat', 'Umbrella'],
            'rain' => ['Pants', 'Sweater', 'Coat', 'Umbrella'],
            'heavy-rain' => ['Pants', 'Sweater', 'Coat', 'Umbrella'],
            'light-sleet' => ['Pants', 'Sweater', 'Coat', 'Umbrella'],
            'sleet' => ['Hat', 'Sweater', 'Coat', 'Umbrella'],
            'freezing-rain' => ['Pants', 'Hat', 'Sweater', 'Coat', 'Shorts', 'Umbrella'],
            'hail' => ['Pants', 'Hat', 'Sweater', 'Coat', 'Shorts', 'Umbrella'],
            'light-snow' => ['Pants', 'Hat', 'Sweater', 'Coat'],
            'snow' => ['Pants', 'Hat', 'Sweater', 'Coat'],
            'heavy-snow' => ['Pants', 'Hat', 'Sweater', 'Coat'],
            'fog' => ['Pants', 'Hat', 'sweater', 'Coat', 'Shorts'],
        ];

        foreach ($suitable_weather as $key => $value) {
            $fullItem = [
                
                'weather' => $key,
                'suitable_clothes' => $value
                
            ];
            Recommendation::create($fullItem);
        };
    }
}
