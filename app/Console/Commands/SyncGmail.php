<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Google\Client;
use Google\Service\Gmail;


class SyncGmail extends Command
{
    protected $signature = 'gmail:sync';

    protected $description = 'Sync Gmail Conversations';

    public function handle()
{
    $this->info('Starting Gmail Sync...');

    $tokenRow = DB::table('gmail_tokens')->first();

    if (!$tokenRow) {

        $this->error('No Gmail Token Found');
        return;
    }

    $token = json_decode($tokenRow->token, true);

    $client = new Client();

    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setAccessToken($token);

   if ($client->isAccessTokenExpired()) {

    $refreshToken = $token['refresh_token'] ?? null;

    if (!$refreshToken) {

        $this->error('Refresh Token Missing');

        return;
    }

    $newToken = $client->fetchAccessTokenWithRefreshToken(
        $refreshToken
    );

    $newToken['refresh_token'] = $refreshToken;

    DB::table('gmail_tokens')
        ->where('id', $tokenRow->id)
        ->update([
            'token' => json_encode($newToken),
            'updated_at' => now()
        ]);

    $client->setAccessToken($newToken);

    $this->info('Token Refreshed Successfully');
}

    $gmail = new Gmail($client);

    $messages = $gmail->users_messages->listUsersMessages(
        'me',
        [
            'maxResults' => 20
        ]
    );

    foreach ($messages->getMessages() as $message) {

        $msg = $gmail->users_messages->get(
            'me',
            $message->getId(),
            [
                'format' => 'full'
            ]
        );

        $headers = $msg->getPayload()->getHeaders();

        $from = '';
        $to = '';
        $subject = '';

        foreach ($headers as $header) {

            if ($header->getName() == 'From') {
                $from = $header->getValue();
            }

            if ($header->getName() == 'To') {
                $to = $header->getValue();
            }

            if ($header->getName() == 'Subject') {
                $subject = $header->getValue();
            }
        }

        $body = '';

$body = '';

$payload = $msg->getPayload();

$parts = $payload->getParts();

if ($parts) {

    foreach ($parts as $part) {

        // Plain text
     if ($part->getMimeType() == 'text/plain') {

    $body = $part->getBody()->getData();

    $body = base64_decode(
        strtr($body, '-_', '+/')
    );

    $this->info('BODY => '.$body);

    break;
}
        // Nested parts
        if ($part->getParts()) {

            foreach ($part->getParts() as $subPart) {

                if (
                    $subPart->getMimeType() == 'text/plain'
                ) {

                    $body = $subPart
                        ->getBody()
                        ->getData();

                    $body = base64_decode(
                        strtr($body, '-_', '+/')
                    );

                    break 2;
                }
            }
        }
    }
}

$this->info('BODY => '.$body);

        $email = '';

        if (preg_match('/<(.+?)>/', $from, $matches)) {

            $email = $matches[1];

        } else {

            $email = $from;
        }

$subjectSearch = preg_replace('/^Re:\s*/i', '', $subject);
$subjectSearch = trim($subjectSearch);

$oldEmail = DB::table('ai_email_logs')
    ->where('email_subject', 'like', '%' . $subjectSearch . '%')
    ->orderByDesc('id')
    ->first();

if ($oldEmail) {

    $lead = DB::table('enquiries')
        ->where('id', $oldEmail->enquiry_id)
        ->first();

} else {

    $cleanSubject = str_replace(
        'Your Inquiry —',
        '',
        $subjectSearch
    );

    $lead = DB::table('enquiries')
        ->where('page_name', 'like', '%' . trim($cleanSubject) . '%')
        ->first();
}

if (!$lead) {

    $this->error('NO LEAD FOUND');
    $this->error('SUBJECT : '.$subject);

    continue;
}

$this->info('LEAD FOUND : '.$lead->id);

        $exists = DB::table('ai_email_logs')
            ->where(
                'gmail_message_id',
                $message->getId()
            )
            ->exists();

        if ($exists) {
            continue;
        }

        DB::table('ai_email_logs')->insert([

            'enquiry_id' => $lead->id,
            'agent_id' => $lead->assigned_to,

            'email_subject' => $subject,

            'email_body' => $body,

            'direction' => (
    str_contains(
        strtolower($email),
        'm2squareconsultancy.com'
    )
) ? 'outgoing' : 'incoming',

            'from_email' => $email,

            'to_email' => $to,

            'gmail_message_id' => $message->getId(),

            'message_source' => (
    str_contains(
        strtolower($email),
        'm2squareconsultancy.com'
    )
) ? 'agent' : 'customer',

            'email_date' => now(),

            'status' => 'sent',

            'created_at' => now(),

            'updated_at' => now()

        ]);

        $this->info('Saved : '.$email);
    }

    $this->info('Sync Completed');
}
}