<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryTrendController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 100);
        $page  = $request->query('page', 1);
        $offset = ($page - 1) * $limit;

        $temphumd = DB::select("SELECT temp, humd, waktu FROM temphumd_sekitar ORDER BY waktu DESC LIMIT ? OFFSET ?", [$limit, $offset]);
        $weigher  = DB::select("SELECT weigher, waktu FROM data_weigher ORDER BY waktu DESC LIMIT ? OFFSET ?", [$limit, $offset]);
        $pressure = DB::select("SELECT pressure, timestamp as waktu FROM predicted_data ORDER BY timestamp DESC LIMIT ? OFFSET ?", [$limit, $offset]);
        $lpvsv1   = DB::select("SELECT lpvweigher1, svweigher1, waktu FROM lpvsvweigher1 ORDER BY waktu DESC LIMIT ? OFFSET ?", [$limit, $offset]);
        $lpvsv2   = DB::select("SELECT lpvweigher2, svweigher2, waktu FROM lpvsvweigher2 ORDER BY waktu DESC LIMIT ? OFFSET ?", [$limit, $offset]);

        $mergedData = [];
        $count = count($temphumd);
        for ($i = 0; $i < $count; $i++) {
            $mergedData[] = [
                'time'      => $temphumd[$i]->waktu,
                'temp'      => $temphumd[$i]->temp,
                'humd'      => $temphumd[$i]->humd,
                'weigher'   => $weigher[$i]->weigher   ?? null,
                'pressure'  => $pressure[$i]->pressure ?? null,
                'bucket1PV' => $lpvsv1[$i]->lpvweigher1 ?? null,
                'bucket1SV' => $lpvsv1[$i]->svweigher1 ?? null,
                'bucket2PV' => $lpvsv2[$i]->lpvweigher2 ?? null,
                'bucket2SV' => $lpvsv2[$i]->svweigher2 ?? null,
            ];
        }

        return response()->json($mergedData);
    }
}
