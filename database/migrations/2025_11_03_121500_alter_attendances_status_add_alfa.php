<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan 'alfa' ke enum status absensi
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('hadir','izin','sakit','alfa') NOT NULL");
    }

    public function down(): void
    {
        // Kembalikan tanpa 'alfa'
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('hadir','izin','sakit') NOT NULL");
    }
};


