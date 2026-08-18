<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Sirkulasi Perpustakaan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        /* Header / Kop Surat Resmi SMAN 1 Keritang */
        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }
        .header h3, .header h4 {
            margin: 0;
            text-transform: uppercase;
        }
        .header h3 { 
            font-size: 14px; 
            font-weight: bold; 
        }
        .header h4 { 
            font-size: 12px; 
            margin-top: 3px; 
            color: #444; 
        }
        .header p { 
            font-size: 9px; 
            margin: 3px 0 0 0; 
            color: #666; 
        }

        /* Judul Dokumen */
        .title-doc {
            text-align: center;
            margin-bottom: 16px;
        }
        .title-doc h2 {
            font-size: 13px;
            margin: 0;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .title-doc p {
            font-size: 10px;
            color: #555;
            margin-top: 4px;
        }

        /* Styling Tabel Rekapitulasi */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table th, table td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            color: #111;
        }

        /* Helper Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge-status {
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .status-dipinjam { color: #d97706; }
        .status-dikembalikan { color: #059669; }
        .status-terlambat { color: #dc2626; }
    </style>
</head>
<body>

    <!-- Kop Surat Resmi -->
    <div class="header">
        <h3>Pemerintah Provinsi Riau • Dinas Pendidikan</h3>
        <h3>SMA Negeri 1 Keritang</h3>
        <p>Jalan Pendidikan No. 1, Keritang, Kabupaten Indragiri Hilir, Riau</p>
    </div>

    <!-- Judul Laporan -->
    <div class="title-doc">
        <h2>Laporan Rekapitulasi Sirkulasi Peminjaman Buku</h2>
        <p>Dicetak pada: {{ date('d-m-Y H:i') }} WIB</p>
    </div>

    <!-- Tabel Rekap Data -->
    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 15%;">Kode TRX</th>
                <th style="width: 20%;">Nama Peminjam</th>
                <th style="width: 30%;">Judul Buku Dipinjam</th>
                <th class="text-center" style="width: 15%;">Tgl Pinjam / Kembali</th>
                <th class="text-center" style="width: 15%;">Status / Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjamans as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $trx->kode_transaksi }}</strong></td>
                    <td>
                        {{ $trx->anggota->nama_lengkap ?? '-' }}<br>
                        <span style="font-size: 9px; color: #666;">({{ strtoupper($trx->anggota->jenis_anggota ?? '-') }})</span>
                    </td>
                    <td>
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($trx->detailPeminjaman as $detail)
                                <li>{{ $detail->buku->judul ?? '-' }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y', strtotime($trx->tanggal_pinjam)) }}<br>
                        <span style="color: #dc2626;">s/d {{ date('d/m/Y', strtotime($trx->tanggal_harus_kembali)) }}</span>
                    </td>
                    <td class="text-center">
                        @if($trx->status == 'dipinjam')
                            <span class="badge-status status-dipinjam">DIPINJAM</span>
                        @elseif($trx->status == 'dikembalikan')
                            <span class="badge-status status-dikembalikan">SELESAI</span>
                            @if($trx->total_denda > 0)
                                <br><span style="font-size: 9px; color: #dc2626;">Denda: Rp {{ number_format($trx->total_denda, 0, ',', '.') }}</span>
                            @endif
                        @else
                            <span class="badge-status status-terlambat">TERLAMBAT</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 15px; color: #777;">
                        Tidak ada data transaksi peminjaman pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>