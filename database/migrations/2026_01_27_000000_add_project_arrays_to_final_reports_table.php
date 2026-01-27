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
            if (!Schema::hasColumn('final_reports', 'project_files')) {
                $table->json('project_files')->nullable()->after('project_file_name');
            }
            if (!Schema::hasColumn('final_reports', 'project_links')) {
                $table->json('project_links')->nullable()->after('project_files');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_reports', function (Blueprint $table) {
            $table->dropColumn(['project_files', 'project_links']);
        });
    }
};
