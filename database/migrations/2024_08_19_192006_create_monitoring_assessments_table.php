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
        Schema::create('monitoring_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id');
            $table->string('nama')->unique();
            $table->integer('softskill')->unsigned();
            $table->integer('norma')->unsigned();
            $table->integer('teknis')->unsigned();
            $table->integer('pemahaman')->unsigned();
            $table->string('catatan')->nullable();
            $table->integer('score')->unsigned()->nullable();
            $table->text('deskripsi_softskill')->nullable();
            $table->text('deskripsi_norma')->nullable();
            $table->text('deskripsi_teknis')->nullable();
            $table->text('deskripsi_pemahaman')->nullable();
            $table->text('deskripsi_catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_assessments');
    }
};
