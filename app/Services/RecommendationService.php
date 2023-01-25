<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Recommendation;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RecommendationsResource;

class RecommendationService
{
    public static function getRecommendation(string $conditionCode)
    {   
        //dd(Recommendation::find(1)->recommend());
        // Get suitable clothes for current weather
        $suitable_clothes = Recommendation::where('weather', $conditionCode)->get();
        // Return collection of suitable clothes
        $clothes =  RecommendationsResource::collection($suitable_clothes);
        // Return 2 random products that suit current weather
        return ProductResource::collection(Product::all())->whereIn('category', $clothes[0]['suitable_clothes'])->random(2);
    }
}
