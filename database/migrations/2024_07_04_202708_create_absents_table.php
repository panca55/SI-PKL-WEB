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
        Schema::create('absents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id');
            $table->date('tanggal');
            $table->enum('keterangan', ['HADIR', 'IZIN', 'SAKIT', 'ALPHA']);
            $table->string('deskripsi')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absents');
    }
};
