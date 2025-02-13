<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PredictController extends Controller
{
    public function predict(Request $request)
    {
        $pythonPath = "C:\Users\apria\AppData\Local\Programs\Python\Python313\python.exe";
        $scriptPath = base_path('predict.py');

        $data = DB::connection('mysql_secondary')
            ->table('testing_data')
            ->orderBy('timestamp', 'desc')
            ->paginate(10);

        if ($data->isEmpty()) {
            return response()->json(["error" => "No data available"], 400);
        }

        $formattedData = $data->items();
        $tempFile = storage_path('app/temp_input.json');
        file_put_contents($tempFile, json_encode($formattedData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $command = "\"$pythonPath\" \"$scriptPath\" \"$tempFile\"";
        Log::info("Menjalankan perintah: $command");

        $output = shell_exec($command);
        Log::info("Output dari Python: " . $output);

        $outputData = json_decode($output, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("Output tidak valid dari Python: " . json_last_error_msg());
            return response()->json(["error" => "Output tidak valid dari Python"], 500);
        }

        return response()->json([
            "results" => $outputData,
            "pagination" => $data->toArray(),
        ]);
    }
}
