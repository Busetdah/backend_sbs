<?php

namespace App\Http\Controllers;

use App\Models\monitoring_room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonitoringRoomController extends Controller
{
    public function index()
    {
        $posts = monitoring_room::latest('waktu')->first();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $post = monitoring_room::create($request->all());
        return response()->json($post, 201);
    }
}
