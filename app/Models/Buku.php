<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'kategori_id', 'isbn', 'judul', 'pengarang', 
        'penerbit', 'tahun_terbit', 'stok', 'lokasi_rak', 'cover'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
