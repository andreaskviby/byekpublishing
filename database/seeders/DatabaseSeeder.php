<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Linda Ettehag Kviby',
            'email' => 'linda@byekpublishing.com',
        ]);

        $this->call([
            LanguageSeeder::class,
            BookSeeder::class,
            PurchaseLinkSeeder::class,
        ]);
    }
}
