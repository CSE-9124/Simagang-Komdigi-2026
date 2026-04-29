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
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->string('no_surat')->nullable()->after('status');
            $table->string('nomor_surat_balasan')->nullable()->after('no_surat');
            $table->string('tujuan_surat')->nullable()->after('nomor_surat_balasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn([
                'no_surat',
                'nomor_surat_balasan',
                'tujuan_surat'
            ]);
        });
    }
};
