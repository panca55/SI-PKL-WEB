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
        Schema::create('job_markets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corporation_id');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->text('persyaratan');
            $table->enum('jenis_pekerjaan', ['Full-time', 'Part-time', 'Magang']);
            $table->string('lokasi');
            $table->string('rentang_gaji');
            $table->date('batas_pengiriman');
            $table->string('contact_email');
            $table->string('foto')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_markets');
    }
};
