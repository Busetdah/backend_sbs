<?php

namespace App\Http\Controllers;

use App\Models\ews;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EwsController extends Controller
{
    public function index()
    {
        $posts = ews::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = ews::create($request->all());
        return response()->json($post, 201);
    }
}
