@extends('Admin.Layouts.main')

@section('title', 'Data Anggota - Admin Perpustakaan')
@section('breadcrumb_active', 'Data Anggota')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content tracking-tight">Data Anggota</h1>
        <p class="text-xs text-base-content/60 mt-1">Kelola data siswa dan guru sebagai anggota perpustakaan SMAN 1 Keritang.</p>
    </div>
    <div>
        <button onclick="create_modal.showModal()" class="btn btn-primary rounded-xl shadow-lg shadow-primary/25 gap-2 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Tambah Anggota
        </button>
    </div>
</div>

<!-- Main Card -->
<div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl overflow-hidden">
    <div class="card-body p-5 md:p-6">
        
        <!-- Filter Bar -->
        <form method="GET" action="{{ url('/admin/anggota') }}" class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <!-- Search Field -->
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-base-content/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS/NIP..." 
                       class="input input-sm input-bordered rounded-xl pl-10 w-full bg-base-200/40 focus:bg-base-100 text-xs transition-all" />
            </div>

            <!-- Role & Status Filters -->
            <div class="flex items-center gap-2 w-full md:w-auto">
                <select name="jenis_anggota" class="select select-sm select-bordered rounded-xl bg-base-200/40 text-xs">
                    <option value="">Semua Peran</option>
                    <option value="siswa" {{ request('jenis_anggota') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ request('jenis_anggota') == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>

                <select name="status_aktif" class="select select-sm select-bordered rounded-xl bg-base-200/40 text-xs">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status_aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status_aktif') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <button type="submit" class="btn btn-sm btn-ghost border border-base-200 rounded-xl px-4 text-xs">Filter</button>
            </div>
        </form>

        <!-- Table Data -->
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-left">
                <thead>
                    <tr class="bg-base-200/50 text-base-content/70 text-xs font-semibold uppercase tracking-wider border-b border-base-200">
                        <th class="rounded-l-xl py-3.5">Nama Lengkap & Nomor Induk</th>
                        <th>Peran & Kelas/Jabatan</th>
                        <th>Kontak & Gender</th>
                        <th class="text-center">Status</th>
                        <th class="rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/60 text-sm">
                    @forelse ($anggotas as $anggota)
                        <tr class="hover:bg-base-200/30 transition-colors">
                            <td class="py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary/10 text-primary border border-primary/20 rounded-xl w-10 h-10 flex items-center justify-center font-bold">
                                            {{ substr($anggota->nama_lengkap, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-base-content">{{ $anggota->nama_lengkap }}</span>
                                        <span class="font-mono text-[11px] text-base-content/50">{{ $anggota->nomor_induk }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-col">
                                    <span class="font-semibold text-xs {{ $anggota->jenis_anggota == 'guru' ? 'text-secondary' : 'text-primary' }} uppercase tracking-wider">
                                        {{ $anggota->jenis_anggota }}
                                    </span>
                                    <span class="text-xs text-base-content/70 mt-0.5">{{ $anggota->kelas_or_jabatan }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-col gap-1 text-xs">
                                    <span class="flex items-center gap-1.5 text-base-content/70">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        {{ $anggota->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                    </span>
                                    @if($anggota->no_telp)
                                    <span class="flex items-center gap-1.5 text-base-content/70">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                        {{ $anggota->no_telp }}
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($anggota->status_aktif == 'aktif')
                                    <span class="badge badge-success/15 text-emerald-700 border-emerald-200 font-semibold text-xs px-2.5 py-1 rounded-lg">Aktif</span>
                                @else
                                    <span class="badge badge-error/15 text-rose-700 border-rose-200 font-semibold text-xs px-2.5 py-1 rounded-lg">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Parsing data ke JSON agar aman menangani karakter khusus pada string -->
                                    <button onclick="openEditModal({{ json_encode($anggota) }})" 
                                            class="btn btn-square btn-ghost btn-xs text-base-content/60 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button onclick="confirmDelete('{{ $anggota->id }}', '{{ $anggota->nama_lengkap }}')" 
                                            class="btn btn-square btn-ghost btn-xs text-base-content/60 hover:text-error hover:bg-error/10 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-base-content/50 text-xs">Belum ada data anggota yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($anggotas->hasPages())
            <div class="mt-4 pt-4 border-t border-base-200 flex justify-end">
                {{ $anggotas->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal 1: Tambah Anggota -->
<dialog id="create_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box w-11/12 max-w-2xl rounded-2xl border border-base-200 p-6">
        <h3 class="font-bold text-lg text-base-content mb-4 border-b border-base-200 pb-3">Registrasi Anggota Baru</h3>
        
        <form action="{{ url('/admin/anggota') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Nomor Induk (NIS/NIP) <span class="text-error">*</span></span></label>
                    <input type="text" name="nomor_induk" value="{{ old('_method') ? '' : old('nomor_induk') }}" class="input input-sm input-bordered rounded-xl font-mono @if(!$errors->has('_method') && $errors->has('nomor_induk')) input-error @endif" required />
                    @if(!old('_method') && $errors->has('nomor_induk')) <span class="text-[11px] text-error mt-1">{{ $errors->first('nomor_induk') }}</span> @endif
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Nama Lengkap <span class="text-error">*</span></span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('_method') ? '' : old('nama_lengkap') }}" class="input input-sm input-bordered rounded-xl @if(!$errors->has('_method') && $errors->has('nama_lengkap')) input-error @endif" required />
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Password Login <span class="text-error">*</span></span></label>
                    <input type="password" name="password" placeholder="••••••••" class="input input-sm input-bordered rounded-xl @if(!$errors->has('_method') && $errors->has('password')) input-error @endif"  />
                    @if(!old('_method') && $errors->has('password')) <span class="text-[11px] text-error mt-1">{{ $errors->first('password') }}</span> @endif
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Jenis Anggota <span class="text-error">*</span></span></label>
                    <select name="jenis_anggota" class="select select-sm select-bordered rounded-xl @if(!$errors->has('_method') && $errors->has('jenis_anggota')) select-error @endif" required>
                        <option value="" disabled selected>Pilih Peran...</option>
                        <option value="siswa" {{ (!old('_method') && old('jenis_anggota') == 'siswa') ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ (!old('_method') && old('jenis_anggota') == 'guru') ? 'selected' : '' }}>Guru</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Kelas / Jabatan <span class="text-error">*</span></span></label>
                    <input type="text" name="kelas_or_jabatan" value="{{ old('_method') ? '' : old('kelas_or_jabatan') }}" placeholder="Misal: X IPA 1 / Guru MTK" class="input input-sm input-bordered rounded-xl" required />
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Jenis Kelamin <span class="text-error">*</span></span></label>
                    <select name="jenis_kelamin" class="select select-sm select-bordered rounded-xl" required>
                        <option value="L" {{ (!old('_method') && old('jenis_kelamin') == 'L') ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="P" {{ (!old('_method') && old('jenis_kelamin') == 'P') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="form-control sm:col-span-2">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">No. Telepon / WhatsApp</span></label>
                    <input type="text" name="no_telp" value="{{ old('_method') ? '' : old('no_telp') }}" class="input input-sm input-bordered rounded-xl font-mono w-full" />
                </div>

                <!-- Field Alamat (Rapih Full-Width) -->
                <div class="form-control sm:col-span-2">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Alamat Domisili</span></label>
                    <textarea name="alamat" class="textarea textarea-bordered rounded-xl text-xs w-full resize-none focus:outline-none focus:border-primary" rows="2" placeholder="Masukkan alamat lengkap domisili anggota...">{{ old('_method') ? '' : old('alamat') }}</textarea>
                </div>

            </div>

            <div class="modal-action gap-2 mt-6 border-t border-base-200 pt-4">
                <button type="button" onclick="create_modal.close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm rounded-xl px-6 text-xs font-semibold">Simpan Anggota</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<!-- Modal 2: Edit Anggota -->
<dialog id="edit_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box w-11/12 max-w-2xl rounded-2xl border border-base-200 p-6">
        <h3 class="font-bold text-lg text-base-content mb-4 border-b border-base-200 pb-3">Edit Data Anggota</h3>
        
        <form id="edit_form" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="anggota_id" id="edit_anggota_id" value="{{ old('anggota_id') }}">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Nomor Induk <span class="text-error">*</span></span></label>
                    <input type="text" id="edit_nomor_induk" name="nomor_induk" value="{{ old('_method') == 'PUT' ? old('nomor_induk') : '' }}" class="input input-sm input-bordered rounded-xl font-mono @if(old('_method') == 'PUT' && $errors->has('nomor_induk')) input-error @endif" required />
                    @if(old('_method') == 'PUT' && $errors->has('nomor_induk')) <span class="text-[11px] text-error mt-1">{{ $errors->first('nomor_induk') }}</span> @endif
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Nama Lengkap <span class="text-error">*</span></span></label>
                    <input type="text" id="edit_nama_lengkap" name="nama_lengkap" value="{{ old('_method') == 'PUT' ? old('nama_lengkap') : '' }}" class="input input-sm input-bordered rounded-xl" required />
                </div>

                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text font-semibold text-xs">Password Baru</span>
                    </label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="input input-sm input-bordered rounded-xl text-xs" />
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Jenis Anggota <span class="text-error">*</span></span></label>
                    <select id="edit_jenis_anggota" name="jenis_anggota" class="select select-sm select-bordered rounded-xl" required>
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Kelas / Jabatan <span class="text-error">*</span></span></label>
                    <input type="text" id="edit_kelas_or_jabatan" name="kelas_or_jabatan" value="{{ old('_method') == 'PUT' ? old('kelas_or_jabatan') : '' }}" class="input input-sm input-bordered rounded-xl" required />
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Jenis Kelamin <span class="text-error">*</span></span></label>
                    <select id="edit_jenis_kelamin" name="jenis_kelamin" class="select select-sm select-bordered rounded-xl" required>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">No. Telepon</span></label>
                    <input type="text" id="edit_no_telp" name="no_telp" value="{{ old('_method') == 'PUT' ? old('no_telp') : '' }}" class="input input-sm input-bordered rounded-xl font-mono" />
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text font-semibold text-xs text-error">Status Keanggotaan <span class="text-error">*</span></span></label>
                    <select id="edit_status_aktif" name="status_aktif" class="select select-sm select-bordered rounded-xl font-semibold" required>
                        <option value="aktif" class="text-success">Aktif</option>
                        <option value="nonaktif" class="text-error">Nonaktif</option>
                    </select>
                </div>

                <!-- Field Alamat (Rapih Full-Width) -->
                <div class="form-control sm:col-span-2">
                    <label class="label py-1"><span class="label-text font-semibold text-xs">Alamat Domisili</span></label>
                    <textarea id="edit_alamat" name="alamat" class="textarea textarea-bordered rounded-xl text-xs w-full resize-none focus:outline-none focus:border-primary" rows="2" placeholder="Masukkan alamat lengkap domisili anggota...">{{ old('_method') == 'PUT' ? old('alamat') : '' }}</textarea>
                </div>

            </div>

            <div class="modal-action gap-2 mt-6 border-t border-base-200 pt-4">
                <button type="button" onclick="edit_modal.close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm rounded-xl px-6 text-xs font-semibold">Perbarui Data</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<!-- Modal 3: Delete Anggota -->
<dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box rounded-2xl border border-base-200 p-6">
        <h3 class="font-bold text-base text-base-content">Konfirmasi Hapus</h3>
        <p class="py-3 text-sm text-base-content/70">
            Hapus anggota bernama <span id="delete_anggota_name" class="font-bold text-error"></span>?
        </p>
        <form id="delete_form" method="POST" class="modal-action gap-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="delete_modal.close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
            <button type="submit" class="btn btn-error btn-sm rounded-xl text-white">Hapus</button>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

@push('scripts')
<script>
    // Membuka modal edit dan mengisi form dengan data JSON
    function openEditModal(anggota) {
        document.getElementById('edit_form').action = `/admin/anggota/${anggota.id}`;
        document.getElementById('edit_anggota_id').value = anggota.id;
        document.getElementById('edit_nomor_induk').value = anggota.nomor_induk;
        document.getElementById('edit_nama_lengkap').value = anggota.nama_lengkap;
        document.getElementById('edit_jenis_anggota').value = anggota.jenis_anggota;
        document.getElementById('edit_kelas_or_jabatan').value = anggota.kelas_or_jabatan;
        document.getElementById('edit_jenis_kelamin').value = anggota.jenis_kelamin;
        document.getElementById('edit_no_telp').value = anggota.no_telp;
        document.getElementById('edit_alamat').value = anggota.alamat;
        document.getElementById('edit_status_aktif').value = anggota.status_aktif;
        
        document.getElementById('edit_modal').showModal();
    }

    function confirmDelete(id, nama) {
        document.getElementById('delete_form').action = `/admin/anggota/${id}`;
        document.getElementById('delete_anggota_name').innerText = `"${nama}"`;
        document.getElementById('delete_modal').showModal();
    }

    // Auto-open Modals if validation fails
    @if ($errors->any())
        document.addEventListener("DOMContentLoaded", function() {
            @if (old('_method') == 'PUT')
                let id = document.getElementById('edit_anggota_id').value;
                if(id) {
                    document.getElementById('edit_form').action = `/admin/anggota/${id}`;
                    document.getElementById('edit_jenis_anggota').value = '{{ old("jenis_anggota") }}';
                    document.getElementById('edit_jenis_kelamin').value = '{{ old("jenis_kelamin") }}';
                    document.getElementById('edit_status_aktif').value = '{{ old("status_aktif") }}';
                    document.getElementById('edit_modal').showModal();
                }
            @else
                document.getElementById('create_modal').showModal();
            @endif
        });
    @endif
</script>
@endpush
@endsection