<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataTrainingController extends Controller
{
    public function store()
    {
        $pressureData = DB::connection('mysql_secondary')
            ->table('data_pressure')
            ->where('pressure', '!=', 0)
            ->get(['pressure']);

        $weigherData = DB::connection('mysql_secondary')
            ->table('data_weigher')
            ->where('weigher', '>', 0) // Hanya ambil data dengan weigher > 0
            ->get(['weigher', 'status']); // Ambil juga kolom status

        $gatevalveData = DB::connection('mysql_secondary')
            ->table('data_gatevalve')
            ->where('gatevalve', '!=', 0)
            ->get(['gatevalve']);

        // Gabungkan data berdasarkan indeks
        $dataTraining = [];
        foreach ($weigherData as $index => $weigher) {
            $pressure = $pressureData[$index]->pressure ?? null;
            $gatevalve = $gatevalveData[$index]->gatevalve ?? null;
            $weight = $weigher->weigher;
            $status = $weigher->status;

            // Masukkan hanya jika pressure & gatevalve tidak NULL
            if (!is_null($pressure) && !is_null($gatevalve)) {
                $dataTraining[] = [
                    'waktu'      => now(),
                    'pressure'   => $pressure,
                    'gatevalve'  => $gatevalve,
                    'weight'     => $weight,
                    'status'     => $status, // Status tetap dimasukkan
                ];
            }
        }

        // Simpan ke tabel data_training jika ada data valid
        if (!empty($dataTraining)) {
            DB::connection('mysql_secondary')->table('data_training')->insert($dataTraining);
            return response()->json(['message' => 'Data berhasil dimasukkan ke data_training'], 201);
        }

        return response()->json(['message' => 'Tidak ada data yang valid untuk dimasukkan'], 200);
    }
}
