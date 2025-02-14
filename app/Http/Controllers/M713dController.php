<?php

namespace App\Http\Controllers;

use App\Models\m713d;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class M713dController extends Controller
{
    public function index()
    {
        $posts = m713d::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = m713d::create($request->all());
        return response()->json($post, 201);
    }
}
