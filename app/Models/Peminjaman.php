<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'pinjaman';
    protected $fillable = [
        'nama_peminjam',
        'judul_buku',
        'penerbit_buku',
        'jumlah',
        'terbit',
        'tanggal_peminjaman'
    ];
    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan buku
    public function dataBuku()
    {
        return $this->belongsTo(DataBuku::class);
    }
}
