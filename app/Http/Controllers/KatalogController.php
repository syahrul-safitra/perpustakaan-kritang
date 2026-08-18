<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Pencarian buku
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
        }

        // Filter kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $bukus = $query->latest()->paginate(12)->withQueryString();
        $kategoriList = Kategori::orderBy('nama_kategori', 'asc')->get();

        // Sesuai struktur folder yang kamu rancang di awal: resources/views/siswa/buku/index.blade.php
        return view('Siswa.Buku.index', compact('bukus', 'kategoriList'));

    }

    /**
     * Menampilkan detail informasi satu buku.
     */
    public function show($id)
    {
        // Ambil data buku beserta relasi kategorinya
        $buku = Buku::with('kategori')->findOrFail($id);

        return view('Siswa.Buku.show', compact('buku'));
    }
}
