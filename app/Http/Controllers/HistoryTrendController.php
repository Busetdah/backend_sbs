<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryTrendController extends Controller
{
    public function index(Request $request)
    {
        $limit  = $request->query('limit', 100);
        $page   = $request->query('page', 1);
        $offset = ($page - 1) * $limit;

        $start = $request->query('start');
        $end   = $request->query('end');  

        $dateFilterTemphumd = "";
        $dateFilterWeigher  = "";
        $dateFilterPressure = "";
        $dateFilterLpvsv1   = "";
        $dateFilterLpvsv2   = "";
        
        $bindingsTemphumd = [];
        $bindingsWeigher  = [];
        $bindingsPressure = [];
        $bindingsLpvsv1   = [];
        $bindingsLpvsv2   = [];

        if ($start && $end) {
            $dateFilterTemphumd = "WHERE waktu BETWEEN ? AND ?";
            $dateFilterWeigher  = "WHERE waktu BETWEEN ? AND ?";
            $dateFilterPressure = "WHERE timestamp BETWEEN ? AND ?";
            $dateFilterLpvsv1   = "WHERE waktu BETWEEN ? AND ?";
            $dateFilterLpvsv2   = "WHERE waktu BETWEEN ? AND ?";

            $bindingsTemphumd = [$start, $end];
            $bindingsWeigher  = [$start, $end];
            $bindingsPressure = [$start, $end];
            $bindingsLpvsv1   = [$start, $end];
            $bindingsLpvsv2   = [$start, $end];
        }

        $bindingsTemphumd = array_merge($bindingsTemphumd, [$limit, $offset]);
        $bindingsWeigher  = array_merge($bindingsWeigher, [$limit, $offset]);
        $bindingsPressure = array_merge($bindingsPressure, [$limit, $offset]);
        $bindingsLpvsv1   = array_merge($bindingsLpvsv1, [$limit, $offset]);
        $bindingsLpvsv2   = array_merge($bindingsLpvsv2, [$limit, $offset]);

        $temphumdQuery = "SELECT temp, humd, waktu FROM temphumd_sekitar $dateFilterTemphumd ORDER BY waktu DESC LIMIT ? OFFSET ?";
        $weigherQuery  = "SELECT weigher, waktu FROM data_weigher $dateFilterWeigher ORDER BY waktu DESC LIMIT ? OFFSET ?";
        $pressureQuery = "SELECT pressure, timestamp as waktu FROM predicted_data $dateFilterPressure ORDER BY timestamp DESC LIMIT ? OFFSET ?";
        $lpvsv1Query   = "SELECT lpvweigher1, svweigher1, waktu FROM lpvsvweigher1 $dateFilterLpvsv1 ORDER BY waktu DESC LIMIT ? OFFSET ?";
        $lpvsv2Query   = "SELECT lpvweigher2, svweigher2, waktu FROM lpvsvweigher2 $dateFilterLpvsv2 ORDER BY waktu DESC LIMIT ? OFFSET ?";

        $temphumd = DB::select($temphumdQuery, $bindingsTemphumd);
        $weigher  = DB::select($weigherQuery, $bindingsWeigher);
        $pressure = DB::select($pressureQuery, $bindingsPressure);
        $lpvsv1   = DB::select($lpvsv1Query, $bindingsLpvsv1);
        $lpvsv2   = DB::select($lpvsv2Query, $bindingsLpvsv2);

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
                'bucket1SV' => $lpvsv1[$i]->svweigher1  ?? null,
                'bucket2PV' => $lpvsv2[$i]->lpvweigher2 ?? null,
                'bucket2SV' => $lpvsv2[$i]->svweigher2  ?? null,
            ];
        }

        return response()->json($mergedData);
    }
}
