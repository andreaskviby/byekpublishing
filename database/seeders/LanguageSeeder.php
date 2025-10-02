<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            [
                'name' => 'English',
                'code' => 'en',
                'flag_emoji' => '🇬🇧',
                'is_active' => true,
            ],
            [
                'name' => 'Swedish',
                'code' => 'sv',
                'flag_emoji' => '🇸🇪',
                'is_active' => true,
            ],
            [
                'name' => 'German',
                'code' => 'de',
                'flag_emoji' => '🇩🇪',
                'is_active' => true,
            ],
            [
                'name' => 'Italian',
                'code' => 'it',
                'flag_emoji' => '🇮🇹',
                'is_active' => true,
            ],
            [
                'name' => 'Spanish',
                'code' => 'es',
                'flag_emoji' => '🇪🇸',
                'is_active' => true,
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['code' => $language['code']],
                $language
            );
        }
    }
}
