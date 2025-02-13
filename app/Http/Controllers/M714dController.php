<?php

namespace App\Http\Controllers;

use App\Models\m714d;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class M714dController extends Controller
{
    public function index()
    {
        $posts = m714d::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = m714d::create($request->all());
        return response()->json($post, 201);
    }
}
