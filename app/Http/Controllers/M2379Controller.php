<?php

namespace App\Http\Controllers;

use App\Models\m2379;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class M2379Controller extends Controller
{
    public function index()
    {
        $posts = m2379::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = m2379::create($request->all());
        return response()->json($post, 201);
    }
}
