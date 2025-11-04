<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('micro_skill_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('photo_path');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('reviewer_type')->nullable(); // 'admin' atau 'mentor'
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->text('review_note')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['intern_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('micro_skill_submissions');
    }
};


