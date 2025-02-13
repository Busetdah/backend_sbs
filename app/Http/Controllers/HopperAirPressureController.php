<?php

namespace App\Http\Controllers;

use App\Models\hopper_air_pressure;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HopperAirPressureController extends Controller
{
    public function index()
    {
        $posts = hopper_air_pressure::latest('waktu')->first();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = hopper_air_pressure::create($request->all());
        return response()->json($post, 201);
    }
}
