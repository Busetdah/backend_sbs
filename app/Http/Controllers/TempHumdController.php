<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TempHumdController extends Controller
{
    public function index()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Access-Control-Allow-Origin: *');
        header('X-Accel-Buffering: no');

        $lastTemp = null;
        $lastHumd = null;

        while (true) {
            try {
                $latestData = DB::table('temphumd_produk')
                    ->select('temp', 'humd')
                    ->orderBy('waktu', 'desc')
                    ->limit(1)
                    ->first();

                if ($latestData && ($latestData->temp !== $lastTemp || $latestData->humd !== $lastHumd)) {
                    $lastTemp = $latestData->temp;
                    $lastHumd = $latestData->humd;

                    $data = [
                        'temp' => $latestData->temp,
                        'humd' => $latestData->humd,
                    ];

                    echo "data: " . json_encode($data) . "\n\n";
                    ob_flush();
                    flush();
                }
            } catch (\Exception $e) {
                Log::error('Error dalam SSE: ' . $e->getMessage());
                echo "data: {\"error\": \"Terjadi kesalahan pada server\"}\n\n";
                ob_flush();
                flush();
            }

            sleep(1);
        }
    }
}
