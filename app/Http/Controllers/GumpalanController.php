<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HistoryGumpalan;

class GumpalanController extends Controller
{
    public function stream()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Access-Control-Allow-Origin: *');
        header('X-Accel-Buffering: no');

        while (true) {
            $latestStatus = DB::table('status_gumpalan')
                ->where('status', 'menggumpal')
                ->orderBy('waktu', 'desc')
                ->first();

            if ($latestStatus) {
                $lastHistory = DB::table('history_gumpalan')
                    ->orderBy('waktu', 'desc')
                    ->first();

                if (!$lastHistory || $lastHistory->waktu < $latestStatus->waktu) {
                    HistoryGumpalan::create(['waktu' => $latestStatus->waktu]);
                }

                echo "data: " . json_encode(['status' => 'menggumpal', 'waktu' => $latestStatus->waktu]) . "\n\n";
                ob_flush();
                flush();
            }

            sleep(1);
        }
    }
}
