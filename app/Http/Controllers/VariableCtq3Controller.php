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
                    ->value('id') ?? 0;

                $latestData = DB::select("SELECT * FROM predicted_data WHERE id > ? ORDER BY id DESC LIMIT 1", [$lastResetId]);

                $data = [
                    'latest_data' => $latestData ? $latestData[0] : null,
                    'last_reset_id' => $lastResetId
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
                'id_predicted_data' => $lastPredictedId,
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
