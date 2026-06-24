<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportThankYouMail;
use App\Services\ApolloService;
use App\Services\ClaudeService;

class ProcessEnquiryAI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $enquiryId;

    public function __construct($enquiryId)
    {
        $this->enquiryId = $enquiryId;
    }

   public function handle()
{
    try {

        Log::info('Job started', [
            'enquiry_id' => $this->enquiryId
        ]);

        $enquiry = DB::table('enquiries')
            ->where('id', $this->enquiryId)
            ->first();

        if (!$enquiry) {

            Log::error('Enquiry not found');

            return;
        }

       Log::info('Enquiry Data', [
    'id' => $enquiry->id,
    'name' => $enquiry->name,
    'job_title' => $enquiry->job_title,
    'page_name' => $enquiry->page_name,
    'company_name' => $enquiry->company_name
]);

        $claude = new ClaudeService();

        Log::info('Calling Claude');
       $companyData = [];

if (!empty($enquiry->company_name)) {

    $apollo = new \App\Services\ApolloService();

    $companyData = $apollo->searchCompany(
        $enquiry->company_name
    );
}

Log::info('Apollo Company Data', [
    'data' => $companyData
]);
  $response = $claude->generate("
You are a senior B2B market research sales consultant at M2Square Consultancy.

Lead Information:

Client Name:
{$enquiry->name}

Client Designation:
{$enquiry->job_title}

Client Company:
{$enquiry->company_name}

Country:
{$enquiry->visitor_country}

Report:
{$enquiry->page_name}

Company Intelligence:
".json_encode($companyData)."

TASK

Generate ONLY:

1. Email Subject
2. Introductory Email Body
3. Three Qualification Questions

VERY IMPORTANT RULES

EMAIL BODY RULES:

DO NOT start with Dear
DO NOT start with Hi
DO NOT start with Hello
DO NOT mention customer name
DO NOT include any questions
DO NOT include numbered points
DO NOT include question marks
DO NOT include closing statement
DO NOT include regards
DO NOT include signature

The email_body should ONLY:

Thank the prospect for the enquiry
Mention the report title
Mention that we would like to understand their requirements better before sharing relevant report insights
Max
imum 80 words

QUESTIONS RULES

Return EXACTLY 3 questions.

Question 1:
Understand the primary use case.

Question 2:
Understand the geographic focus.

Question 3:
Understand the business decision or strategic initiative.

Questions must be returned ONLY inside the questions array.

SUBJECT RULE

Subject should be:

Your Inquiry — {$enquiry->page_name}

RETURN ONLY VALID JSON

{
    \"subject\": \"\",
    \"email_body\": \"\",
    \"questions\": [
        \"\",
        \"\",
        \"\"
    ]
}
");
        Log::info('Claude Response', [
            'response' => $response
        ]);

        $jsonText = $response['content'][0]['text'] ?? '';

Log::info('Raw JSON Response', [
    'json' => $jsonText
]);

$jsonText = str_replace('```json', '', $jsonText);
$jsonText = str_replace('```', '', $jsonText);
$jsonText = trim($jsonText);

$result = json_decode($jsonText, true);

if (json_last_error() !== JSON_ERROR_NONE) {

    Log::error('JSON Decode Error', [
        'error' => json_last_error_msg(),
        'response' => $jsonText
    ]);

    DB::table('ai_email_logs')->insert([
        'enquiry_id' => $enquiry->id,
        'status' => 'failed',
        'error_message' => json_last_error_msg(),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return;
}

        $emailBody = $result['email_body'] ?? '';

$emailBody = preg_replace(
    '/^Dear\s+[A-Za-z\s]+,\s*/i',
    '',
    $emailBody
);

$emailBody = trim($emailBody);

$questions = $result['questions'] ?? [];

foreach ($questions as &$question) {

    $question = preg_replace(
        '/^[0-9]+\.\s*/',
        '',
        $question
    );
}

unset($question);

Log::info('JSON Parsed Successfully');

// Save AI output
// Save AI output
DB::table('ai_email_logs')->insert([

    'enquiry_id'    => $enquiry->id,

    'research_data' => '',

    'email_subject' => $result['subject'] ?? '',

    'email_body'    => $emailBody,

    'faqs'          => json_encode($questions),

    'direction'     => 'outgoing',

    'from_email'    => config('mail.from.address'),

    'to_email'      => $enquiry->email,

    'email_date'    => now(),

    'status'        => 'generated',
    'agent_id' => $enquiry->assigned_to,

    'created_at'    => now(),
    'updated_at'    => now()
]);
Log::info('AI data saved');

        // Send email
 $agent = DB::table('users')
    ->where('id', $enquiry->assigned_to)
    ->first();

$mail = Mail::to($enquiry->email);

if ($agent && !empty($agent->email_id)) {
    $mail->cc($agent->email_id);
}

$mail->send(
    new ReportThankYouMail([
    'customer_name' => $enquiry->name,
    'subject' => $result['subject'] ?? '',
    'email_body' => $emailBody,
    'questions' => $questions
])
);
        Log::info('AI email sent successfully', [
            'email' => $enquiry->email
        ]);

        // Update status
        DB::table('ai_email_logs')
    ->where('enquiry_id', $enquiry->id)
    ->latest('id')
    ->update([
        'status' => 'sent',
        'direction' => 'outgoing',
        'from_email' => config('mail.from.address'),
        'to_email' => $enquiry->email,
        'email_date' => now()
    ]);

    } catch (\Throwable $e) {

        Log::error('ProcessEnquiryAI Error', [
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile()
        ]);
    }
}
}