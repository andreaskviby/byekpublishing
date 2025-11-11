<?php

namespace Database\Seeders;

use App\Models\ArtPiece;
use Illuminate\Database\Seeder;

class ArtPieceSeeder extends Seeder
{
    public function run(): void
    {
        ArtPiece::create([
            'title' => 'Coastal Dreams',
            'description' => 'A vibrant abstract interpretation of the Swedish west coast, capturing the essence of sea and sky through bold brushstrokes and vivid colors.',
            'image_path' => '/images/art/coastal-dreams.jpg',
            'medium' => 'Oil on Canvas',
            'dimensions' => '80 x 60 cm',
            'year' => 2023,
            'is_available' => true,
            'price' => 8500.00,
            'currency' => 'SEK',
            'sort_order' => 1,
        ]);

        ArtPiece::create([
            'title' => 'Midnight Sun',
            'description' => 'An ethereal landscape inspired by the northern midnight sun, combining warm golden tones with cool blues to create a dreamlike atmosphere.',
            'image_path' => '/images/art/midnight-sun.jpg',
            'medium' => 'Acrylic on Canvas',
            'dimensions' => '100 x 70 cm',
            'year' => 2024,
            'is_available' => true,
            'price' => 12000.00,
            'currency' => 'SEK',
            'sort_order' => 2,
        ]);

        ArtPiece::create([
            'title' => 'Forest Whispers',
            'description' => 'A mystical forest scene where light filters through ancient trees, creating an interplay of shadows and illumination that speaks to the soul.',
            'image_path' => '/images/art/forest-whispers.jpg',
            'medium' => 'Watercolor on Paper',
            'dimensions' => '50 x 40 cm',
            'year' => 2023,
            'is_available' => true,
            'price' => 4500.00,
            'currency' => 'SEK',
            'sort_order' => 3,
        ]);

        ArtPiece::create([
            'title' => 'Urban Rhythm',
            'description' => 'A dynamic cityscape that captures the energy and movement of modern urban life, with geometric forms and vibrant colors creating visual harmony.',
            'image_path' => '/images/art/urban-rhythm.jpg',
            'medium' => 'Mixed Media',
            'dimensions' => '90 x 90 cm',
            'year' => 2024,
            'is_available' => false,
            'price' => 15000.00,
            'currency' => 'SEK',
            'sort_order' => 4,
        ]);

        ArtPiece::create([
            'title' => 'Solitude',
            'description' => 'A minimalist composition exploring themes of isolation and inner peace, using subtle color gradients and simple forms to evoke deep emotion.',
            'image_path' => '/images/art/solitude.jpg',
            'medium' => 'Oil on Canvas',
            'dimensions' => '60 x 60 cm',
            'year' => 2022,
            'is_available' => true,
            'price' => 6800.00,
            'currency' => 'SEK',
            'sort_order' => 5,
        ]);

        ArtPiece::create([
            'title' => 'Spring Awakening',
            'description' => 'A celebration of new beginnings, this piece captures the fresh energy of spring with delicate blossoms and hopeful color palettes.',
            'image_path' => '/images/art/spring-awakening.jpg',
            'medium' => 'Watercolor and Ink',
            'dimensions' => '45 x 35 cm',
            'year' => 2024,
            'is_available' => true,
            'price' => 3200.00,
            'currency' => 'SEK',
            'sort_order' => 6,
        ]);

        ArtPiece::create([
            'title' => 'Nordic Light',
            'description' => 'Inspired by the unique quality of Nordic light, this piece captures the subtle beauty of winter landscapes with soft blues and gentle whites.',
            'image_path' => '/images/art/nordic-light.jpg',
            'medium' => 'Oil on Canvas',
            'dimensions' => '75 x 55 cm',
            'year' => 2023,
            'is_available' => true,
            'price' => 9200.00,
            'currency' => 'SEK',
            'sort_order' => 7,
        ]);

        ArtPiece::create([
            'title' => 'Emotional Landscape',
            'description' => 'An abstract exploration of human emotions translated into color and form, creating a powerful visual narrative that resonates with viewers.',
            'image_path' => '/images/art/emotional-landscape.jpg',
            'medium' => 'Acrylic on Canvas',
            'dimensions' => '120 x 80 cm',
            'year' => 2024,
            'is_available' => true,
            'price' => 18500.00,
            'currency' => 'SEK',
            'sort_order' => 8,
        ]);
    }
}
