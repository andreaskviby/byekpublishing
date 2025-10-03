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
        // Add slug to books table
        Schema::table('books', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title')->nullable();
            $table->text('meta_description')->nullable()->after('description');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });

        // Add slug to art_pieces table
        Schema::table('art_pieces', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title')->nullable();
            $table->text('meta_description')->nullable()->after('description');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });

        // Add slug to music_releases table
        Schema::table('music_releases', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title')->nullable();
            $table->text('meta_description')->nullable()->after('artist_name');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });

        // Add slug to you_tube_videos table
        Schema::table('you_tube_videos', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title')->nullable();
            $table->text('meta_description')->nullable()->after('description');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });

        // Add meta fields to blog_posts table (already has slug)
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->text('meta_description')->nullable()->after('excerpt');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['slug', 'meta_description', 'meta_keywords']);
        });

        Schema::table('art_pieces', function (Blueprint $table) {
            $table->dropColumn(['slug', 'meta_description', 'meta_keywords']);
        });

        Schema::table('music_releases', function (Blueprint $table) {
            $table->dropColumn(['slug', 'meta_description', 'meta_keywords']);
        });

        Schema::table('you_tube_videos', function (Blueprint $table) {
            $table->dropColumn(['slug', 'meta_description', 'meta_keywords']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['meta_description', 'meta_keywords']);
        });
    }
};
