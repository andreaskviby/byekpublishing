<?php

namespace Tests\Feature;

use App\Models\ArtPiece;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtPieceDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_art_detail_route_exists(): void
    {
        // Create a test art piece
        $artPiece = ArtPiece::create([
            'title' => 'Test Artwork',
            'slug' => 'test-artwork',
            'description' => 'A beautiful test artwork',
            'image_path' => 'test/path.jpg',
            'medium' => 'Oil on Canvas',
            'dimensions' => '50x70 cm',
            'year' => 2024,
            'is_available' => true,
            'price' => 5000,
            'currency' => 'SEK',
            'sort_order' => 1,
        ]);

        // Verify the route works
        $response = $this->get(route('art.detail', $artPiece));

        $response->assertStatus(200);
        $response->assertSee('Test Artwork');
        $response->assertSee('Oil on Canvas');
    }

    public function test_unavailable_art_piece_returns_404(): void
    {
        // Create an unavailable art piece
        $artPiece = ArtPiece::create([
            'title' => 'Unavailable Artwork',
            'slug' => 'unavailable-artwork',
            'description' => 'This artwork is not available',
            'image_path' => 'test/path.jpg',
            'is_available' => false,
            'sort_order' => 1,
        ]);

        // Verify it returns 404
        $response = $this->get(route('art.detail', $artPiece));

        $response->assertStatus(404);
    }

    public function test_art_gallery_links_to_detail_pages(): void
    {
        // Create a test art piece
        $artPiece = ArtPiece::create([
            'title' => 'Gallery Artwork',
            'slug' => 'gallery-artwork',
            'description' => 'An artwork in the gallery',
            'image_path' => 'test/path.jpg',
            'is_available' => true,
            'price' => 3000,
            'currency' => 'SEK',
            'sort_order' => 1,
        ]);

        // Visit the gallery
        $response = $this->get(route('art'));

        $response->assertStatus(200);
        $response->assertSee(route('art.detail', $artPiece));
    }
}
