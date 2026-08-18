{{-- <!DOCTYPE html>
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
                            @foreach ($trx->detailPeminjaman as $detail)
                                <li>{{ $detail->buku->judul ?? '-' }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y', strtotime($trx->tanggal_pinjam)) }}<br>
                        <span style="color: #dc2626;">s/d {{ date('d/m/Y', strtotime($trx->tanggal_harus_kembali)) }}</span>
                    </td>
                    <td class="text-center">
                        @if ($trx->status == "dipinjam")
                            <span class="badge-status status-dipinjam">DIPINJAM</span>
                        @elseif($trx->status == 'dikembalikan')
                            <span class="badge-status status-dikembalikan">SELESAI</span>
                            @if ($trx->total_denda > 0)
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
</html> --}}

<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Laporan Rekapitulasi Sirkulasi Perpustakaan</title>
        <style>
            @page {
                margin: 1.2cm 1.5cm 1.5cm 1.5cm;
            }

            body {
                font-family: Arial, Helvetica, sans-serif;
                color: #1e293b;
                font-size: 10px;
                line-height: 1.4;
                margin: 0;
                padding: 0;
            }

            /* Kop Surat Resmi SMAN 1 Keritang */
            .kop-surat {
                width: 100%;
                border-bottom: 3px double #0f172a;
                padding-bottom: 8px;
                margin-bottom: 14px;
            }

            .kop-table {
                width: 100%;
                border-collapse: collapse;
            }

            .kop-table td {
                vertical-align: middle;
                border: none;
                padding: 0;
            }

            .logo-placeholder {
                width: 70px;
                text-align: center;
            }

            .kop-text {
                text-align: center;
            }

            .kop-text h4 {
                margin: 0;
                font-size: 11px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #334155;
            }

            .kop-text h2 {
                margin: 2px 0 0 0;
                font-size: 16px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #059669;
                /* Emerald Accent */
            }

            .kop-text p {
                margin: 3px 0 0 0;
                font-size: 8.5px;
                color: #64748b;
            }

            /* Judul Dokumen & Periode Filter */
            .doc-header {
                text-align: center;
                margin-bottom: 14px;
            }

            .doc-title {
                font-size: 12px;
                font-weight: bold;
                text-transform: uppercase;
                text-decoration: underline;
                margin: 0;
                color: #0f172a;
            }

            .doc-subtitle {
                font-size: 9.5px;
                color: #475569;
                margin-top: 3px;
            }

            /* Card Ringkasan Statistik Laporan */
            .summary-box {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 12px;
            }

            .summary-box td {
                border: 1px solid #e2e8f0;
                background-color: #f8fafc;
                padding: 6px 10px;
                font-size: 9.5px;
            }

            .summary-title {
                color: #64748b;
                font-[600];
            }

            .summary-value {
                font-weight: bold;
                color: #0f172a;
            }

            /* Styling Tabel Data Laporan */
            .table-data {
                width: 100%;
                border-collapse: collapse;
                margin-top: 4px;
            }

            .table-data th,
            .table-data td {
                border: 1px solid #cbd5e1;
                padding: 6px 8px;
                vertical-align: top;
            }

            .table-data th {
                background-color: #ecfdf5;
                /* Light Emerald */
                color: #065f46;
                font-weight: bold;
                text-transform: uppercase;
                font-size: 9px;
                letter-spacing: 0.3px;
                border-bottom: 2px solid #a7f3d0;
            }

            .table-data tr:nth-child(even) {
                background-color: #f8fafc;
            }

            /* Badge Status */
            .badge {
                display: inline-block;
                padding: 2px 6px;
                font-size: 8px;
                font-weight: bold;
                border-radius: 4px;
                text-transform: uppercase;
            }

            .badge-dipinjam {
                background-color: #fffbeb;
                color: #b45309;
                border: 1px solid #fde68a;
            }

            .badge-dikembalikan {
                background-color: #ecfdf5;
                color: #047857;
                border: 1px solid #a7f3d0;
            }

            .badge-terlambat {
                background-color: #fef2f2;
                color: #b91c1c;
                border: 1px solid #fecaca;
            }

            /* Helpers */
            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            .font-mono {
                font-family: monospace;
            }

            .font-bold {
                font-weight: bold;
            }

            /* Area Tanda Tangan */
            .signature-section {
                width: 100%;
                margin-top: 24px;
                page-break-inside: avoid;
            }

            .signature-table {
                width: 100%;
                border-collapse: collapse;
            }

            .signature-table td {
                border: none;
                width: 50%;
                text-align: center;
                vertical-align: top;
                font-size: 9.5px;
            }

            .signature-space {
                height: 50px;
            }
        </style>
    </head>

    <body>

        <!-- Kop Surat Resmi -->
        <div class="kop-surat">
            <table class="kop-table">
                <tr>
                    <td class="kop-text">
                        <h4>Pemerintah Provinsi Riau • Dinas Pendidikan</h4>
                        <h2>SMA Negeri 1 Keritang</h2>
                        <p>Alamat: Jl. Pendidikan No. 1, Keritang, Kabupaten Indragiri Hilir, Riau 29274</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Judul Dokumen & Subtitle -->
        <div class="doc-header">
            <h3 class="doc-title">Laporan Rekapitulasi Sirkulasi Perpustakaan</h3>
            <div class="doc-subtitle">
                Periode:
                <strong>
                    @if (!empty($tglMulai) && !empty($tglSelesai))
                        {{ date("d/m/Y", strtotime($tglMulai)) }} s/d {{ date("d/m/Y", strtotime($tglSelesai)) }}
                    @else
                        Semua Riwayat Transaksi
                    @endif
                </strong>
                &nbsp;•&nbsp; Dicetak: {{ date("d-m-Y H:i") }} WIB
            </div>
        </div>

        <!-- Summary Card Information -->
        <table class="summary-box">
            <tr>
                <td style="width: 33.3%;">
                    <span class="summary-title">Total Transaksi:</span>
                    <span class="summary-value">{{ count($peminjamans) }} Transaksi</span>
                </td>
                <td style="width: 33.3%;">
                    <span class="summary-title">Total Denda Terkumpul:</span>
                    <span class="summary-value" style="color: #b91c1c;">Rp
                        {{ number_format($totalDenda ?? 0, 0, ",", ".") }}</span>
                </td>
                <td style="width: 33.3%;">
                    <span class="summary-title">Status Laporan:</span>
                    <span class="summary-value" style="color: #047857;">Resmi / Terverifikasi</span>
                </td>
            </tr>
        </table>

        <!-- Tabel Rekap Data -->
        <table class="table-data">
            <thead>
                <tr>
                    <th class="text-center" style="width: 4%;">No</th>
                    <th style="width: 12%;">Kode TRX</th>
                    <th style="width: 22%;">Peminjam</th>
                    <th style="width: 32%;">Buku Dipinjam</th>
                    <th class="text-center" style="width: 15%;">Tgl Pinjam / Kembali</th>
                    <th class="text-center" style="width: 15%;">Status / Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $index => $trx)
                    <tr>
                        <td class="text-center font-mono font-bold" style="color: #64748b;">{{ $index + 1 }}</td>
                        <td class="font-mono font-bold" style="color: #059669;">{{ $trx->kode_transaksi }}</td>
                        <td>
                            <strong style="color: #0f172a;">{{ $trx->anggota->nama_lengkap ?? "-" }}</strong><br>
                            <span style="font-size: 8.5px; color: #64748b; font-family: monospace;">
                                {{ $trx->anggota->nomor_induk ?? "-" }} •
                                {{ strtoupper($trx->anggota->jenis_anggota ?? "-") }}
                            </span>
                        </td>
                        <td>
                            <ul style="margin: 0; padding-left: 12px; font-size: 9.5px; color: #334155;">
                                @foreach ($trx->detailPeminjaman as $detail)
                                    <li>{{ $detail->buku->judul ?? "-" }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center font-mono" style="font-size: 9px;">
                            <div>{{ date("d/m/Y", strtotime($trx->tanggal_pinjam)) }}</div>
                            <div style="color: #b91c1c; font-weight: bold; margin-top: 2px;">
                                s/d {{ date("d/m/Y", strtotime($trx->tanggal_harus_kembali)) }}
                            </div>
                        </td>
                        <td class="text-center">
                            @if ($trx->status == "dipinjam")
                                <span class="badge badge-dipinjam">DIPINJAM</span>
                            @elseif($trx->status == "dikembalikan")
                                <span class="badge badge-dikembalikan">SELESAI</span>
                                @if ($trx->total_denda > 0)
                                    <div class="font-mono"
                                        style="font-size: 8.5px; color: #b91c1c; font-weight: bold; margin-top: 3px;">
                                        Rp {{ number_format($trx->total_denda, 0, ",", ".") }}
                                    </div>
                                @endif
                            @else
                                <span class="badge badge-terlambat">TERLAMBAT</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center"
                            style="padding: 20px; color: #94a3b8; font-style: italic;">
                            Tidak ada data sirkulasi yang cocok untuk dicetak pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Tanda Tangan Pembina & Petugas -->
        {{-- <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        Mengetahui,<br>
                        <strong>Kepala Perpustakaan</strong>
                        <div class="signature-space"></div>
                        <strong><u>_________________________</u></strong><br>
                        NIP. .....................................
                    </td>
                    <td>
                        Keritang, {{ date("d F Y") }}<br>
                        <strong>Petugas Perpustakaan</strong>
                        <div class="signature-space"></div>
                        <strong><u>{{ auth()->user()->name ?? "Administrator" }}</u></strong><br>
                        NIP / NUPTK. .....................................
                    </td>
                </tr>
            </table>
        </div> --}}

    </body>

</html>
