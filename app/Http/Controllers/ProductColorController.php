<?php

namespace App\Http\Controllers;

use App\Models\product_color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductColorController extends Controller
{
    public function index()
    {
        $posts = product_color::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = product_color::create($request->all());
        return response()->json($post, 201);
    }
}
