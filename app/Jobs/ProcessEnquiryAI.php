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

A new inbound lead has submitted an enquiry for a market research report.

Lead Information:

Client Name: {$enquiry->name}

Client Designation: {$enquiry->job_title}

Client Company: {$enquiry->company_name}

Country / Region: {$enquiry->visitor_country}

Report They Inquired About:
{$enquiry->page_name}

Company Intelligence:
".json_encode($companyData)."

Your objective is to write a professional qualification email BEFORE sharing report samples, report extracts, pricing, or report details.

Instructions:

1. Thank the prospect for their enquiry regarding:
{$enquiry->page_name}

2. Show light awareness of their company, industry, role, or market if information is available.

3. Never invent facts.
If information is unavailable, simply skip it.

4. Ask EXACTLY 3 qualification questions.

Question 1:
Understand the prospect's primary use case for the research.

Examples:
- market sizing
- competitive benchmarking
- strategic planning
- investment evaluation
- market entry
- partnership assessment

Question 2:
Understand the geographic focus.

Examples:
- global
- regional
- country-specific

Question 3:
Understand the business initiative, decision, or opportunity this research will support.

5. Explain that their answers will help us direct them to the most relevant sections, data points, and insights within the report instead of sending a generic overview.

6. Keep the tone:
- professional
- warm
- consultative
- helpful

7. Do NOT:
- discuss pricing
- discuss discounts
- discuss urgency
- discuss competitors
- provide report samples
- provide report summaries
- provide FAQs

8. Email body must be less than 200 words.

9. Questions must be numbered:
1.
2.
3.

10. Subject format must be:

Your Inquiry — {$enquiry->page_name} | A Quick Question

Return ONLY valid JSON.

{
    \"subject\":\"\",
    \"email_body\":\"\",
    \"questions\":[
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

        Log::info('JSON Parsed Successfully');

        // Save AI output
        DB::table('ai_email_logs')->insert([

    'enquiry_id' => $enquiry->id,

    'research_data' => $result['report_summary'] ?? '',

    'email_subject' => $result['subject'] ?? '',

    'email_body' => $result['email_body'] ?? '',

   'faqs' => json_encode($result['questions'] ?? []),

    'status' => 'generated',

    'created_at' => now(),
    'updated_at' => now()
]);

Log::info('AI data saved');

        // Send email
        Mail::to($enquiry->email)->send(
    new ReportThankYouMail([
        'customer_name' => $enquiry->name,
        'subject' => $result['subject'] ?? '',
        'email_body' => $result['email_body'] ?? '',
        'questions' => $result['questions'] ?? []
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
                'status' => 'sent'
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