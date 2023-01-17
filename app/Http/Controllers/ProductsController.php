<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{
    public function index(){
        return ProductResource::collection(Product::all());
    }
}
