<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Webklex\IMAP\Facades\Client;

class FetchEmails extends Command
{
    protected $signature = 'emails:fetch';

    protected $description = 'Fetch emails via IMAP';

    public function handle()
    {
        try {

            $client = Client::account('default');

            $client->connect();

            $this->info('IMAP Connected');

            $folder = $client->getFolder('INBOX');

            $messages = $folder->messages()
                ->all()
                ->limit(50)
                ->get();

            foreach ($messages as $message) {

                $subject = $message->getSubject();

                $fromEmail = '';

                $from = $message->getFrom();

                if(isset($from[0])){
                    $fromEmail = $from[0]->mail;
                }

                $body = $message->getTextBody();

                $messageId = $message->getMessageId();

                $this->info('Checking : '.$subject);

                // Find Lead
                $lead = DB::table('enquiries')
                    ->where('email', $fromEmail)
                    ->first();

                if(!$lead){

                    $this->error(
                        'Lead Not Found : '.$fromEmail
                    );

                    continue;
                }

                // Duplicate Check
                $exists = DB::table('ai_email_logs')
                    ->where(
                        'gmail_message_id',
                        $messageId
                    )
                    ->exists();

                if($exists){

                    $this->info(
                        'Already Synced'
                    );

                    continue;
                }

                DB::table('ai_email_logs')->insert([

                    'enquiry_id' => $lead->id,

                    'agent_id' => $lead->assigned_to,

                    'email_subject' => $subject,

                    'email_body' => $body,

                    'direction' => 'incoming',

                    'from_email' => $fromEmail,

                    'to_email' => config('mail.from.address'),

                    'gmail_message_id' => $messageId,

                    'status' => 'received',

                    'email_date' => now(),

                    'created_at' => now(),

                    'updated_at' => now()

                ]);

                $this->info(
                    'Saved Reply For Lead : '.$lead->id
                );
            }

        } catch (\Exception $e) {

            $this->error(
                $e->getMessage()
            );
        }
    }
}