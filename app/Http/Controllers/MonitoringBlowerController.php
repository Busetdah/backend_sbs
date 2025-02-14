<?php

namespace App\Http\Controllers;

use App\Models\monitoring_blower;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringBlowerController extends Controller
{
    public function index()
    {
        $posts = monitoring_blower::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = monitoring_blower::create($request->all());
        return response()->json($post, 201);
    }
}
