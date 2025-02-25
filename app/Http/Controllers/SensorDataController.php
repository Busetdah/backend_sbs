<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SensorDataController extends Controller
{
    public function getData(Request $request)
    {
        $query = DB::table('temphumd_produk')
            ->select('temp', 'humd', 'recorded_at')
            ->orderBy('recorded_at', 'desc');

        if ($request->has('start') && $request->has('end')) {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);
            $query->whereBetween('recorded_at', [$start, $end]);
        } else {
            $query->limit(100);
        }

        return response()->json($query->get());
    }
}
