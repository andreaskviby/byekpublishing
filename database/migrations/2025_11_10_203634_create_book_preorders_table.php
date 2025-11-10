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
        Schema::create('book_preorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('street_address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('country')->default('Sverige');
            $table->text('dedication_message')->nullable();
            $table->boolean('wants_gift_wrap')->default(false);
            $table->decimal('total_price', 10, 2)->default(199.00);
            $table->enum('payment_status', ['pending', 'paid', 'expired'])->default('pending');
            $table->timestamp('payment_deadline');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_preorders');
    }
};
