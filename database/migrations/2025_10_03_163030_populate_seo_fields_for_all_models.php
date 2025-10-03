<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $this->populateArtPieces();
        $this->populateBooks();
        $this->populateMusicReleases();
        $this->populateYouTubeVideos();
    }

    public function down(): void
    {
        //
    }

    private function populateArtPieces(): void
    {
        $artPieces = DB::table('art_pieces')->get();

        foreach ($artPieces as $art) {
            $updates = [];

            // Populate meta_description from description if empty
            if (empty($art->meta_description) && !empty($art->description)) {
                $updates['meta_description'] = Str::limit($art->description, 160, '');
            }

            // Generate keywords if empty
            if (empty($art->meta_keywords)) {
                $keywords = $this->extractKeywords(
                    $art->title,
                    $art->description ?? ''
                );
                $updates['meta_keywords'] = $keywords;
            }

            if (!empty($updates)) {
                DB::table('art_pieces')
                    ->where('id', $art->id)
                    ->update($updates);
            }
        }
    }

    private function populateBooks(): void
    {
        $books = DB::table('books')->get();

        foreach ($books as $book) {
            $updates = [];

            // Populate meta_description from description if empty
            if (empty($book->meta_description) && !empty($book->description)) {
                $updates['meta_description'] = Str::limit($book->description, 160, '');
            }

            // Generate keywords if empty
            if (empty($book->meta_keywords)) {
                $keywords = $this->extractKeywords(
                    $book->title,
                    $book->description ?? '',
                    $book->genre ?? ''
                );
                $updates['meta_keywords'] = $keywords;
            }

            if (!empty($updates)) {
                DB::table('books')
                    ->where('id', $book->id)
                    ->update($updates);
            }
        }
    }

    private function populateMusicReleases(): void
    {
        $musicReleases = DB::table('music_releases')->get();

        foreach ($musicReleases as $music) {
            $updates = [];

            // For music, we only have title and artist_name to work with
            if (empty($music->meta_description)) {
                $description = "{$music->title} by {$music->artist_name}";
                if (!empty($music->release_type)) {
                    $description .= " - {$music->release_type}";
                }
                $updates['meta_description'] = Str::limit($description, 160, '');
            }

            // Generate keywords if empty
            if (empty($music->meta_keywords)) {
                $keywords = $this->extractKeywords(
                    $music->title,
                    $music->artist_name ?? '',
                    $music->release_type ?? ''
                );
                $updates['meta_keywords'] = $keywords;
            }

            if (!empty($updates)) {
                DB::table('music_releases')
                    ->where('id', $music->id)
                    ->update($updates);
            }
        }
    }

    private function populateYouTubeVideos(): void
    {
        $videos = DB::table('you_tube_videos')->get();

        foreach ($videos as $video) {
            $updates = [];

            // Populate meta_description from description if empty
            if (empty($video->meta_description) && !empty($video->description)) {
                $updates['meta_description'] = Str::limit($video->description, 160, '');
            }

            // Generate keywords if empty
            if (empty($video->meta_keywords)) {
                $keywords = $this->extractKeywords(
                    $video->title,
                    $video->description ?? ''
                );
                $updates['meta_keywords'] = $keywords;
            }

            if (!empty($updates)) {
                DB::table('you_tube_videos')
                    ->where('id', $video->id)
                    ->update($updates);
            }
        }
    }

    private function extractKeywords(string ...$texts): string
    {
        // Combine all text inputs
        $combinedText = implode(' ', array_filter($texts));

        // Remove special characters and convert to lowercase
        $cleanText = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', ' ', $combinedText));

        // Common stop words to exclude
        $stopWords = [
            'the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for',
            'of', 'with', 'by', 'from', 'as', 'is', 'was', 'are', 'were', 'be',
            'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'will',
            'would', 'should', 'could', 'may', 'might', 'must', 'can', 'this',
            'that', 'these', 'those', 'i', 'you', 'he', 'she', 'it', 'we', 'they',
            'what', 'which', 'who', 'when', 'where', 'why', 'how', 'all', 'each',
            'every', 'both', 'few', 'more', 'most', 'other', 'some', 'such', 'no',
            'nor', 'not', 'only', 'own', 'same', 'so', 'than', 'too', 'very'
        ];

        // Split into words
        $words = preg_split('/\s+/', $cleanText);

        // Filter out stop words and short words
        $keywords = array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 3 && !in_array($word, $stopWords);
        });

        // Count word frequency
        $wordCounts = array_count_values($keywords);

        // Sort by frequency (descending)
        arsort($wordCounts);

        // Take top 10 keywords
        $topKeywords = array_slice(array_keys($wordCounts), 0, 10);

        // Return as comma-separated string
        return implode(', ', $topKeywords);
    }
};
