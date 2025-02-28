<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PotensiController extends Controller
{
    public function index()
    {
        $response = new StreamedResponse(function () {
            ignore_user_abort(true);
            set_time_limit(0);

            while (true) {
                try {
                    $latestData = DB::table('hasil_klasifikasiKNN')
                        ->select('status', 'waktu')
                        ->orderBy('waktu', 'desc')
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
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }
}
