<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogBook;

class LogController extends Controller
{
    public function getLogs()
    {
        $logs = LogBook::orderBy('tanggal', 'desc')->get();
        return response()->json([
            'logs' => $logs,
        ]);
    }
}
