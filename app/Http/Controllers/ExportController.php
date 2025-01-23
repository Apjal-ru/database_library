<?php

namespace App\Http\Controllers;

use App\Exports\LogExport;
use App\Models\LogBook;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        // Cek apakah ada data di LogBook
        if (LogBook::count() === 0) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diekspor.');
        }

        // Nama file export yang dihasilkan
        $fileName = 'log_books_' . date('Y_m_d_His') . '.xlsx';

        // Menggunakan Laravel Excel untuk export
        return Excel::download(new LogExport, $fileName);
    }
}
