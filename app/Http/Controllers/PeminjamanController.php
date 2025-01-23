<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DataBuku;
use App\Models\LogBook;
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

            // Tambahkan log peminjaman
            LogBook::create([
                'nama_peminjam' => Auth::user()->username,
                'judul_buku' => $buku->title,
                'tanggal' => now()->toDateString(),
                'status' => 'dipinjam',
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
    public function index()
    {
        try {
            $peminjaman = Peminjaman::all();
            return response()->json([
                'loans' => $peminjaman
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching peminjaman: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal mengambil data peminjaman'
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);

            // Kembalikan stok buku
            $buku = DataBuku::where('title', $peminjaman->judul_buku)->first();
            if ($buku) {
                $buku->update([
                    'available_stock' => $buku->available_stock + $peminjaman->jumlah
                ]);

                // Tambahkan log pengembalian
                LogBook::create([
                    'nama_peminjam' => $peminjaman->nama_peminjam,
                    'judul_buku' => $peminjaman->judul_buku,
                    'tanggal' => now()->toDateString(),
                    'status' => 'dikembalikan',
                ]);
            }

            $peminjaman->delete();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting peminjaman: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus peminjaman'
            ], 500);
        }
    }
}
