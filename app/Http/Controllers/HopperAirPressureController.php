<?php

namespace App\Http\Controllers;

use App\Models\hopper_air_pressure;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HopperAirPressureController extends Controller
{
    public function index()
    {
        return response()->stream(function () {
            while (true) {
                $latestPressure = DB::select("SELECT pressure FROM data_pressure ORDER BY waktu DESC LIMIT 1");
                
                $data = [
                    'pressure' => $latestPressure ? $latestPressure[0]->pressure : 0
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
        $post = hopper_air_pressure::create($request->all());
        return response()->json($post, 201);
    }
}
