<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryPredictController extends Controller
{
    public function historyPredict(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('data_training')->orderBy('waktu', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('waktu', [$startDate, $endDate]);
        }

        $historypredict = $query->limit(100)->get();

        if ($historypredict->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data dalam history'], 200);
        }

        return response()->json($historypredict, 200);
    }
}
