<?php

namespace App\Http\Controllers;

use App\Models\monitoring_room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringRoomController extends Controller
{
    public function index()
    {
        return response()->stream(function () {
            while (true) {
                $temphumd_sekitar = DB::select("SELECT temp, humd FROM temphumd_sekitar ORDER BY waktu DESC LIMIT 1");
        
                $data = [
                    'temp' => $temphumd_sekitar ? $temphumd_sekitar[0]->temp : 0,
                    'humd' => $temphumd_sekitar ? $temphumd_sekitar[0]->humd : 0
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
        $post = monitoring_room::create($request->all());
        return response()->json($post, 201);
    }
}
