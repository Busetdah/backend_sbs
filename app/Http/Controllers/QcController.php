<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QcController extends Controller
{
    public function index()
    {
        return response()->stream(function () {
            while (true) {
                $resetTime = DB::table('reset_tracker')->orderBy('reset_time', 'desc')->value('reset_time');
                if (!$resetTime) {
                    $resetTime = '1970-01-01 00:00:00';
                }

                $statusCounts = DB::select("
                    SELECT 
                        SUM(CASE WHEN status = 'offspec' THEN 1 ELSE 0 END) AS offspec,
                        SUM(CASE WHEN status = 'onspec' THEN 1 ELSE 0 END) AS onspec
                    FROM data_weigher
                    WHERE waktu > ?
                ", [$resetTime])[0];

                $latestWeigher = DB::select("
                    SELECT * FROM data_weigher 
                    WHERE waktu > ?
                    ORDER BY waktu DESC 
                    LIMIT 1
                ", [$resetTime]);

                $data = [
                    'status_counts'   => [
                        'offspec' => "54",
                        'onspec'  => $statusCounts->onspec,
                    ],
                    'latest_weigher'  => $latestWeigher ? $latestWeigher[0] : null
                ];

                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();

                sleep(1); 
            }
        }, 200, [
            'Content-Type'  => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection'    => 'keep-alive',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'weigher' => 'required|numeric',
            'status'  => 'required|string'
        ]);

        $inserted = DB::table('data_weigher')->insert([
            'weigher' => $request->weigher,
            'status'  => $request->status,
            'waktu'   => now() 
        ]);

        if ($inserted) {
            return response()->json(['message' => 'Data berhasil disimpan'], 201);
        } else {
            return response()->json(['message' => 'Gagal menyimpan data'], 500);
        }
    }

    public function resetData()
    {
        DB::table('reset_tracker')->insert([
            'reset_time' => now()
        ]);

        return response()->json(['message' => 'Data berhasil direset'], 200);
    }
}
