@extends('Admin.Layouts.main')

@section('title', 'Kategori Buku - Admin Perpustakaan')
@section('breadcrumb_active', 'Data Kategori')

@section('content')
<!-- Page Header & Action Button -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-base-content tracking-tight">Kategori Buku</h1>
        <p class="text-xs text-base-content/60 mt-1">Kelola klasifikasi dan pengelompokan koleksi buku perpustakaan SMAN 1 Keritang.</p>
    </div>
    <div>
        <button onclick="create_modal.showModal()" class="btn btn-primary btn-sm rounded-xl shadow-lg shadow-primary/25 gap-2 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kategori
        </button>
    </div>
</div>

<!-- Main Card Table -->
<div class="card bg-base-100/90 backdrop-blur-md border border-base-200/80 shadow-xl shadow-base-300/20 rounded-2xl overflow-hidden">
    <div class="card-body p-5 md:p-6">
        
        <!-- Search Bar -->
        <form method="GET" action="{{ url('/admin/kategori') }}" class="flex items-center justify-between gap-4 mb-6">
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-base-content/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode kategori..." 
                       class="input input-sm input-bordered rounded-xl pl-10 w-full bg-base-200/40 focus:bg-base-100 text-xs transition-all" />
            </div>
        </form>

        <!-- Table Kategori -->
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-left">
                <thead>
                    <tr class="bg-base-200/50 text-base-content/70 text-xs font-semibold uppercase tracking-wider border-b border-base-200">
                        <th class="rounded-l-xl py-3.5">Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th class="text-center">Jumlah Buku</th>
                        <th class="rounded-r-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200/60 text-sm">
                    @forelse ($kategoris as $kategori)
                        <tr class="hover:bg-base-200/30 transition-colors">
                            <td class="font-mono text-xs font-bold text-primary py-3.5">
                                {{ $kategori->kode_kategori }}
                            </td>
                            <td class="font-semibold text-base-content">
                                {{ $kategori->nama_kategori }}
                            </td>
                            <td class="text-center">
                                <span class="badge badge-ghost font-mono text-xs font-medium px-2.5 py-1 rounded-lg">
                                    {{ $kategori->bukus_count }} Buku
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Edit Button -->
                                    <button onclick="openEditModal('{{ $kategori->id }}', '{{ $kategori->kode_kategori }}', '{{ $kategori->nama_kategori }}')" 
                                            class="btn btn-square btn-ghost btn-xs text-base-content/60 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" 
                                            title="Edit Kategori">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button onclick="confirmDelete('{{ $kategori->id }}', '{{ $kategori->nama_kategori }}')" 
                                            class="btn btn-square btn-ghost btn-xs text-base-content/60 hover:text-error hover:bg-error/10 rounded-lg transition-colors" 
                                            title="Hapus Kategori">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-base-content/50 text-xs">
                                Belum ada kategori buku yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($kategoris->hasPages())
            <div class="mt-4 pt-4 border-t border-base-200">
                {{ $kategoris->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal 1: Tambah Kategori -->
<dialog id="create_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box rounded-2xl border border-base-200 p-6">
        <h3 class="font-bold text-base text-base-content mb-4">Tambah Kategori Baru</h3>
        
        <form action="{{ url('/admin/kategori') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text font-semibold text-xs text-base-content/70">Kode Kategori <span class="text-error">*</span></span>
                </label>
                <!-- Menambahkan value old() dan class error -->
                <input type="text" name="kode_kategori" value="{{ old('_method') ? '' : old('kode_kategori') }}" placeholder="Misal: NVL, SLM, KMP" class="input input-sm input-bordered rounded-xl uppercase font-mono @if(!$errors->has('_method') && $errors->has('kode_kategori')) input-error @endif" required />
                <!-- Menampilkan pesan error -->
                @if(!old('_method') && $errors->has('kode_kategori'))
                <br>
                    <span class="text-[11px] text-error mt-1">{{ $errors->first('kode_kategori') }}</span>
                @endif
            </div>

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text font-semibold text-xs text-base-content/70">Nama Kategori <span class="text-error">*</span></span>
                </label>
                <input type="text" name="nama_kategori" value="{{ old('_method') ? '' : old('nama_kategori') }}" placeholder="Misal: Novel, Sains & Matematika" class="input input-sm input-bordered rounded-xl @if(!$errors->has('_method') && $errors->has('nama_kategori')) input-error @endif" required />
                @if(!old('_method') && $errors->has('nama_kategori'))
                    <span class="text-[11px] text-error mt-1">{{ $errors->first('nama_kategori') }}</span>
                @endif
            </div>

            <div class="modal-action gap-2 pt-2">
                <button type="button" onclick="create_modal.close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm rounded-xl px-5 text-xs font-semibold">Simpan Kategori</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<!-- Modal 2: Edit Kategori -->
<dialog id="edit_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box rounded-2xl border border-base-200 p-6">
        <h3 class="font-bold text-base text-base-content mb-4">Edit Data Kategori</h3>
        
        <form id="edit_form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <!-- Hidden input untuk menyimpan ID jika terjadi error validasi -->
            <input type="hidden" name="kategori_id" id="edit_kategori_id" value="{{ old('kategori_id') }}">
            
            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text font-semibold text-xs text-base-content/70">Kode Kategori <span class="text-error">*</span></span>
                </label>
                <input type="text" id="edit_kode_kategori" name="kode_kategori" value="{{ old('_method') == 'PUT' ? old('kode_kategori') : '' }}" class="input input-sm input-bordered rounded-xl uppercase font-mono @if(old('_method') == 'PUT' && $errors->has('kode_kategori')) input-error @endif" required />
                @if(old('_method') == 'PUT' && $errors->has('kode_kategori'))
                <br>
                    <span class="text-[11px] text-error mt-1">{{ $errors->first('kode_kategori') }}</span>
                @endif
            </div>

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text font-semibold text-xs text-base-content/70">Nama Kategori <span class="text-error">*</span></span>
                </label>
                <input type="text" id="edit_nama_kategori" name="nama_kategori" value="{{ old('_method') == 'PUT' ? old('nama_kategori') : '' }}" class="input input-sm input-bordered rounded-xl @if(old('_method') == 'PUT' && $errors->has('nama_kategori')) input-error @endif" required />
                @if(old('_method') == 'PUT' && $errors->has('nama_kategori'))
                <br
                    <span class="text-[11px] text-error mt-1">{{ $errors->first('nama_kategori') }}</span>
                @endif
            </div>

            <div class="modal-action gap-2 pt-2">
                <button type="button" onclick="edit_modal.close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm rounded-xl px-5 text-xs font-semibold">Perbarui</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

@push('scripts')
<script>
    // Fungsi untuk membuka modal Edit dari tabel
    function openEditModal(id, kode, nama) {
        document.getElementById('edit_form').action = `/admin/kategori/${id}`;
        document.getElementById('edit_kategori_id').value = id; // Set hidden ID
        document.getElementById('edit_kode_kategori').value = kode;
        document.getElementById('edit_nama_kategori').value = nama;
        document.getElementById('edit_modal').showModal();
    }

    // Fungsi untuk modal Hapus
    function confirmDelete(id, nama) {
        document.getElementById('delete_form').action = `/admin/kategori/${id}`;
        document.getElementById('delete_kategori_name').innerText = `"${nama}"`;
        document.getElementById('delete_modal').showModal();
    }

    // AUTO-OPEN MODAL JIKA ADA ERROR VALIDASI
    @if ($errors->any())
        document.addEventListener("DOMContentLoaded", function() {
            @if (old('_method') == 'PUT')
                // Jika error berasal dari form Edit (Method PUT)
                let id = document.getElementById('edit_kategori_id').value;
                if(id) {
                    document.getElementById('edit_form').action = `/admin/kategori/${id}`;
                    document.getElementById('edit_modal').showModal();
                }
            @else
                // Jika error berasal dari form Tambah (Method POST biasa)
                document.getElementById('create_modal').showModal();
            @endif
        });
    @endif
</script>
@endpush

<!-- Modal 2: Edit Kategori -->
{{-- <dialog id="edit_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box rounded-2xl border border-base-200 p-6">
        <h3 class="font-bold text-base text-base-content mb-4">Edit Data Kategori</h3>
        
        <form id="edit_form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text font-semibold text-xs text-base-content/70">Kode Kategori <span class="text-error">*</span></span>
                </label>
                <input type="text" id="edit_kode_kategori" name="kode_kategori" class="input input-sm input-bordered rounded-xl uppercase font-mono" required />
            </div>

            <div class="form-control">
                <label class="label py-1">
                    <span class="label-text font-semibold text-xs text-base-content/70">Nama Kategori <span class="text-error">*</span></span>
                </label>
                <input type="text" id="edit_nama_kategori" name="nama_kategori" class="input input-sm input-bordered rounded-xl" required />
            </div>

            <div class="modal-action gap-2 pt-2">
                <button type="button" onclick="edit_modal.close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm rounded-xl px-5 text-xs font-semibold">Perbarui</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog> --}}

<!-- Modal 3: Konfirmasi Hapus -->
<dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box rounded-2xl border border-base-200 p-6">
        <h3 class="font-bold text-base text-base-content">Konfirmasi Hapus Kategori</h3>
        <p class="py-3 text-xs text-base-content/70">
            Apakah Anda yakin ingin menghapus kategori <span id="delete_kategori_name" class="font-bold text-base-content"></span>?
        </p>
        
        <form id="delete_form" method="POST" class="modal-action gap-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="delete_modal.close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
            <button type="submit" class="btn btn-error btn-sm rounded-xl text-white text-xs">Ya, Hapus</button>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

@push('scripts')
{{-- <script>
    function openEditModal(id, kode, nama) {
        document.getElementById('edit_form').action = `/admin/kategori/${id}`;
        document.getElementById('edit_kode_kategori').value = kode;
        document.getElementById('edit_nama_kategori').value = nama;
        document.getElementById('edit_modal').showModal();
    }

    function confirmDelete(id, nama) {
        document.getElementById('delete_form').action = `/admin/kategori/${id}`;
        document.getElementById('delete_kategori_name').innerText = `"${nama}"`;
        document.getElementById('delete_modal').showModal();
    }
</script> --}}
@endpush
@endsection