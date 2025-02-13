<?php

namespace App\Http\Controllers;

use App\Models\product_temperature;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductTemperatureController extends Controller
{
    public function index()
    {
        $latestPost = product_temperature::latest('created_at')->first();

        return response()->json($latestPost);
    }

    public function store(Request $request)
    {
        $post = product_temperature::create($request->all());
        return response()->json($post, 201);
    }
}
