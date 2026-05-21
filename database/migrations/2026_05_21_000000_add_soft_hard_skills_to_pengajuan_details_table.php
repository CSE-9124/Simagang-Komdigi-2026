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
            $table->string('soft_skill')->nullable()->after('jurusan');
            $table->string('hard_skill')->nullable()->after('soft_skill');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_details', function (Blueprint $table) {
            $table->dropColumn(['soft_skill', 'hard_skill']);
        });
    }
};