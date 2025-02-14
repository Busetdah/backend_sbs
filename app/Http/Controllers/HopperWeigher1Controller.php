<?php

namespace App\Http\Controllers;

use App\Models\hopper_weigher_1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HopperWeigher1Controller extends Controller
{
    public function index()
    {
        return response()->stream(function () {
            while (true) {
                $latestWeigher2 = DB::select("SELECT lpvweigher1, svweigher1 FROM lpvsvweigher1 ORDER BY waktu DESC LIMIT 1");
        
                $data = [
                    'lpvweigher1' => $latestWeigher1 ? $latestWeigher1[0]->lpvweigher1 : 0,
                    'svweigher1' => $latestWeigher1 ? $latestWeigher1[0]->svweigher1 : 0
                ];
        
                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();
        
                sleep(1);
            }
        }, 200, [
            'Content-Type'  => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection'    => 'keep-alive',
        ]);
    }

    public function store(Request $request)
    {
        $post = hopper_weigher_1::create($request->all());
        return response()->json($post, 201);
    }
}
