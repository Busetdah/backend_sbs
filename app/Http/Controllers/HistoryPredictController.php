<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryPredictController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('predicted_data')
            ->where('status', 'ONSPEC')
            ->orderBy('id', 'asc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('waktu', [$request->start_date, $request->end_date]);
        }

        $historypredict = $query->paginate(100); 

        return response()->json($historypredict, 200);
    }
}
