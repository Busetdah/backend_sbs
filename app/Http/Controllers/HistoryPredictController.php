<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataTrainingController extends Controller
{
    public function historyPredict()
    {
        $dataTraining = DB::table('data_training')->get();

        if ($dataTraining->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data dalam history'], 200);
        }

        return response()->json($dataTraining, 200);
    }
}
