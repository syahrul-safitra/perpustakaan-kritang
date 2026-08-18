<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
        /**
     * Menampilkan daftar kategori dan statistik jumlah buku per kategori.
     */
    public function index(Request $request)
    {
        $query = Kategori::withCount('bukus');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('kode_kategori', 'like', "%{$search}%");
        }

        $kategoris = $query->latest()->paginate(10)->withQueryString();

        return view('Admin.Kategori.index', compact('kategoris'));
    }

    /**
     * Menyimpan data kategori baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_kategori' => 'required|string|max:20|unique:kategoris,kode_kategori',
            'nama_kategori' => 'required|string|max:100',
        ], [
            'kode_kategori.required' => 'Kode kategori wajib diisi.',
            'kode_kategori.unique'   => 'Kode kategori sudah digunakan.',
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        Kategori::create($validatedData);

        return redirect(url('/admin/kategori'))->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data kategori.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validatedData = $request->validate([
            'kode_kategori' => 'required|string|max:20|unique:kategoris,kode_kategori,' . $kategori->id,
            'nama_kategori' => 'required|string|max:100',
        ], [
            'kode_kategori.required' => 'Kode kategori wajib diisi.',
            'kode_kategori.unique'   => 'Kode kategori sudah digunakan.',
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        $kategori->update($validatedData);

        return redirect(url('/admin/kategori'))->with('success', 'Data kategori berhasil diperbarui.');
    }

    /**
     * Menghapus data kategori.
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Proteksi jika kategori masih memiliki koleksi buku
        if ($kategori->bukus()->count() > 0) {
            return redirect(url('/admin/kategori'))->with('error', 'Kategori tidak dapat dihapus karena masih memiliki koleksi buku.');
        }

        $kategori->delete();

        return redirect(url('/admin/kategori'))->with('success', 'Kategori berhasil dihapus.');
    }
}
