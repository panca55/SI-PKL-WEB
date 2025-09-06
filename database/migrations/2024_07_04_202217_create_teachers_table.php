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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nip', 20)->unique()->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['PRIA', 'WANITA']);
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('alamat');
            $table->string('hp', 13);
            $table->string('golongan')->nullable();
            $table->string('bidang_studi');
            $table->string('pendidikan_terakhir');
            $table->string('jabatan');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
