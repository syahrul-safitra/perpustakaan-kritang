@extends("Admin.Layouts.main")

@section("title", "Data Kategori Buku - E-Perpus SMAN 1 Keritang")
@section("page_heading", "Kelola Kategori Buku")

@section("content")
    <div class="space-y-6">

        <!-- Header Action & Search Card (Light Emerald Style) -->
        <div class="space-y-4 rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">

            <!-- Baris Atas: Judul & Tombol Tambah -->
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Daftar Kategori Buku</h2>
                    <p class="text-xs text-slate-400">Kelola pengelompokan dan jenis kategori koleksi perpustakaan</p>
                </div>

                <button onclick="create_modal.showModal()"
                    class="btn btn-sm gap-2 self-start rounded-2xl border-none bg-emerald-600 px-4 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700 md:self-auto">
                    <i class="fa-solid fa-plus text-xs"></i> Tambah Kategori
                </button>
            </div>

            <!-- Baris Bawah: Form Pencarian -->
            <form method="GET" action="{{ url("/admin/kategori") }}"
                class="flex flex-col items-center justify-between gap-3 border-t border-slate-100 pt-3 md:flex-row">
                <div class="relative w-full md:w-80">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request("search") }}"
                        placeholder="Cari nama atau kode kategori..."
                        class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-slate-50 pl-9 text-xs text-slate-700 transition-all focus:border-emerald-500 focus:bg-white focus:outline-none" />
                </div>

                <div class="flex w-full items-center gap-2 md:w-auto">
                    <button type="submit"
                        class="btn btn-sm gap-1.5 rounded-xl border border-slate-200 bg-slate-100 px-4 text-xs font-bold text-slate-700 transition-colors hover:bg-emerald-50 hover:text-emerald-600">
                        <i class="fa-solid fa-filter text-[11px]"></i> Cari
                    </button>

                    @if (request("search"))
                        <a href="{{ url("/admin/kategori") }}"
                            class="btn btn-sm btn-ghost rounded-xl px-2 text-xs font-semibold text-rose-500 hover:bg-rose-50"
                            title="Reset Pencarian">
                            <i class="fa-solid fa-rotate-right"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Data Container -->
        <div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 p-5">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Kategori:
                    {{ $kategoris->total() ?? count($kategoris) }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-xs">
                    <thead>
                        <tr
                            class="border-b border-slate-100 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="w-16 px-4 py-3.5">No</th>
                            <th class="px-4 py-3.5">Kode Kategori</th>
                            <th class="px-4 py-3.5">Nama Kategori</th>
                            {{-- <th class="px-4 py-3.5">Deskripsi</th> --}}
                            <th class="w-28 px-4 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @forelse($kategoris as $index => $item)
                            <tr class="transition-colors hover:bg-slate-50/80">
                                <td class="px-4 py-3.5 font-mono text-slate-400">
                                    {{ $kategoris->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3.5 font-mono font-bold text-emerald-600">
                                    {{ $item->kode_kategori ?? "KTG-" . str_pad($item->id, 3, "0", STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 py-3.5">
                                    <span class="font-bold text-slate-800">{{ $item->nama_kategori }}</span>
                                </td>
                                {{-- <td class="max-w-xs truncate px-4 py-3.5 text-slate-500">
                                    {{ $item->deskripsi ?? "-" }}
                                </td> --}}
                                <td class="px-4 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button onclick="openEditModal({{ json_encode($item) }})"
                                            class="btn btn-xs btn-square rounded-xl border-none bg-slate-100 text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-600"
                                            title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </button>
                                        <button onclick="confirmDelete({{ $item->id }}, '{{ $item->nama_kategori }}')"
                                            class="btn btn-xs btn-square rounded-xl border-none bg-slate-100 text-slate-600 transition-colors hover:bg-rose-50 hover:text-rose-600"
                                            title="Hapus Data">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center italic text-slate-400">
                                    Belum ada data kategori yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($kategoris->hasPages())
                <div class="border-t border-slate-100 p-4">
                    {{ $kategoris->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Modal 1: Tambah Kategori -->
    <dialog id="create_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-11/12 max-w-lg rounded-3xl border border-slate-100 bg-white p-6 shadow-2xl">
            <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="flex items-center gap-2 text-base font-bold text-slate-800">
                    <i class="fa-solid fa-layer-group text-emerald-600"></i> Tambah Kategori Baru
                </h3>
                <button onclick="create_modal.close()" class="btn btn-xs btn-circle btn-ghost text-slate-400">✕</button>
            </div>

            <form action="{{ url("/admin/kategori") }}" method="POST">
                @csrf
                <div class="space-y-4">

                    <!-- Field 1: Kode Kategori -->
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-bold text-slate-700">Kode Kategori</label>
                        <input type="text" name="kode_kategori" value="{{ old("_method") ? "" : old("kode_kategori") }}"
                            placeholder="Contoh: KTG-001 (Opsional)"
                            class="input input-sm input-bordered @if (!$errors->has("_method") && $errors->has("kode_kategori")) input-error border-rose-500 @endif w-full rounded-xl font-mono text-xs focus:border-emerald-500 focus:outline-none" />
                        @if (!old("_method") && $errors->has("kode_kategori"))
                            <span class="mt-0.5 text-[10px] font-semibold text-rose-500"><i
                                    class="fa-solid fa-circle-exclamation"></i>
                                {{ $errors->first("kode_kategori") }}</span>
                        @endif
                    </div>

                    <!-- Field 2: Nama Kategori -->
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-bold text-slate-700">Nama Kategori <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="nama_kategori" value="{{ old("_method") ? "" : old("nama_kategori") }}"
                            placeholder="Misal: Pemrograman / Novel / Sains"
                            class="input input-sm input-bordered @if (!$errors->has("_method") && $errors->has("nama_kategori")) input-error border-rose-500 @endif w-full rounded-xl text-xs focus:border-emerald-500 focus:outline-none"
                            required />
                        @if (!old("_method") && $errors->has("nama_kategori"))
                            <span class="mt-0.5 text-[10px] font-semibold text-rose-500"><i
                                    class="fa-solid fa-circle-exclamation"></i>
                                {{ $errors->first("nama_kategori") }}</span>
                        @endif
                    </div>

                </div>

                <div class="modal-action mt-6 gap-2 border-t border-slate-100 pt-4">
                    <button type="button" onclick="create_modal.close()"
                        class="btn btn-ghost btn-sm rounded-xl text-xs text-slate-500">Batal</button>
                    <button type="submit"
                        class="btn btn-sm rounded-xl border-none bg-emerald-600 px-6 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700">Simpan
                        Kategori</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <!-- Modal 2: Edit Kategori -->
    <dialog id="edit_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-11/12 max-w-lg rounded-3xl border border-slate-100 bg-white p-6 shadow-2xl">
            <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="flex items-center gap-2 text-base font-bold text-slate-800">
                    <i class="fa-solid fa-pen-to-square text-emerald-600"></i> Edit Data Kategori
                </h3>
                <button onclick="edit_modal.close()" class="btn btn-xs btn-circle btn-ghost text-slate-400">✕</button>
            </div>

            <form id="edit_form" method="POST">
                @csrf
                @method("PUT")
                <input type="hidden" name="kategori_id" id="edit_kategori_id" value="{{ old("kategori_id") }}">

                <div class="space-y-4">

                    <!-- Field 1: Kode Kategori -->
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-bold text-slate-700">Kode Kategori</label>
                        <input type="text" id="edit_kode_kategori" name="kode_kategori"
                            value="{{ old("_method") == "PUT" ? old("kode_kategori") : "" }}"
                            class="input input-sm input-bordered @if (old("_method") == "PUT" && $errors->has("kode_kategori")) input-error border-rose-500 @endif w-full rounded-xl font-mono text-xs focus:border-emerald-500 focus:outline-none" />
                        @if (old("_method") == "PUT" && $errors->has("kode_kategori"))
                            <span class="mt-0.5 text-[10px] font-semibold text-rose-500"><i
                                    class="fa-solid fa-circle-exclamation"></i>
                                {{ $errors->first("kode_kategori") }}</span>
                        @endif
                    </div>

                    <!-- Field 2: Nama Kategori -->
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-bold text-slate-700">Nama Kategori <span
                                class="text-rose-500">*</span></label>
                        <input type="text" id="edit_nama_kategori" name="nama_kategori"
                            value="{{ old("_method") == "PUT" ? old("nama_kategori") : "" }}"
                            class="input input-sm input-bordered @if (old("_method") == "PUT" && $errors->has("nama_kategori")) input-error border-rose-500 @endif w-full rounded-xl text-xs focus:border-emerald-500 focus:outline-none"
                            required />
                        @if (old("_method") == "PUT" && $errors->has("nama_kategori"))
                            <span class="mt-0.5 text-[10px] font-semibold text-rose-500"><i
                                    class="fa-solid fa-circle-exclamation"></i>
                                {{ $errors->first("nama_kategori") }}</span>
                        @endif
                    </div>

                </div>

                <div class="modal-action mt-6 gap-2 border-t border-slate-100 pt-4">
                    <button type="button" onclick="edit_modal.close()"
                        class="btn btn-ghost btn-sm rounded-xl text-xs text-slate-500">Batal</button>
                    <button type="submit"
                        class="btn btn-sm rounded-xl border-none bg-emerald-600 px-6 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700">Perbarui
                        Data</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <!-- Modal 3: Hapus Kategori -->
    <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box w-11/12 max-w-md rounded-3xl border border-slate-100 bg-white p-6 text-center shadow-2xl">
            <div
                class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-xl text-rose-500">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-base font-bold text-slate-800">Konfirmasi Hapus Data</h3>
            <p class="mt-2 text-xs text-slate-500">
                Apakah Anda yakin ingin menghapus kategori <span id="delete_kategori_name"
                    class="font-bold text-slate-800"></span>? Data yang terhapus tidak dapat dikembalikan.
            </p>

            <form id="delete_form" method="POST" class="mt-6">
                @csrf
                @method("DELETE")
                <div class="flex items-center justify-center gap-3">
                    <button type="button" onclick="delete_modal.close()"
                        class="btn btn-ghost btn-sm w-1/2 rounded-xl text-xs text-slate-500">Batal</button>
                    <button type="submit"
                        class="btn btn-sm w-1/2 rounded-xl border-none bg-rose-600 text-xs font-bold text-white shadow-md shadow-rose-600/20 hover:bg-rose-700">Hapus
                        Sekarang</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    @push("scripts")
        <script>
            function openEditModal(kategori) {
                document.getElementById('edit_form').action = `/admin/kategori/${kategori.id}`;
                document.getElementById('edit_kategori_id').value = kategori.id;
                document.getElementById('edit_kode_kategori').value = kategori.kode_kategori || '';
                document.getElementById('edit_nama_kategori').value = kategori.nama_kategori;
                // document.getElementById('edit_deskripsi').value = kategori.deskripsi || '';

                document.getElementById('edit_modal').showModal();
            }

            function confirmDelete(id, nama) {
                document.getElementById('delete_form').action = `/admin/kategori/${id}`;
                document.getElementById('delete_kategori_name').innerText = `"${nama}"`;
                document.getElementById('delete_modal').showModal();
            }

            @if ($errors->any())
                document.addEventListener("DOMContentLoaded", function() {
                    @if (old("_method") == "PUT")
                        let id = document.getElementById('edit_kategori_id').value;
                        if (id) {
                            document.getElementById('edit_form').action = `/admin/kategori/${id}`;
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
