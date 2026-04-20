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
        Schema::table('pengajuan_details', function (Blueprint $table) {
            $table->string('email')->nullable()->after('nama');
            $table->string('no_telp')->nullable()->after('email'); 
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('no_telp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_details', function (Blueprint $table) {
            $table->dropColumn(['no_telp', 'jenis_kelamin', 'email']);
        });
    }
};
