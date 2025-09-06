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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id');
            $table->enum('category', ['KOMPETENSI', 'LAINNYA'])->nullable();
            $table->date('tanggal');
            $table->string('judul');
            $table->enum('bentuk_kegiatan', ['BIMBINGAN', 'MANDIRI'])->nullable();
            $table->enum('penugasan_pekerjaan', ['DITUGASKAN', 'INISIATIF'])->nullable();
            $table->time('mulai');
            $table->time('selesai');
            $table->string('petugas');
            $table->text('isi');
            $table->string('foto_kegiatan')->nullable();
            $table->enum('keterangan', ['TUNTAS', 'BELUM TUNTAS'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
