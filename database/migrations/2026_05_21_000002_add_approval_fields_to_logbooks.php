<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table->string('approval_status')->nullable()->after('photo_path'); // approved, rejected, pending
            $table->foreignId('approved_by')->nullable()->constrained('mentors')->nullOnDelete()->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('approval_note')->nullable()->after('approved_at');
        });
    }

    public function down()
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['approval_status', 'approved_at', 'approval_note']);
        });
    }
};
