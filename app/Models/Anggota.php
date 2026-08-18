<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'user_id', 'nomor_induk', 'nama_lengkap', 'jenis_anggota',
        'kelas_or_jabatan', 'jenis_kelamin', 'no_telp', 'alamat', 'status_aktif', 'password'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
