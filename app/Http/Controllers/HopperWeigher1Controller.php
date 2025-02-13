<?php

namespace App\Http\Controllers;

use App\Models\hopper_weigher_1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HopperWeigher1Controller extends Controller
{
    public function index()
    {
        $posts = hopper_weigher_1::latest('waktu')->first();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = hopper_weigher_1::create($request->all());
        return response()->json($post, 201);
    }
}
