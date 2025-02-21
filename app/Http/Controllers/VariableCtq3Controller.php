<?php

namespace App\Http\Controllers;

use App\Models\variable_ctq_3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VariableCtq3Controller extends Controller
{
    public function index()
    {
        return response()->stream(function () {
            while (true) {
                $lastResetId = DB::table('reset_timestamps')
                    ->orderBy('id', 'desc')
                    ->value('predicted_data_id');

                if (!$lastResetId) {
                    $lastResetId = 0; 
                }

                $statusCounts = DB::select("
                    SELECT 
                        SUM(CASE WHEN status = 'onspec' THEN 1 ELSE 0 END) AS onspec
                    FROM predicted_data
                    WHERE id > ?
                ", [$lastResetId])[0];

                $predicted_weight = DB::select("
                    SELECT predicted_weight, status 
                    FROM predicted_data 
                    WHERE id > ?
                    ORDER BY id DESC 
                    LIMIT 1
                ", [$lastResetId]);

                $data = [
                    'status_counts' => [
                        'onspec' => $statusCounts->onspec ?? 0,
                        'offspec' => 0,
                    ],
                    'predicted_weight' => $predicted_weight ? $predicted_weight[0] : null,
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

    public function resetData()
    {
        try {
            $lastPredictedId = DB::table('predicted_data')
                ->orderBy('id', 'desc')
                ->value('id');

            if (!$lastPredictedId) {
                $lastPredictedId = 0;
            }

            DB::table('reset_timestamps')->insert([
                'predicted_data_id' => $lastPredictedId,
            ]);

            return response()->json([
                'message' => 'Reset berhasil',
                'reset_id' => $lastPredictedId,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal reset data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $post = variable_ctq_3::create($request->all());
        return response()->json($post, 201);
    }

}
