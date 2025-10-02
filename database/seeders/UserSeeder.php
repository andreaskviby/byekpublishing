<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Linda Ettehag Kviby',
            'email' => 'linda@byekpublishing.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@byekpublishing.com',
            'password' => Hash::make('VIAGANCI2023!!'),
        ]);
    }
}
