<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RealTimeController extends Controller
{
    public function stream()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Access-Control-Allow-Origin: *');
        header('X-Accel-Buffering: no');

        while (true) {
            $tempHumd = DB::select("SELECT temp, humd FROM temphumd_sekitar ORDER BY waktu DESC LIMIT 1");
            $dataWeigher = DB::select("SELECT weigher FROM data_weigher ORDER BY waktu DESC LIMIT 1");
            $pressure = DB::select("SELECT pressure FROM predicted_data ORDER BY timestamp DESC LIMIT 1");
            $lpvsv1 = DB::select("SELECT lpvweigher1, svweigher1 FROM lpvsvweigher1 ORDER BY waktu DESC LIMIT 1");
            $lpvsv2 = DB::select("SELECT lpvweigher2, svweigher2 FROM lpvsvweigher2 ORDER BY waktu DESC LIMIT 1");

            if (
                !empty($tempHumd) && 
                !empty($dataWeigher) && 
                !empty($pressure) && 
                !empty($lpvsv1) && 
                !empty($lpvsv2)
            ) {
                $responseData = [
                    'temp'       => $tempHumd[0]->temp,
                    'humd'       => $tempHumd[0]->humd,
                    'weigher'    => $dataWeigher[0]->weigher,
                    'pressure'   => $pressure[0]->pressure,
                    'bucket1PV'  => $lpvsv1[0]->lpvweigher1,
                    'bucket1SV'  => $lpvsv1[0]->svweigher1,
                    'bucket2PV'  => $lpvsv2[0]->lpvweigher2,
                    'bucket2SV'  => $lpvsv2[0]->svweigher2,
                ];
                echo "data: " . json_encode($responseData) . "\n\n";
                ob_flush();
                flush();
            }
            if (connection_aborted()) {
                break;
            }
            sleep(1);
        }
    }
}
