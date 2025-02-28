<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\HistoryGumpalan;

class GumpalanController extends Controller
{
    public function stream()
    {
        $response = new StreamedResponse(function () {
            while (true) {
                $latestStatus = DB::table('hasil_klasifikasiKNN')
                    ->where('status', 'Menggumpal')
                    ->orderBy('waktu', 'desc')
                    ->first();

                if ($latestStatus) {
                    $lastHistory = DB::table('history_gumpalan')
                        ->orderBy('waktu', 'desc')
                        ->first();

                    if (!$lastHistory || $lastHistory->waktu < $latestStatus->waktu) {
                        HistoryGumpalan::create(['waktu' => $latestStatus->waktu]);
                    }

                    echo "data: " . json_encode([
                        'status' => 'menggumpal',
                        'waktu' => $latestStatus->waktu
                    ]) . "\n\n";

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
