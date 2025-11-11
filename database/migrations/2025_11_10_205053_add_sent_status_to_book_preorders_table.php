<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For SQLite, we need to recreate the table to modify the enum
        Schema::dropIfExists('book_preorders_temp');
        
        // Create temporary table with new enum values
        Schema::create('book_preorders_temp', function (Blueprint $table) {
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
            $table->enum('payment_status', ['pending', 'paid', 'sent', 'expired'])->default('pending');
            $table->timestamp('payment_deadline');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
        
        // Copy data from original table
        DB::statement("INSERT INTO book_preorders_temp SELECT * FROM book_preorders");
        
        // Drop original and rename temp
        Schema::dropIfExists('book_preorders');
        Schema::rename('book_preorders_temp', 'book_preorders');
    }

    public function down(): void
    {
        // Reverse the process
        Schema::dropIfExists('book_preorders_temp');
        
        Schema::create('book_preorders_temp', function (Blueprint $table) {
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
        
        DB::statement("INSERT INTO book_preorders_temp SELECT * FROM book_preorders");
        
        Schema::dropIfExists('book_preorders');
        Schema::rename('book_preorders_temp', 'book_preorders');
    }
};
