<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SensorDataController extends Controller
{
    public function getData(Request $request)
    {
        $response = new StreamedResponse(function () use ($request) {
            while (true) {
                $query = DB::table('temphumd_produk')
                    ->select('temp', 'humd', 'waktu')
                    ->orderBy('waktu', 'desc');

                if ($request->has('start') && $request->has('end')) {
                    $start = Carbon::parse($request->start);
                    $end = Carbon::parse($request->end);
                    $query->whereBetween('waktu', [$start, $end]);
                } else {
                    $query->limit(100);
                }

                $data = $query->get();

                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();

                sleep(1);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }
}
