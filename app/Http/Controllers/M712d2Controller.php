<?php

namespace App\Http\Controllers;

use App\Models\m712d_2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class M712d2Controller extends Controller
{
    public function index()
    {
        $posts = m712d_2::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = m712d_2::create($request->all());
        return response()->json($post, 201);
    }
}
