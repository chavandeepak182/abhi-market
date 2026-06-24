<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Google\Client as GoogleClient;
use Google\Service\Gmail;

class GmailController extends Controller
{
    public function redirect()
    {
        $client = new GoogleClient();

        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

        $client->addScope(Gmail::GMAIL_MODIFY);
        $client->addScope('email');
        $client->addScope('profile');

        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return redirect($client->createAuthUrl());
    }

   public function callback(Request $request)
{
    $client = new \Google\Client();

    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));

    $token = $client->fetchAccessTokenWithAuthCode(
        $request->code
    );

    DB::table('gmail_tokens')->updateOrInsert(
        [
            'user_id' => session('user_id')
        ],
        [
            'token' => json_encode($token),
            'updated_at' => now(),
            'created_at' => now()
        ]
    );

    return 'Gmail Connected Successfully';
}
}