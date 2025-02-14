<?php

namespace App\Http\Controllers;

use App\Models\variable_ctq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariableCtqController extends Controller
{
    public function index()
    {
        return response()->stream(function () {
            while (true) {
                $predicted_data = DB::select("SELECT pressure FROM predicted_data ORDER BY timestamp DESC LIMIT 1");
        
                $data = [
                    'pressure' => $predicted_data ? $predicted_data[0]->pressure : 0,
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
        $post = variable_ctq::create($request->all());
        return response()->json($post, 201);
    }
}
