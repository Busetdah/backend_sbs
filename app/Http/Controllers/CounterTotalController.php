<?php

namespace App\Http\Controllers;

use App\Models\counter_total;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CounterTotalController extends Controller
{
    public function index()
    {
        $posts = counter_total::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = counter_total::create($request->all());
        return response()->json($post, 201);
    }
}
