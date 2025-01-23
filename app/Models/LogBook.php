<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogBook extends Model
{
    public $timestamps = false;
    protected $table = 'log_books';

    protected $fillable = [
        'nama_peminjam',
        'judul_buku',
        'tanggal',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nama_peminjam', 'username');
    }

    public function dataBuku()
    {
        return $this->belongsTo(DataBuku::class, 'judul_buku', 'title');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
