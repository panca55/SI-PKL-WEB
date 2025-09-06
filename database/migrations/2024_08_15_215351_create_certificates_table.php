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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id');
            $table->enum('category', ['UMUM', 'KOMPETENSI UTAMA', 'KOMPETENSI PENUNJANG']);
            $table->string('nama')->nullable();
            $table->integer('score')->unsigned();
            $table->string('predikat')->nullable();
            $table->string('file')->nullable();
            $table->string('nama_pimpinan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
