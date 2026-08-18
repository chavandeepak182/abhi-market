<?php

namespace App\Services;

use App\Models\Enquiry;
use App\Models\EmailMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * Sends the lead's "thank you" email the moment an agent is assigned to
 * them - whether that's the automatic region-based assignment done at
 * enquiry time (EnquiryController::store) or a manual/on-leave
 * reassignment done later (LeadController::reassignAgent).
 *
 * Unlike every other automatic email in the app, this one is deliberately
 * NOT an admin-editable "thank_you" Email message template anymore - its
 * copy lives in resources/views/emails/lead-thank-you.blade.php, and it
 * always pulls the FAQs straight from the assigned report row
 * (reports.faq_que / reports.faq_ans) instead of an admin-authored body.
 */
class LeadThankYouMailer
{
    /**
     * @param  Enquiry  $lead  Must already have its assigned agent saved on
     *                      user_id - nothing is sent if no agent is set,
     *                      since that's exactly the condition this email
     *                      fires on.
     */
    public static function send(Enquiry $lead): void
    {
        $agent = $lead->user;

        if (!$agent || !$agent->email) {
            return;
        }

        $report = null; // abhi-market's enquiries aren't linked to a specific report row

        $subject = 'Thank you for your interest in '.($report?->report_title ?? 'our report');

        $body = view('emails.lead-thank-you', [
            'lead' => $lead,
            'enquiry' => $lead,
            'agent' => $agent,
            'report' => $report,
            'faqs' => self::faqsFor($report),
        ])->render();

        // Resolve threading the same way every other email in the app
        // does (EmailThreadService), so this always lands in the lead's
        // one true thread instead of forking a new one - it correctly
        // falls back to a brand new thread/message id when this is the
        // very first message ever sent to the lead.
        $threadId = EmailThreadService::threadIdFor($lead);
        $conversationId = EmailThreadService::conversationIdFor($lead);
        $messageId = EmailThreadService::newMessageId();
        $lastEmail = EmailThreadService::lastMessageFor($lead);
        $references = EmailThreadService::referencesFor($threadId);

        $deliveryStatus = 'sent';
        $deliveryError = null;

        try {
            Mail::html($body, function ($mail) use ($lead, $agent, $subject, $messageId, $lastEmail, $references) {
                $mail->to($lead->email)->subject($subject);

                // This is an automatic email with no human sender in the
                // loop - CC the assigned agent so they always know it
                // went out, straight from the CRM's own mail identity
                // (mail.from.* / MAIL_FROM_ADDRESS), same as every other
                // automatic email in the app.
                $mail->cc($agent->email);

                EmailThreadService::attachHeaders(
                    $mail,
                    $messageId,
                    $lastEmail?->message_id,
                    $references
                );
            });
        } catch (\Throwable $e) {
            // Never let an SMTP failure bubble up into the assignment
            // flow (lead creation / reassignment) that triggered this -
            // the assignment itself must still succeed. Record the real
            // outcome instead of silently pretending it sent.
            Log::error('Lead thank-you email failed to send: '.$e->getMessage(), ['enquiry_id' => $lead->id]);
            $deliveryStatus = 'failed';
            $deliveryError = $e->getMessage();
        }

        EmailMessage::create([
            'enquiry_id' => $lead->id,
            'message_type' => 'sent',
            'delivery_status' => $deliveryStatus,
            'delivery_error' => $deliveryError,
            'subject' => $subject,
            'body' => $body,
            'from_email' => config('mail.from.address'),
            'to_email' => $lead->email,
            'cc_email' => $agent->email,
            'message_id' => $messageId,
            'thread_id' => $threadId,
            'conversation_id' => $conversationId,
        ]);
    }

    /**
     * reports.faq_que and reports.faq_ans are each a single long-text
     * field holding one question/answer per line - line N of faq_que is
     * paired with line N of faq_ans. Blank question lines are skipped;
     * a question with no matching answer line still renders (with an
     * empty answer) rather than being dropped.
     *
     * The two columns are longText and, in practice, may hold either
     * plain newline-separated text OR rich-text/HTML from a WYSIWYG
     * import (<p>, <br>, <li> tags instead of real newlines). Both are
     * normalized to one item per line before splitting, so either format
     * parses correctly instead of silently producing zero FAQs.
     *
     * @return array<int, array{question: string, answer: string}>
     */
    private static function faqsFor($report): array
    {
        if (!$report) {
            return [];
        }

        $questions = self::splitIntoLines($report->faq_que);
        $answers = self::splitIntoLines($report->faq_ans);

        $faqs = [];

        foreach ($questions as $i => $question) {
            if ($question === '') {
                continue;
            }

            $faqs[] = [
                'question' => $question,
                'answer' => $answers[$i] ?? '',
            ];
        }

        return $faqs;
    }

    /**
     * Turns a longText FAQ field into a flat list of trimmed, non-empty
     * lines - whether the source is plain text (one item per real
     * newline) or HTML (block/line-break tags standing in for newlines).
     */
    private static function splitIntoLines(?string $value): array
    {
        $value = (string) $value;

        // Treat common block/line-break HTML tags as line breaks before
        // stripping the rest of the markup, so "<p>Question one</p><p>Question
        // two</p>" (or <br>, <li>, <div> variants) still yields one line per
        // question/answer instead of collapsing into a single blob.
        $value = preg_replace('/<\s*(br|\/p|\/li|\/div|\/h[1-6])\s*\/?\s*>/i', "\n", $value);
        $value = strip_tags($value);
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5);

        $lines = preg_split('/\r\n|\r|\n/', $value, -1, PREG_SPLIT_NO_EMPTY);

        return array_values(array_filter(array_map('trim', $lines), fn ($line) => $line !== ''));
    }
}