<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Filter berdasarkan kata kunci pencarian (Judul, ISBN, Pengarang)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Ambil data buku dengan pagination
        $bukus = $query->latest()->paginate(10)->withQueryString();
        
        // Ambil daftar kategori untuk dropdown filter
        $kategoriList = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('Admin.Buku.index', compact('bukus', 'kategoriList'));
    }

    /**
     * Menampilkan form tambah buku baru.
     */
    public function create()
    {
        $kategoriList = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('Admin.Buku.create', compact('kategoriList'));
    }

    /**
     * Menyimpan data buku baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'judul'        => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:20|unique:bukus,isbn',
            'kategori_id'  => 'required|exists:kategoris,id',
            'pengarang'    => 'required|string|max:150',
            'penerbit'     => 'required|string|max:150',
            'tahun_terbit' => 'required|numeric|digits:4|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'lokasi_rak'   => 'required|string|max:50',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required'        => 'Judul buku wajib diisi.',
            'isbn.unique'           => 'Nomor ISBN sudah terdaftar di sistem.',
            'kategori_id.required'  => 'Silakan pilih kategori buku.',
            'tahun_terbit.max'      => 'Tahun terbit tidak boleh melebihi tahun saat ini.',
            'cover.image'           => 'File cover harus berupa gambar.',
            'cover.max'             => 'Ukuran file cover tidak boleh lebih dari 2MB.',
        ]);

        // 2. Upload Cover Menggunakan Metode Move File
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            
            // Pindahkan file secara manual ke folder public/uploads/buku
            $file->move(public_path('uploads/buku'), $fileName);
            
            // Simpan path relatif ke database
            $validatedData['cover'] = $fileName;
        }

        // 3. Simpan Data ke Database
        Buku::create($validatedData);

        return redirect(url('/admin/buku'))->with('success', 'Buku baru berhasil ditambahkan ke koleksi.');
    }

    /**
     * Menampilkan form edit buku.
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoriList = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('Admin.Buku.edit', compact('buku', 'kategoriList'));
    }

    /**
     * Memperbarui data buku di database.
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        // 1. Validasi Input Update
        $validatedData = $request->validate([
            'judul'        => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:20|unique:bukus,isbn,' . $buku->id,
            'kategori_id'  => 'required|exists:kategoris,id',
            'pengarang'    => 'required|string|max:150',
            'penerbit'     => 'required|string|max:150',
            'tahun_terbit' => 'required|numeric|digits:4|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'lokasi_rak'   => 'required|string|max:50',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Logika Update Cover dengan Metode Move File
        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada di direktori public
            if ($buku->cover && file_exists(public_path($buku->cover))) {
                unlink(public_path($buku->cover));
            }

            // Pindahkan file baru
            $file = $request->file('cover');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/buku'), $fileName);

            $validatedData['cover'] = $fileName;
        }

        // 3. Update Data Buku
        $buku->update($validatedData);

        return redirect(url('/admin/buku'))->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Menghapus buku dari database.
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus file cover dari direktori publik jika ada
        if ($buku->cover && file_exists(public_path($buku->cover))) {
            unlink(public_path($buku->cover));
        }

        // Hapus record di database
        $buku->delete();

        return redirect(url('/admin/buku'))->with('success', 'Buku berhasil dihapus dari sistem.');
    }
}
