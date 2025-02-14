<?php

namespace App\Http\Controllers;

use App\Models\variable_ctq_3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariableCtq3Controller extends Controller
{
    public function index()
    {
        return response()->stream(function () {
            while (true) {
                $statusCounts = DB::select("
                    SELECT 
                        SUM(CASE WHEN status = 'offspec' THEN 1 ELSE 0 END) AS offspec,
                        SUM(CASE WHEN status = 'onspec' THEN 1 ELSE 0 END) AS onspec
                    FROM predicted_data
                ")[0];

                $predicted_weight = DB::select("
                    SELECT predicted_weight FROM predicted_data 
                    ORDER BY timestamp DESC 
                    LIMIT 1
                ");

                $data = [
                    'status_counts'   => [
                        'offspec' => $statusCounts->offspec,
                        'onspec'  => $statusCounts->onspec,
                    ],
                    'predicted_weight'  => $predicted_weight ? $predicted_weight[0] : null
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
        $post = variable_ctq_3::create($request->all());
        return response()->json($post, 201);
    }
}
