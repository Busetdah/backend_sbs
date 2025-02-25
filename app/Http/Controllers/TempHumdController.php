<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TempHumdController extends Controller
{
    public function index()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        while (true) {
            $latestData = DB::table('temphumd_produk')
                ->select('temp', 'humd')
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();

            if ($latestData) {
                $data = [
                    'temp' => $latestData->temp,
                    'humd' => $latestData->humd,
                ];

                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();
            }

            sleep(1);
        }
    }
}
