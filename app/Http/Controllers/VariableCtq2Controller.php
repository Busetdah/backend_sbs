<?php

namespace App\Http\Controllers;

use App\Models\variable_ctq_2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariableCtq2Controller extends Controller
{
    public function index()
    {
        return response()->stream(function () {
            while (true) {
                $predicted_data = DB::select("SELECT gatevalve FROM predicted_data ORDER BY timestamp DESC LIMIT 1");
        
                $data = [
                    'gatevalve' => $predicted_data ? $predicted_data[0]->gatevalve : 0,
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
        $post = variable_ctq_2::create($request->all());
        return response()->json($post, 201);
    }
}
