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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['hadir', 'izin', 'sakit']);
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('photo_path')->nullable(); // For "hadir" status
            $table->text('note')->nullable(); // For "izin" and "sakit"
            $table->string('document_path')->nullable(); // For "izin" and "sakit"
            $table->enum('document_status', ['pending', 'approved', 'rejected'])->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamps();
            
            $table->unique(['intern_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
