<?php

namespace App\Http\Controllers;

use App\Models\DataBuku;
use Illuminate\Http\Request;

class BookController extends Controller
{
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
}
