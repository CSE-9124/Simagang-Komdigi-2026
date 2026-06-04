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
        Schema::create('industris', function (Blueprint $table) {
            $table->id();

            // Relasi ke user
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Informasi perusahaan
            $table->string('nama_industri');
            $table->string('logo_industri')->nullable();
            $table->string('bidang_industri');
            $table->text('deskripsi_industri')->nullable();

            // Alamat
            $table->text('alamat_industri');
            $table->string('kota_kabupaten');

            // Kontak
            $table->string('email_industri')->unique();
            $table->string('nomor_telepon_industri');

            // Legalitas
            $table->string('nib')->nullable();

            // Status
            $table->enum('status', [
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
        Schema::dropIfExists('industris');
    }
};
