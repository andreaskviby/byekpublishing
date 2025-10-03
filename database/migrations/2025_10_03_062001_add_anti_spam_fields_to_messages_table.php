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
        Schema::table('messages', function (Blueprint $table) {
            $table->ipAddress('ip_address')->nullable()->after('message');
            $table->string('user_agent')->nullable()->after('ip_address');
            $table->timestamp('submitted_at')->nullable()->after('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'user_agent', 'submitted_at']);
        });
    }
};
