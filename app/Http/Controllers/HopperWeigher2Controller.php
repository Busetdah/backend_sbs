<?php

namespace App\Http\Controllers;

use App\Models\hopper_weigher_2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HopperWeigher2Controller extends Controller
{
    public function index()
    {
        return response()->stream(function () {
            while (true) {
                $latestWeigher2 = DB::select("SELECT lpvweigher2, svweigher2 FROM lpvsvweigher2 ORDER BY waktu DESC LIMIT 1");
        
                $data = [
                    'lpvweigher2' => $latestWeigher2 ? $latestWeigher2[0]->lpvweigher2 : 0,
                    'svweigher2' => $latestWeigher2 ? $latestWeigher2[0]->svweigher2 : 0
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
        $post = hopper_weigher_2::create($request->all());
        return response()->json($post, 201);
    }
}
