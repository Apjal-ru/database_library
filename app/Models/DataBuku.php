<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBuku extends Model
{
    public $timestamps = false;
    protected $table = 'data_buku';
    protected $fillable = [
        'stock',
        'available_stock',
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
