<?php

namespace App\Http\Controllers;

use App\Models\variable_ctq_3;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VariableCtq3Controller extends Controller
{
    public function index(Request $request)
    {
        $lastResetId = DB::table('reset_timestamps')
            ->orderBy('id', 'desc')
            ->value('id_predicted_data');

        if (!$lastResetId) {
            $lastResetId = 0;
        }

        $historyPredict = DB::table('predicted_data')
            ->where('id', '>', $lastResetId)
            ->where('status', 'onspec')
            ->orderBy('id', 'desc')
            ->paginate(100);

        return response()->json($historyPredict, 200);
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
