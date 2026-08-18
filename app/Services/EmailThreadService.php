<?php

namespace App\Services;

use App\Models\EmailMessage;
use App\Models\Enquiry;
use Illuminate\Support\Str;

/**
 * Single source of truth for email threading on a lead (enquiry).
 *
 * Every place that sends or records an email for a lead (thank-you email,
 * manual agent reply, automatic follow-up, or an inbound reply synced over
 * IMAP) must resolve thread_id / Message-ID / In-Reply-To / References /
 * CC through this service, so a lead never ends up split across more than
 * one thread_id and outgoing mail always carries real threading headers
 * (not just DB columns) so Gmail/Outlook thread it correctly.
 */
class EmailThreadService
{
    /**
     * The lead's one true thread_id.
     *
     * Deliberately taken from the OLDEST EmailMessage row for this lead,
     * never the "latest" one - anchoring to the first message ever
     * recorded means every other code path always converges back to the
     * same value, regardless of what happened in between.
     */
    public static function threadIdFor(Enquiry $lead): string
    {
        $oldest = EmailMessage::where('enquiry_id', $lead->id)
            ->whereNotNull('thread_id')
            ->oldest()
            ->value('thread_id');

        return $oldest ?: (string) Str::uuid();
    }

    public static function conversationIdFor(Enquiry $lead): string
    {
        $oldest = EmailMessage::where('enquiry_id', $lead->id)
            ->whereNotNull('conversation_id')
            ->oldest()
            ->value('conversation_id');

        return $oldest ?: 'conv_'.Str::uuid();
    }

    /**
     * The most recent message in the lead's thread (used for In-Reply-To
     * and as a fallback anchor when nothing else is available yet).
     */
    public static function lastMessageFor(Enquiry $lead): ?EmailMessage
    {
        return EmailMessage::where('enquiry_id', $lead->id)->latest()->first();
    }

    public static function newMessageId(): string
    {
        return '<'.Str::uuid().'@'.parse_url(config('app.url'), PHP_URL_HOST).'>';
    }

    /**
     * Every message_id sent or received so far in this thread, oldest
     * first, space-separated - this is what the References header expects.
     * Built fresh from the DB every time rather than trusting any single
     * row's stored value, so it can never fall out of sync.
     */
    public static function referencesFor(string $threadId): string
    {
        return implode(' ', EmailMessage::where('thread_id', $threadId)
            ->whereNotNull('message_id')
            ->oldest()
            ->pluck('message_id')
            ->toArray());
    }

    /**
     * Every CC address that has ever appeared anywhere in this thread,
     * deduplicated. Any new reply should carry this forward so nobody
     * who was ever looped in silently drops off.
     */
    public static function existingCcFor(string $threadId): array
    {
        $emails = [];

        foreach (
            EmailMessage::where('thread_id', $threadId)
                ->whereNotNull('cc_email')
                ->pluck('cc_email')
                ->toArray() as $ccList
        ) {
            foreach (explode(',', $ccList) as $email) {
                $email = trim($email);
                if ($email !== '') {
                    $emails[] = $email;
                }
            }
        }

        return array_values(array_unique($emails));
    }

    /**
     * Attaches the real Message-ID / In-Reply-To / References headers to
     * an outgoing Symfony/Laravel mail message, so recipients' mail
     * clients have something to actually thread against (not just values
     * stored in the DB).
     */
    public static function attachHeaders($mail, string $messageId, ?string $inReplyTo, string $references): void
    {
        // Message-ID must be set via addIdHeader() - Symfony treats it as an
        // IdentificationHeader; addTextHeader() throws for this header name.
        $mail->getHeaders()->addIdHeader('Message-ID', trim($messageId, '<>'));

        if ($inReplyTo) {
            $mail->getHeaders()->addTextHeader('In-Reply-To', $inReplyTo);
        }

        if ($references) {
            $mail->getHeaders()->addTextHeader('References', $references);
        }
    }
}
