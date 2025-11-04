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
        Schema::table('final_reports', function (Blueprint $table) {
            $table->enum('grade', ['A', 'B', 'C'])->nullable()->after('status');
            $table->boolean('needs_revision')->default(false)->after('grade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_reports', function (Blueprint $table) {
            $table->dropColumn(['grade', 'needs_revision']);
        });
    }
};
