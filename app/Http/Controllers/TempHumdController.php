<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TempHumdController extends Controller
{
    public function index()
    {
        $response = new StreamedResponse(function () {
            ignore_user_abort(true);
            set_time_limit(0);

            $lastTemp = null;
            $lastHumd = null;

            while (true) {
                try {
                    $latestData = DB::table('temphumd_produk')
                        ->select('temp', 'humd')
                        ->orderBy('waktu', 'desc')
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
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }
}
