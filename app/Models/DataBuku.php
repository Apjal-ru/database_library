<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBuku extends Model
{
    protected $table = 'data_buku';
    protected $fillable = [
        'stock',
        'title',
        'author',
        'publisher',
        'year'
    ];

    // Relasi dengan peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
