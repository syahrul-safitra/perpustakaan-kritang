<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman';

    // Tambahkan properti fillable ini:
    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'jumlah'
    ];

    // Relasi balik ke tabel Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // Relasi ke tabel Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
