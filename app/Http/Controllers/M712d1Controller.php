<?php

namespace App\Http\Controllers;

use App\Models\m712d_1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class M712d1Controller extends Controller
{
    public function index()
    {
        $posts = m712d_1::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = m712d_1::create($request->all());
        return response()->json($post, 201);
    }
}
