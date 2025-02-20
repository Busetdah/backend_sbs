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
                $lastReset = DB::table('reset_timestamps')
                    ->orderBy('timestamp', 'desc')
                    ->value('timestamp');

                if (!$lastReset) {
                    $lastReset = '1970-01-01 00:00:00';
                }

                $statusCounts = DB::select("
                    SELECT COUNT(*) AS onspec 
                    FROM predicted_data
                    WHERE status = 'onspec' AND timestamp >= ?
                ", [$lastReset])[0];

                $predicted_weight = DB::select("
                    SELECT predicted_weight, status 
                    FROM predicted_data 
                    WHERE status = 'onspec' AND timestamp >= ?
                    ORDER BY timestamp DESC 
                    LIMIT 1
                ", [$lastReset]);

                $data = [
                    'status_counts'   => [
                        'onspec' => $statusCounts->onspec,
                    ],
                    'predicted_weight'  => $predicted_weight ? $predicted_weight[0] : null,
                    'last_reset' => $lastReset
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
            $resetTime = Carbon::now();

            DB::table('reset_timestamps')->insert([
                'timestamp' => $resetTime
            ]);

            return response()->json(['message' => 'Reset berhasil', 'timestamp' => $resetTime], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal reset data', 'error' => $e->getMessage()], 500);
        }
    }
}
