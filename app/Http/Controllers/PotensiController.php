<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PotensiController extends Controller
{
    public function index()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Access-Control-Allow-Origin: *');
        header('X-Accel-Buffering: no');

        while (true) {
            try {
                $latestData = DB::table('hasil_klasifikasiKNN')
                    ->select('status', 'waktu')
                    ->orderBy('waktu', 'desc')
                    ->limit(1)
                    ->first();

                if ($latestData) {
                    echo "data: " . json_encode($latestData) . "\n\n";
                    ob_flush();
                    flush();
                }
            } catch (\Exception $e) {
                Log::error('Error in SSE: ' . $e->getMessage());
                echo "data: {\"error\": \"Terjadi kesalahan pada server\"}\n\n";
                ob_flush();
                flush();
            }

            sleep(1);
        }
    }
}
