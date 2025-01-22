<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DataBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:data_buku,id',
                'jumlah' => 'required|integer|min:1'
            ]);

            $buku = DataBuku::findOrFail($validated['id']);

            // Validasi stok
            if ($buku->available_stock < $validated['jumlah']) {
                return response()->json([
                    'message' => 'Stok buku tidak mencukupi'
                ], 422);
            }

            // Buat peminjaman
            $peminjaman = Peminjaman::create([
                'id' => $buku->id,
                'nama_peminjam' => Auth::user()->username,
                'judul_buku' => $buku->title,
                'penerbit_buku' => $buku->publisher,
                'jumlah' => $validated['jumlah'],
                'terbit' => $buku->year,
                'tanggal_peminjaman' => now()->toDateString()
            ]);

            // Update stok buku
            $buku->update([
                'available_stock' => $buku->available_stock - $validated['jumlah']
            ]);

            return response()->json([
                'message' => 'Peminjaman berhasil',
                'peminjaman' => $peminjaman
            ]);
        } catch (\Exception $e) {
            Log::error('Peminjaman error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'message' => 'Gagal melakukan peminjaman: ' . $e->getMessage()
            ], 500);
        }
    }
}
