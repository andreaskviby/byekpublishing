<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    public function up(): void
    {
        // Run seeders in order
        Artisan::call('db:seed', ['--class' => 'UserSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'LanguageSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'BookSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'PurchaseLinkSeeder', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'YouTubeVideoSeeder', '--force' => true]);
    }

    public function down(): void
    {
        // No rollback needed for seeders
    }
};
