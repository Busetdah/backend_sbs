<?php

namespace App\Http\Controllers;

use App\Models\sewing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SewingController extends Controller
{
    public function index()
    {
        $posts = sewing::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = sewing::create($request->all());
        return response()->json($post, 201);
    }
}
