<?php

namespace App\Http\Controllers;

use App\Models\DataBuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private function checkDuplicate($title, $publisher, $year, $excludeId = null)
    {
        $query = DataBuku::where('title', $title)
            ->where('publisher', $publisher)
            ->where('year', $year);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stock' => 'required|numeric',
            'title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'year' => 'required|numeric'
        ]);

        try {
            // Cek duplikasi
            if ($this->checkDuplicate($validated['title'], $validated['publisher'], $validated['year'])) {
                return response()->json([
                    'message' => 'Buku dengan judul, penerbit, dan tahun yang sama sudah ada'
                ], 422);
            }

            $book = DataBuku::create([
                'stock' => $validated['stock'],
                'available_stock' => $validated['stock'],
                'title' => $validated['title'],
                'author' => $validated['author'],
                'publisher' => $validated['publisher'],
                'year' => $validated['year']
            ]);

            return response()->json([
                'message' => 'Buku berhasil ditambahkan',
                'book' => $book
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan buku: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'stock' => 'required|numeric',
            'title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'year' => 'required|numeric'
        ]);

        try {
            // Cek duplikasi, exclude buku yang sedang diedit
            if ($this->checkDuplicate($validated['title'], $validated['publisher'], $validated['year'], $id)) {
                return response()->json([
                    'message' => 'Sudah ada buku yang serupa'
                ], 422);
            }

            $book = DataBuku::findOrFail($id);
            $book->update([
                'stock' => $validated['stock'],
                'available_stock' => $validated['stock'],
                'title' => $validated['title'],
                'author' => $validated['author'],
                'publisher' => $validated['publisher'],
                'year' => $validated['year']
            ]);

            return response()->json([
                'message' => 'Buku berhasil diperbarui',
                'book' => $book
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui buku: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $book = DataBuku::findOrFail($id);

            $peminjaman = Peminjaman::where('id', $id)->whereNull(columns: 'tanggal_peminjaman')->first();
            if ($peminjaman) {
                return response()->json([
                    'message' => 'Buku sedang dipinjam, tidak dapat dihapus atau dikurangi stoknya.'
                ], 422);
            }

            $book->delete();

            return response()->json([
                'message' => 'Buku berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus buku: ' . $e->getMessage()
            ], 500);
        }
    }
    public function index()
    {
        try {
            $books = DataBuku::all();
            return response()->json([
                'books' => $books,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data buku: ' . $e->getMessage(),
            ], 500);
        }
    }
}
