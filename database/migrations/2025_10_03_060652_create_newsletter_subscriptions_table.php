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
        Schema::create('newsletter_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('is_verified')->default(false);
            $table->string('verification_token')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->ipAddress('ip_address'); // For spam prevention
            $table->string('user_agent')->nullable(); // For spam prevention
            $table->string('source')->default('website'); // Source of subscription (review, contact, etc.)
            $table->timestamps();
            
            // Indexes
            $table->index(['email', 'is_verified']);
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscriptions');
    }
};
