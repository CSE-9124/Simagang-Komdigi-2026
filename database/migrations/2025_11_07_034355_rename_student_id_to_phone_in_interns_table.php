<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, use ALTER TABLE to rename column
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE interns CHANGE student_id phone VARCHAR(255) NULL');
        } else {
            Schema::table('interns', function (Blueprint $table) {
                $table->renameColumn('student_id', 'phone');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For MySQL, use ALTER TABLE to rename column back
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE interns CHANGE phone student_id VARCHAR(255) NULL');
        } else {
            Schema::table('interns', function (Blueprint $table) {
                $table->renameColumn('phone', 'student_id');
            });
        }
    }
};
