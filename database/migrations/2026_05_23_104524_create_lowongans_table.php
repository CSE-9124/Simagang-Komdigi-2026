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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();

            // Relasi ke industri
            $table->foreignId('industri_id')
                ->constrained()
                ->onDelete('cascade');

            // Informasi lowongan
            $table->string('judul_lowongan');
            $table->string('posisi_magang');
            $table->string('divisi')->nullable();

            // Detail lowongan
            $table->text('deskripsi_pekerjaan');
            $table->text('requirements');

            // Kuota & durasi
            $table->integer('kuota_peserta')->default(1);
            $table->string('durasi_magang');

            // Status lowongan
            $table->enum('status', [
                'draft',
                'dibuka',
                'ditutup'
            ])->default('draft');

            // Status lowongan verifikasi admin
            $table->enum('status_verifikasi', [
                'pending',
                'disetujui',
                'ditolak'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};