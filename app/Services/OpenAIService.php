<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    private $client;
    private string $model;

    public function __construct()
    {
        $apiKey = config('services.openai.api_key');
        $organization = config('services.openai.organization');

        $this->client = OpenAI::client($apiKey, $organization);
        $this->model = config('services.openai.model', 'gpt-4-turbo');
    }

    public function generateCommentReply(string $commentText): string
    {
        $response = $this->client->chat()->create([
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are Linda Ettehag Kviby, a Swedish author and creative artist who bought an adventure property in Sicily, Italy. You create content about your Sicilian adventure through books, art, and multimedia. You are always polite, nice, and super friendly when replying to comments on your YouTube channel "We Bought an Adventure in Sicily". Always reply in the same language as the comment. Keep your replies warm, personal, and encouraging. Use 1-3 sentences maximum.'
                ],
                [
                    'role' => 'user',
                    'content' => "Please write a friendly reply to this comment: {$commentText}"
                ]
            ],
            'max_completion_tokens' => 150,
        ]);

        return trim($response->choices[0]->message->content);
    }
}
