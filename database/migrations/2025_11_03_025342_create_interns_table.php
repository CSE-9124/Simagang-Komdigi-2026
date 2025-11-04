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
        Schema::create('interns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->enum('education_level', ['SMA/SMK', 'S1/D4']);
            $table->string('major')->nullable();
            $table->string('student_id')->nullable(); // NIM/NIS
            $table->string('institution');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('photo_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
