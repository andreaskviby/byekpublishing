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
        Schema::create('music_releases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist_name')->default('By Ek Publishing AI Experiment');
            $table->string('album_cover')->nullable();
            $table->string('release_type')->default('single');
            $table->date('release_date');
            $table->string('spotify_url')->nullable();
            $table->string('apple_music_url')->nullable();
            $table->string('youtube_music_url')->nullable();
            $table->string('distrokid_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('music_releases');
    }
};
