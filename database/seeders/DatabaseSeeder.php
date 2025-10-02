<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LanguageSeeder::class,
            BookSeeder::class,
            PurchaseLinkSeeder::class,
            YouTubeVideoSeeder::class,
        ]);
    }
}
