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
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->check('rating >= 1 AND rating <= 5'); // 1-5 butterflies
            $table->text('review_text')->nullable(); // Optional review text
            $table->string('reviewer_signature')->nullable(); // Optional signature/name
            $table->string('reviewer_email')->nullable(); // For verification and newsletter
            $table->boolean('subscribed_to_newsletter')->default(false);
            $table->boolean('is_approved')->default(false); // Admin approval required
            $table->boolean('is_verified')->default(false); // Email verification
            $table->string('verification_token')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->ipAddress('ip_address'); // For spam prevention
            $table->string('user_agent')->nullable(); // For spam prevention
            $table->timestamp('submitted_at');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['book_id', 'is_approved']);
            $table->index(['language_id', 'is_approved']);
            $table->index(['is_approved', 'submitted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_reviews');
    }
};
