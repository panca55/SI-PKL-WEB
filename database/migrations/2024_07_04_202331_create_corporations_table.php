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
        Schema::create('corporations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nama')->nullable();
            $table->string('slug')->unique();
            $table->string('alamat')->nullable();
            $table->integer('quota')->nullable();
            $table->enum('mulai_hari_kerja', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->enum('akhir_hari_kerja', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_mulai')->nullable();
            $table->time('jam_berakhir')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('hp', 13)->nullable();
            $table->string('email_perusahaan')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('logo')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporations');
    }
};
