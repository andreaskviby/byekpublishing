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
        Schema::table('events', function (Blueprint $table) {
            $table->string('hero_banner_image')->nullable()->after('is_active');
            $table->string('hero_graphic_image')->nullable()->after('hero_banner_image');
            $table->string('hero_subtitle')->nullable()->after('hero_graphic_image');
            $table->string('hero_badge_text')->nullable()->after('hero_subtitle');
            $table->text('hero_call_to_action')->nullable()->after('hero_badge_text');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'hero_banner_image',
                'hero_graphic_image',
                'hero_subtitle',
                'hero_badge_text',
                'hero_call_to_action',
            ]);
        });
    }
};
