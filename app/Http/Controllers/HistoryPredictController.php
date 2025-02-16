<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryPredictController extends Controller
{
    public function historyPredict()
    {
        $historypredict = DB::table('data_training')->get();

        if ($historypredict->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data dalam history'], 200);
        }

        return response()->json($historypredict, 200);
    }
}
