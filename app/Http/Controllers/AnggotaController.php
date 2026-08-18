<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Menampilkan daftar anggota perpustakaan dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        $query = Anggota::query();

        // Pencarian berdasarkan Nama atau Nomor Induk (NIS/NIP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nomor_induk', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan Jenis Anggota (Siswa/Guru)
        if ($request->filled('jenis_anggota')) {
            $query->where('jenis_anggota', $request->jenis_anggota);
        }

        // Filter berdasarkan Status (Aktif/Nonaktif)
        if ($request->filled('status_aktif')) {
            $query->where('status_aktif', $request->status_aktif);
        }

        $anggotas = $query->latest()->paginate(10)->withQueryString();

        return view('Admin.Anggota.index', compact('anggotas'));
    }

    /**
     * Menyimpan data anggota baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_induk'      => 'required|string|max:50|unique:anggota,nomor_induk',
            'nama_lengkap'     => 'required|string|max:150',
            'jenis_anggota'    => 'required|in:siswa,guru',
            'kelas_or_jabatan' => 'required|string|max:50',
            'jenis_kelamin'    => 'required|in:L,P',
            'no_telp'          => 'nullable|string|max:20',
            'alamat'           => 'nullable|string',
            'password'         => 'required|string|min:6',
        ], [
            'nomor_induk.required'   => 'Nomor Induk (NIS/NIP) wajib diisi.',
            'nomor_induk.unique'     => 'Nomor Induk ini sudah terdaftar di sistem.',
            'nama_lengkap.required'  => 'Nama Lengkap wajib diisi.',
            'jenis_anggota.required' => 'Pilih jenis anggota (Siswa atau Guru).',
            'password.required'      => 'Kata sandi wajib diisi.',
            'password.min'           => 'Kata sandi minimal 6 karakter.',
        ]);

        $validatedData['status_aktif'] = 'aktif'; // Default status saat daftar baru
        $validatedData['password'] = Hash::make($validatedData['password']); // Enkripsi password

        Anggota::create($validatedData);

        return redirect(url('/admin/anggota'))->with('success', 'Data anggota baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data anggota di database.
     */
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $validatedData = $request->validate([
            'nomor_induk'      => 'required|string|max:50|unique:anggota,nomor_induk,' . $anggota->id,
            'nama_lengkap'     => 'required|string|max:150',
            'password'         => 'nullable|string|min:6', // Optional saat edit
            'jenis_anggota'    => 'required|in:siswa,guru',
            'kelas_or_jabatan' => 'required|string|max:50',
            'jenis_kelamin'    => 'required|in:L,P',
            'no_telp'          => 'nullable|string|max:20',
            'alamat'           => 'nullable|string',
            'status_aktif'     => 'required|in:aktif,nonaktif',
        ], [
            'nomor_induk.required' => 'Nomor Induk wajib diisi.',
            'nomor_induk.unique'   => 'Nomor Induk ini sudah dipakai anggota lain.',
            'password.min'         => 'Password minimal berisi 6 karakter.',
        ]);

        // Enkripsi password jika diisi, atau hapus key 'password' dari data update jika kosong
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $anggota->update($validatedData);

        return redirect(url('/admin/anggota'))->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Menghapus data anggota dari database.
     */
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);

        // Jika ada relasi peminjaman aktif, lebih baik dicegah atau ditangani. 
        // Untuk skripsi ini, kita asumsikan bisa dihapus (cascade) atau menggunakan soft-delete.
        $anggota->delete();

        return redirect(url('/admin/anggota'))->with('success', 'Data anggota berhasil dihapus.');
    }
}
