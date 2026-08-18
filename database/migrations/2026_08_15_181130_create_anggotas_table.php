<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_induk', 50)->unique(); // NIS (Siswa) / NIP (Guru)
            $table->string('nama_lengkap', 150);
            $table->enum('jenis_anggota', ['siswa', 'guru']);
            $table->string('kelas_or_jabatan', 50);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_telp', 20)->nullable();
            $table->string('password');
            $table->text('alamat')->nullable();
            $table->enum('status_aktif', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
