<?php

namespace App\Http\Controllers;

use App\Models\variable_ctq_3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VariableCtq3Controller extends Controller
{
    public function index()
    {
        $posts = variable_ctq_3::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = variable_ctq_3::create($request->all());
        return response()->json($post, 201);
    }
}
