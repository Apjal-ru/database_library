<?php

namespace App\Exports;

use App\Models\LogBook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return LogBook::select('id', 'nama_peminjam', 'judul_buku', 'tanggal', 'status')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Peminjam',
            'Judul Buku',
            'Tanggal',
            'Status',
        ];
    }
}
