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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('teacher_id')->nullable();
            $table->foreignId('corporation_id')->nullable();
            $table->foreignId('instructor_id')->nullable();
            $table->string('tahun_ajaran');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->enum('status', ['AKTIF', 'TIDAK AKTIF'])->default('AKTIF')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
