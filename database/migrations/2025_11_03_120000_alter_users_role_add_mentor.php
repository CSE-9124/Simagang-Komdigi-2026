<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add 'mentor' to users.role enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','intern','mentor') DEFAULT 'intern' AFTER email");
    }

    public function down(): void
    {
        // Revert to original enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','intern') DEFAULT 'intern' AFTER email");
    }
};


