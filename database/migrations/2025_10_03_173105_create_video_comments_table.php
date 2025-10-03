<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('you_tube_video_id')->constrained('you_tube_videos')->onDelete('cascade');
            $table->string('comment_id')->unique();
            $table->string('author_name');
            $table->string('author_channel_id')->nullable();
            $table->text('comment_text');
            $table->integer('like_count')->default(0);
            $table->dateTime('published_at');
            $table->boolean('is_approved')->default(true);
            $table->boolean('has_ai_reply')->default(false);
            $table->timestamps();

            $table->index('you_tube_video_id');
            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_comments');
    }
};
