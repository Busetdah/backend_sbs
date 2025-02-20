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

        $dateFilter = "";
        $bindings   = [];

        if ($start && $end) {
            $dateFilter = "WHERE timestamp BETWEEN ? AND ?";
            $bindings   = [$start, $end];
        }

        $bindings = array_merge($bindings, [$limit, $offset]);

        $query = "SELECT timestamp as waktu, pressure, gatevalve, predicted_weight, status 
                  FROM predicted_data 
                  $dateFilter 
                  ORDER BY timestamp ASC 
                  LIMIT ? OFFSET ?";

        $data = DB::select($query, $bindings);

        return response()->json($data);
    }
}
