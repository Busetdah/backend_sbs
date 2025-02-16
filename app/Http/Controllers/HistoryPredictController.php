<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryPredictController extends Controller
{
    public function historyPredict(Request $request)
{
    $query = DB::table('data_training');

    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('waktu', [$request->start_date, $request->end_date]);
    }

    $historypredict = $query->limit(100)->get();

    return response()->json($historypredict, 200);
}

}
