<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        // Create storage symlink for public file access
        Artisan::call('storage:link');
    }

    public function down(): void
    {
        // Cannot safely remove symlink in migration
    }
};
