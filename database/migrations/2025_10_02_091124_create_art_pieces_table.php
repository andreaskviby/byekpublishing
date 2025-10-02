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
        Schema::create('art_pieces', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path');
            $table->string('medium')->nullable();
            $table->string('dimensions')->nullable();
            $table->integer('year')->nullable();
            $table->boolean('is_available')->default(true);
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency')->default('SEK');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('art_pieces');
    }
};
