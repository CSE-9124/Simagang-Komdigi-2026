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
            $table->string('project_file')->nullable()->after('file_path');
            $table->string('project_link')->nullable()->after('project_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_reports', function (Blueprint $table) {
            $table->dropColumn(['project_file', 'project_link']);
        });
    }
};
