<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryPredictController extends Controller
{
    public function index(Request $request)
    {
        $limit  = (int) $request->query('limit', 100);
        $page   = (int) $request->query('page', 1);
        $offset = ($page - 1) * $limit;

        $start = $request->query('start');
        $end   = $request->query('end');

        $query = "SELECT timestamp as waktu, pressure, gatevalve, predicted_weight, status 
                  FROM predicted_data ";

        $bindings = [];
        if ($start && $end) {
            $query .= " WHERE timestamp BETWEEN ? AND ?";
            $bindings[] = $start;
            $bindings[] = $end;
        }

        $countQuery = "SELECT COUNT(*) as total FROM predicted_data" . ($start && $end ? " WHERE timestamp BETWEEN ? AND ?" : "");
        $totalData = DB::select($countQuery, $bindings);
        $total = $totalData[0]->total ?? 0;

        $query .= " ORDER BY timestamp ASC LIMIT ? OFFSET ?";
        array_push($bindings, $limit, $offset);

        $data = DB::select($query, $bindings);

        return response()->json([
            'data' => $data,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $total,
                'last_page' => ceil($total / $limit),
            ],
        ]);
    }
}
