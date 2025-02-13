<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QcController extends Controller
{
    public function index()
    {
        $statusCounts = DB::select("
            SELECT 
                SUM(CASE WHEN status = 'offspec' THEN 1 ELSE 0 END) AS offspec,
                SUM(CASE WHEN status = 'onspec' THEN 1 ELSE 0 END) AS onspec
            FROM data_weigher
        ")[0];

        $latestWeigher = DB::select("
            SELECT * FROM data_weigher 
            ORDER BY waktu DESC 
            LIMIT 1
        ");

        return response()->json([
            'status_counts'   => [
                'offspec' => $statusCounts->offspec,
                'onspec'  => $statusCounts->onspec,
            ],
            'latest_weigher'  => $latestWeigher ? $latestWeigher[0] : null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'waktu'   => 'required|date',
            'weigher' => 'required|numeric',
            'status'  => 'required|string'
        ]);

        $inserted = DB::table('data_weigher')->insert([
            // 'waktu'   => $request->waktu,
            'weigher' => $request->weigher,
            'status'  => $request->status
        ]);

        if ($inserted) {
            return response()->json(['message' => 'Data berhasil disimpan'], 201);
        } else {
            return response()->json(['message' => 'Gagal menyimpan data'], 500);
        }
    }
}
