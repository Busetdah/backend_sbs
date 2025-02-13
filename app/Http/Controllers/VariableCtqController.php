<?php

namespace App\Http\Controllers;

use App\Models\variable_ctq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VariableCtqController extends Controller
{
    public function index()
    {
        $posts = variable_ctq::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = variable_ctq::create($request->all());
        return response()->json($post, 201);
    }
}
