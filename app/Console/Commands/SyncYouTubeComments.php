<?php

namespace App\Console\Commands;

use App\Models\VideoComment;
use App\Models\YouTubeVideo;
use App\Services\OpenAIService;
use App\Services\YouTubeService;
use Illuminate\Console\Command;

class SyncYouTubeComments extends Command
{
    protected $signature = 'sync:youtube-comments {--with-replies : Generate AI replies for new comments}';

    protected $description = 'Sync YouTube comments from all videos';

    public function handle(YouTubeService $youtubeService, OpenAIService $openAIService): int
    {
        $this->info('Starting YouTube comments sync...');

        $count = $youtubeService->syncComments();

        if ($count === 0) {
            $this->warn('No comments synced.');
            return self::SUCCESS;
        }

        $this->comment("Successfully synced {$count} comments from YouTube.");

        // Generate and post AI replies if flag is set
        if ($this->option('with-replies')) {
            $this->info('Generating AI replies for comments without replies...');

            $repliesCount = 0;

            // Get videos that don't have AI replies yet
            $videos = YouTubeVideo::whereHas('comments', function ($query) {
                $query->where('is_approved', true)
                    ->where('has_ai_reply', false);
            })->get();

            foreach ($videos as $video) {
                // Only reply to one comment per video
                $comment = $video->comments()
                    ->where('is_approved', true)
                    ->where('has_ai_reply', false)
                    ->orderBy('published_at', 'desc')
                    ->first();

                if ($comment) {
                    $this->info("Generating reply for comment from {$comment->author_name} on video '{$video->title}'...");

                    try {
                        $replyText = $openAIService->generateCommentReply($comment->comment_text);

                        if ($youtubeService->replyToComment($comment, $replyText)) {
                            $this->comment("Successfully posted reply to {$comment->author_name}.");
                            $repliesCount++;
                        }
                    } catch (\Exception $e) {
                        $this->error("Failed to generate/post reply: {$e->getMessage()}");
                    }
                }
            }

            $this->comment("Successfully posted {$repliesCount} AI replies.");
        }

        return self::SUCCESS;
    }
}
