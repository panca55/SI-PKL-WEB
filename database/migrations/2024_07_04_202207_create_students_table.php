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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('mayor_id');
            $table->string('nisn', 10)->unique();
            $table->string('nama')->nullable();
            $table->string('konsentrasi')->nullable();
            $table->string('tahun_masuk')->nullable();
            $table->enum('jenis_kelamin', ['PRIA', 'WANITA'])->nullable();
            $table->enum('status_pkl', ['BELUM PKL', 'SEDANG PKL', 'SUDAH PKL'])->default('BELUM PKL');
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('alamat_siswa')->nullable();
            $table->string('alamat_ortu')->nullable();
            $table->string('hp_siswa', 13)->nullable();
            $table->string('hp_ortu', 13)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
