<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Webklex\IMAP\Facades\Client;
class SyncCustomerEmails extends Command
{
    protected $signature = 'emails:sync';

    protected $description = 'Sync customer email replies from Gmail';

    public function handle()
    {
        ini_set('memory_limit', '1024M');
        try {

            $client = Client::account('default');

            $client->connect();

            $this->info('Connected to Gmail');
            $folder = $client->getFolder('INBOX');

$messages = $folder->query()
    ->since(now()->subHours(1))
    ->limit(20)
    ->get();
$this->info('Total Messages Found: '.$messages->count());
            foreach ($messages as $message) {

                try {

                    $messageId = $message->getMessageId();
                    $this->info('Message ID: '.$messageId);

                    $exists = DB::table('ai_email_logs')
                        ->where('gmail_message_id', $messageId)
                        ->exists();
if ($exists) {
    $this->warn('Already Imported: '.$messageId);
    continue;
}

$from = '';

if (!empty($message->getFrom())) {

    $fromObj = $message->getFrom()->first();

    if ($fromObj) {
        $from = strtolower(trim($fromObj->mail));

        $this->info('Sender Email: ' . $from);
        $this->info('Subject: ' . $message->getSubject());
    }
}

if (empty($from)) {
    $this->warn('No sender email found');
    continue;
}
$enquiry = DB::table('enquiries')
    ->whereRaw('LOWER(email) = ?', [strtolower(trim($from))])
    ->latest('id')
    ->first();

if (!$enquiry) {
    $this->error('No enquiry found for: '.$from);
    continue;
}

$this->info('Matched Enquiry ID: '.$enquiry->id);

                    DB::table('ai_email_logs')->insert([

                        'enquiry_id' => $enquiry->id,

                        'email_subject' => $message->getSubject(),

                        'email_body' => $message->getHTMLBody(),

                        'status' => 'sent',

                        'direction' => 'incoming',

                        'message_source' => 'customer',

                        'from_email' => $from,

                        'to_email' => env('MAIL_FROM_ADDRESS'),

                        'gmail_message_id' => $messageId,

'email_date' => $message->getDate(),
                        'agent_id' => $enquiry->assigned_to,

                        'replied' => 1,

                        'created_at' => now(),

                        'updated_at' => now(),
                    ]);

                    $this->info("Imported reply from {$from}");

                } catch (\Exception $e) {

                    $this->error($e->getMessage());
                }
            }

            $this->info('Sync Completed');

        } catch (\Exception $e) {

            $this->error($e->getMessage());
        }
    }
}