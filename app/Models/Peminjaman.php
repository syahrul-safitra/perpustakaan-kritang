<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_transaksi', 'anggota_id', 'user_id', 'tanggal_pinjam',
        'tanggal_harus_kembali', 'tanggal_kembali', 'status', 'total_denda'
    ];

    public const TARIF_DENDA_PER_HARI = 1000;

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    public function hitungDendaOtomatis(): float
    {
        $tglHarusKembali = Carbon::parse($this->tanggal_harus_kembali);
        $tglKembali = $this->tanggal_kembali ? Carbon::parse($this->tanggal_kembali) : Carbon::now();

        if ($tglKembali->greaterThan($tglHarusKembali)) {
            $selisihHari = $tglHarusKembali->diffInDays($tglKembali);
            return $selisihHari * self::TARIF_DENDA_PER_HARI;
        }

        return 0;
    }
}
