<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApolloService
{
    public function searchCompany($companyName)
    {
        try {

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => env('APOLLO_API_KEY')
            ])->post(
                'https://api.apollo.io/api/v1/organizations/search',
                [
                    'q_organization_name' => $companyName,
                    'page' => 1,
                    'per_page' => 1
                ]
            );

            Log::info('Apollo Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return $response->json();

        } catch (\Throwable $e) {

            Log::error('Apollo Error', [
                'message' => $e->getMessage()
            ]);

            return [];
        }
    }
}