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
                    SELECT COUNT(*) AS onspec 
                    FROM predicted_data
                    WHERE status = 'onspec'
                ")[0];

                $predicted_weight = DB::select("
                    SELECT predicted_weight, status 
                    FROM predicted_data 
                    WHERE status = 'onspec'
                    ORDER BY timestamp DESC 
                    LIMIT 1
                ");

                $data = [
                    'status_counts'   => [
                        'onspec' => $statusCounts->onspec,
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

    public function resetData()
    {
        try {
            DB::statement("
                INSERT INTO reset_predicted_data (predicted_weight, status, timestamp)
                SELECT predicted_weight, status, timestamp FROM predicted_data
            ");

            DB::table('predicted_data')->truncate();

            return response()->json(['message' => 'Data berhasil direset dan disimpan ke reset_predicted_data'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal reset data', 'error' => $e->getMessage()], 500);
        }
    }
}
