<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClaudeService
{
    public function generate($prompt)
    {
        $response = Http::withHeaders([
            'x-api-key' => env('CLAUDE_API_KEY'),
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json'
        ])->post('https://api.anthropic.com/v1/messages', [

            'model' => env('CLAUDE_MODEL'),
            'max_tokens' => 2500,

            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ]
        ]);

        Log::info('Claude Status', [
            'status' => $response->status()
        ]);

        Log::info('Claude Raw Response', [
            'body' => $response->body()
        ]);

        return $response->json();
    }
}