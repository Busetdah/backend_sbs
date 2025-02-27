<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusGumpalanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $page = $request->query('page', 1);
        if ($page > 100) {
            $page = 100;
        }

        $data = DB::connection('mysql_secondary')
            ->table('hasil_klasifikasi')
            ->select('id', 'status_gumpalan', 'waktu')
            ->where('status', 'menggumpal')
            ->orderBy('waktu', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($data);
    }
}
