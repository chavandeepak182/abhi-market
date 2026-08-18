<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\LeadActivity;
use App\Models\Note;
use App\Models\Meeting;
use App\Models\EmailMessage;
use App\Models\EmailTemplate;
use App\Models\FollowupHistory;
use App\Services\EmailThreadService;
use App\Services\LeadTemplateRenderer;
use App\Services\FollowupScheduler;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\Models\Enquiry;

/**
 * Powers the agent-facing "Lead Details" page (route: agent.lead.details) —
 * the page an agent lands on when they click a lead's name from All
 * Enquiries, mirroring the read-only admin "Lead Profile" page
 * (EnquiryController::profile) but with the agent's own action forms
 * (note, status, email, meeting) wired to the enquiry_activities /
 * notes / enquiry_meetings / ai_email_logs tables and Models already set
 * up in this project.
 *
 * Every write here also drops a row in enquiry_activities so the unified
 * "Notes & Activity" timeline on the page reflects it, regardless of
 * which card (Notes, Status, Email, Meetings) it came from.
 */
class AgentLeadController extends Controller
{
    /**
     * Query for an enquiry the current user is allowed to open — same
     * visibility rule EnquiryController::enquiryLead() uses for the All
     * Enquiries list, so a lead reachable from that list is reachable
     * here too.
     */
    private function authorizedEnquiryQuery($id)
    {
        $userId = session('user_id');
        $roleId = session('role_id');

        $query = DB::table('enquiries')->whereNull('deleted_at')->where('id', $id);

        if ($roleId == config('constants.roles.agent')) {
            if (session('can_assign_leads') == 1) {
                $query->where(function ($q) use ($userId) {
                    $q->where('assigned_to', $userId)
                        ->orWhere('assigned_by', $userId);
                });
            } else {
                $query->where('assigned_to', $userId);
            }
        }

        return $query;
    }

    private function logActivity($enquiryId, $type, $description)
    {
        LeadActivity::create([
            'enquiry_id' => $enquiryId,
            'user_id' => session('user_id'),
            'activity_type' => $type,
            'description' => $description,
        ]);
    }

    public function show($id)
    {
        if (! $this->authorizedEnquiryQuery($id)->exists()) {
            abort(403, 'You are not assigned to this lead.');
        }

        // Eloquent (not DB::table) so the CRM-style view can read
        // $enquiry->reportCategory, ->report, ->user etc. as relations,
        // same as CRM's $lead.
        $enquiry = Enquiry::with(['reportCategory', 'report', 'user', 'assignedAgent'])
            ->findOrFail($id);

        // Kept for the same country/agent display the old profile view
        // used - Enquiry has no country()/agent() relation defined, so
        // these are looked up and hung on the model for the view only.
        if ($enquiry->country_id) {
            $enquiry->country_name = DB::table('countries')->where('id', $enquiry->country_id)->value('name');
        }
        $enquiry->agent_name = $enquiry->assignedAgent?->name;

        $activities = LeadActivity::with('user')
            ->where('enquiry_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $emails = DB::table('ai_email_logs')
            ->where('enquiry_id', $id)
            ->orderBy('id', 'asc')
            ->get();

        // New CC/reply-to/threaded email system (email_messages) -
        // separate from the legacy AI-generated 'ai_email_logs' table
        // above, same split CRM has. This is what the CRM-style "Email
        // history" card on the page reads from.
        $emailThread = EmailMessage::with('attachments')
            ->where('enquiry_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $emailTemplate = EmailTemplate::sendable()->first();
        // The email composer loops over $templates the same way CRM's
        // does - this project only supports a single sendable (Sample
        // Report / "global") template at a time, so it's just that one
        // template wrapped in a collection.
        $templates = $emailTemplate ? collect([$emailTemplate]) : collect();

        $meetings = Meeting::where('enquiry_id', $id)
            ->orderBy('scheduled_at', 'desc')
            ->get();

        // Feeds the "Description" (add follow-up) / "Follow up history"
        // cards - same table/model CRM's followupHistories() relation
        // reads from.
        $followupHistories = FollowupHistory::with('user')
            ->where('enquiry_id', $id)
            ->orderBy('completed_at', 'asc')
            ->get();

        $followups = DB::table('enquiry_followups')
            ->where('enquiry_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('agent.lead-details', compact(
            'enquiry',
            'activities',
            'emails',
            'emailThread',
            'emailTemplate',
            'templates',
            'meetings',
            'followupHistories',
            'followups'
        ));
    }

    public function storeNote(Request $request, $id)
    {
        if (! $this->authorizedEnquiryQuery($id)->exists()) {
            abort(403);
        }

        $request->validate(['note' => 'required|string']);

        Note::create([
            'enquiry_id' => $id,
            'created_by' => session('user_id'),
            'note' => $request->note,
        ]);

        $this->logActivity($id, 'note', $request->note);

        return back()->with('success', 'Note added.');
    }

    public function updateStatus(Request $request, $id)
    {
        if (! $this->authorizedEnquiryQuery($id)->exists()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:new,contacted,converted,not_interested',
        ]);

        $this->authorizedEnquiryQuery($id)->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        $this->logActivity($id, 'status', 'Status changed to '.ucfirst(str_replace('_', ' ', $request->status)));

        return back()->with('success', 'Status updated.');
    }

    /**
     * Compose-and-send an email on this enquiry - agent side.
     *
     * Ported 1:1 from global-crm's Agent\DashboardController::sendEmail:
     * same thread resolution, same CC merge, same headers - but sends
     * AS the agent (their own Gmail SMTP creds, stored on
     * users.mail_password), and CCs the CRM's central address instead
     * of the agent (since the agent is now the From address, not the
     * CC). Reply-To includes both the agent and the CRM inbox so a
     * lead hitting plain "Reply" reaches whichever address they'd
     * expect. Falls back to central SMTP if the agent has no Gmail
     * app password configured yet.
     */
    public function sendEmail(Request $request, $id)
    {
        if (! $this->authorizedEnquiryQuery($id)->exists()) {
            abort(403);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required',
            'template_id' => 'nullable|exists:email_templates,id',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|max:10240',
        ]);

        $totalAttachmentBytes = collect($request->file('attachments', []))->sum->getSize();
        if ($totalAttachmentBytes > 10 * 1024 * 1024) {
            return back()->withErrors(['attachments' => 'Attachments must total 10MB or less.']);
        }

        $lead = Enquiry::findOrFail($id);

        $uploadedAttachments = [];
        foreach ($request->file('attachments', []) as $file) {
            $uploadedAttachments[] = [
                'path' => $file->store('email-attachments', 'public'),
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ];
        }

        $lastEmail = EmailThreadService::lastMessageFor($lead);
        $messageId = EmailThreadService::newMessageId();
        $threadId = EmailThreadService::threadIdFor($lead);
        $conversationId = EmailThreadService::conversationIdFor($lead);

        $existingCc = EmailThreadService::existingCcFor($threadId);

        $newCc = !empty($request->cc_email)
            ? array_map('trim', explode(',', $request->cc_email))
            : [];

        // The agent is the sender now, so the CRM's own address no
        // longer appears in the From header - CC it here instead so
        // the central inbox still sees every email agents send.
        $agentId = session('user_id');
        $agentRow = DB::table('users')->where('id', $agentId)->first();
        $agentEmail = $agentRow->email_id ?? session('email');
        $agentName = $agentRow->name ?? session('username');
        $crmAddress = env('MAIL_FROM_ADDRESS');

        $finalCcArray = array_unique(array_filter(
            array_merge($existingCc, $newCc, $crmAddress ? [$crmAddress] : []),
            // The agent is the sender - they must never also show up
            // in CC, however they got into $existingCc/$newCc.
            function ($email) use ($agentEmail) {
                return !$agentEmail || strcasecmp(trim($email), trim($agentEmail)) !== 0;
            }
        ));

        $finalCc = implode(',', $finalCcArray);

        $toEmails = [$lead->email];

        if (!empty($request->reply_to_email) && $request->reply_to_email != $lead->email) {
            $toEmails[] = $request->reply_to_email;
        }

        $toEmails = array_unique($toEmails);

        $usedTemplate = $request->template_id ? EmailTemplate::find($request->template_id) : null;

        $renderedSubject = LeadTemplateRenderer::render($request->subject, $lead);
        $renderedBody = LeadTemplateRenderer::render($request->body, $lead);

        $references = EmailThreadService::referencesFor($threadId);

        $deliveryStatus = 'sent';
        $deliveryError = null;

        // mail_password is stored encrypted (Crypt::encryptString, see
        // AgentController::store) - decrypt it here, falling back to
        // central SMTP if it's missing/unreadable rather than failing
        // the whole send.
        $agentMailPassword = null;
        if ($agentRow && !empty($agentRow->mail_password)) {
            try {
                $agentMailPassword = Crypt::decryptString($agentRow->mail_password);
            } catch (\Throwable $e) {
                Log::warning('Could not decrypt agent mail_password, falling back to central SMTP', ['agent_id' => $agentId]);
            }
        }

        try {
            if ($agentMailPassword) {

                // Agent has their own Gmail app password on file - send
                // as them, exactly like CRM's agent branch.
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => 'smtp.gmail.com',
                    'mail.mailers.smtp.port' => 587,
                    'mail.mailers.smtp.encryption' => 'tls',
                    'mail.mailers.smtp.username' => $agentEmail,
                    'mail.mailers.smtp.password' => $agentMailPassword,
                    'mail.from.address' => $agentEmail,
                    'mail.from.name' => $agentName,
                ]);

            } else {

                // No Gmail app password configured for this agent yet -
                // fall back to the central SMTP account rather than
                // failing outright, still CC'ing the agent so they see
                // it went out.
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => env('MAIL_HOST'),
                    'mail.mailers.smtp.port' => env('MAIL_PORT'),
                    'mail.mailers.smtp.encryption' => env('MAIL_ENCRYPTION', 'tls'),
                    'mail.mailers.smtp.username' => env('MAIL_USERNAME'),
                    'mail.mailers.smtp.password' => env('MAIL_PASSWORD'),
                    'mail.from.address' => env('MAIL_FROM_ADDRESS'),
                    'mail.from.name' => env('MAIL_FROM_NAME'),
                ]);

                if ($agentEmail && !in_array($agentEmail, $finalCcArray)) {
                    $finalCcArray[] = $agentEmail;
                }
            }

            app()->forgetInstance('mailer');
            app()->forgetInstance('mail.manager');
            \Mail::purge('smtp');

            Mail::html($renderedBody, function ($message) use (
                $renderedSubject, $toEmails, $finalCcArray, $request,
                $messageId, $lastEmail, $references, $agentEmail,
                $crmAddress, $uploadedAttachments
            ) {
                $message->to($toEmails)->subject($renderedSubject);

                // Reply-To includes both the agent and the CRM inbox,
                // so a lead hitting plain "Reply" reaches either.
                $replyTo = array_values(array_unique(array_filter([$agentEmail, $crmAddress])));
                if (!empty($replyTo)) {
                    $message->replyTo($replyTo);
                }

                if (!empty($finalCcArray)) {
                    $message->cc($finalCcArray);
                }

                if (!empty($request->bcc_email)) {
                    $message->bcc(array_map('trim', explode(',', $request->bcc_email)));
                }

                EmailThreadService::attachHeaders($message, $messageId, $lastEmail?->message_id, $references);

                foreach ($uploadedAttachments as $att) {
                    $message->attach(storage_path('app/public/'.$att['path']), [
                        'as' => $att['name'],
                    ]);
                }
            });

        } catch (\Throwable $e) {
            Log::error('Agent enquiry email failed to send: '.$e->getMessage(), ['enquiry_id' => $id]);
            $deliveryStatus = 'failed';
            $deliveryError = $e->getMessage();
        }

        $finalCc = implode(',', $finalCcArray);

        $emailMessage = EmailMessage::create([
            'enquiry_id' => $lead->id,
            'message_type' => 'sent',
            'delivery_status' => $deliveryStatus,
            'delivery_error' => $deliveryError,
            'subject' => $renderedSubject,
            'body' => $renderedBody,
            'from_email' => $agentMailPassword ? $agentEmail : env('MAIL_FROM_ADDRESS'),
            'to_email' => $lead->email,
            'cc_email' => $finalCc,
            'bcc_email' => $request->bcc_email,
            'message_id' => $messageId,
            'thread_id' => $threadId,
            'conversation_id' => $conversationId,
            'in_reply_to' => $lastEmail->message_id ?? null,
        ]);

        foreach ($uploadedAttachments as $att) {
            $emailMessage->attachments()->create([
                'file_name' => $att['name'],
                'file_path' => $att['path'],
                'file_size' => $att['size'],
            ]);
        }

        $this->logActivity(
            $id,
            'email',
            $deliveryStatus === 'sent' ? 'Sent email: '.$renderedSubject : 'Failed to send email: '.$renderedSubject
        );

        // Sending the Global (Sample Report) template moves a new lead
        // to Contacted and kicks off the follow-up countdown - mirrors
        // the admin branch exactly.
        if ($request->template_id && $usedTemplate?->type === 'global') {

            if ($lead->status === 'new') {
                $lead->update(['status' => 'contacted']);

                $this->logActivity(
                    $id,
                    'status',
                    'Status changed to contacted (Global template "'.$usedTemplate->name.'" sent)'
                );
            }

            if ($lead->scheduledFollowups()->doesntExist()) {
                FollowupScheduler::scheduleForLead($lead);

                $this->logActivity(
                    $id,
                    'followup_scheduled',
                    'Follow-up countdown started after Global template "'.$usedTemplate->name.'" was sent'
                );
            }
        }

        return back()->with(
            $deliveryStatus === 'sent' ? 'success' : 'error',
            $deliveryStatus === 'sent' ? 'Email sent successfully.' : 'Could not send email - saved to history anyway.'
        );
    }

    /**
     * Any other *scheduled* meeting for this agent that overlaps the
     * given [start, end) window. Ported 1:1 from CRM's
     * Agent\DashboardController::meetingConflict().
     */
    private function meetingConflict($userId, Carbon $start, Carbon $end, $ignoreId = null)
    {
        return Meeting::where('user_id', $userId)
            ->where('status', 'scheduled')
            ->when($ignoreId, function ($q) use ($ignoreId) {
                $q->where('id', '!=', $ignoreId);
            })
            ->whereRaw('scheduled_at < ?', [$end])
            ->whereRaw('DATE_ADD(scheduled_at, INTERVAL duration_minutes MINUTE) > ?', [$start])
            ->first();
    }

    /**
     * AJAX pre-check the "Schedule meeting" modal can call before the
     * agent hits Schedule - same as CRM's checkMeeting().
     */
    public function checkMeeting(Request $request, $id)
    {
        if (! $this->authorizedEnquiryQuery($id)->exists()) {
            abort(403);
        }

        $request->validate([
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:5|max:600',
        ]);

        $duration = (int) ($request->duration_minutes ?: 30);
        $start = Carbon::parse($request->scheduled_at);
        $end = (clone $start)->addMinutes($duration);

        $conflict = $this->meetingConflict(session('user_id'), $start, $end);

        return response()->json([
            'conflict' => (bool) $conflict,
            'meeting' => $conflict ? [
                'title' => $conflict->title,
                'time' => $conflict->scheduled_at->format('d M Y h:i A'),
            ] : null,
        ]);
    }

    /**
     * Store a new meeting for this lead. Same as CRM's storeMeeting():
     * JSON response, rejects with 409 on a scheduling conflict for the
     * same agent, and drops a LeadActivity row either way.
     */
    public function storeMeeting(Request $request, $id)
    {
        if (! $this->authorizedEnquiryQuery($id)->exists()) {
            abort(403);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'nullable|integer|min:5|max:600',
            'meeting_with' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $enquiry = $this->authorizedEnquiryQuery($id)->first();

        $duration = (int) ($request->duration_minutes ?: 30);
        $start = Carbon::parse($request->scheduled_at);
        $end = (clone $start)->addMinutes($duration);

        $conflict = $this->meetingConflict(session('user_id'), $start, $end);

        if ($conflict) {
            return response()->json([
                'status' => 'conflict',
                'message' => 'You already have a meeting scheduled at this time.',
                'conflict' => [
                    'title' => $conflict->title,
                    'time' => $conflict->scheduled_at->format('d M Y h:i A'),
                ],
            ], 409);
        }

        $meeting = Meeting::create([
            'enquiry_id' => $id,
            'user_id' => session('user_id'),
            'title' => $request->title ?: 'Meeting with lead',
            'meeting_with' => $request->meeting_with ?: $enquiry->name,
            'scheduled_at' => $start,
            'duration_minutes' => $duration,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        $this->logActivity(
            $id,
            'meeting',
            'Meeting scheduled: '.$meeting->title.' at '.$start->format('d M Y h:i A')
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Meeting scheduled successfully.',
            'meeting' => [
                'id' => $meeting->id,
                'title' => $meeting->title,
                'scheduled_at' => $meeting->scheduled_at->toIso8601String(),
                'time' => $meeting->scheduled_at->format('d M Y h:i A'),
            ],
        ]);
    }

    /**
     * Reschedule an existing meeting - same as CRM's updateMeeting().
     */
    public function updateMeeting(Request $request, $id)
    {
        $meeting = Meeting::where('user_id', session('user_id'))->findOrFail($id);

        $data = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|in:15,30,45,60,90',
        ]);

        $start = Carbon::parse($data['scheduled_at']);
        $duration = (int) $data['duration_minutes'];
        $end = $start->copy()->addMinutes($duration);

        if ($conflict = $this->meetingConflict(session('user_id'), $start, $end, $meeting->id)) {
            return back()->withErrors([
                'meeting' => 'You already have '.$conflict->title.' at '.$conflict->scheduled_at->format('d M h:i A').'.',
            ]);
        }

        $meeting->update([
            'scheduled_at' => $data['scheduled_at'],
            'duration_minutes' => $duration,
            'notified' => false,
        ]);

        $this->logActivity(
            $meeting->enquiry_id,
            'meeting',
            'Meeting rescheduled to '.$start->format('d M Y, h:i A')
        );

        return back()->with('success', 'Meeting rescheduled.');
    }

    /**
     * Cancel/delete a meeting - same as CRM's deleteMeeting().
     */
    public function deleteMeeting($id)
    {
        $meeting = Meeting::where('user_id', session('user_id'))->findOrFail($id);
        $meeting->delete();

        return back()->with('success', 'Meeting deleted.');
    }

    /**
     * Feeds the browser notifier (subviews.meeting-reminders): this
     * agent's scheduled meetings in the next 24 hours.
     */
   public function upcomingMeetings()
{
    $userId = session('user_id');

    $now = now();

    $meetings = DB::table('lead_meetings')
        ->join('enquiries', 'lead_meetings.enquiry_id', '=', 'enquiries.id')
        ->where('lead_meetings.user_id', $userId)
        ->where('lead_meetings.conducted', 0)
        ->whereBetween(
            'lead_meetings.meeting_at',
            [$now, $now->copy()->addHours(24)]
        )
        ->orderBy('lead_meetings.meeting_at')
        ->select(
            'lead_meetings.id',
            'lead_meetings.meeting_at',
            'lead_meetings.agenda',
            'enquiries.id as enquiry_id',
            'enquiries.name',
            'enquiries.email'
        )
        ->get()
        ->map(function ($meeting) use ($now) {

            $meetingTime = Carbon::parse($meeting->meeting_at);

            $minutesUntil = $now->diffInMinutes($meetingTime, false);

            if ($minutesUntil <= 5) {
                $reminder = 'starting_soon';
            } elseif ($minutesUntil <= 15) {
                $reminder = '15_minutes';
            } elseif ($minutesUntil <= 30) {
                $reminder = '30_minutes';
            } else {
                $reminder = 'upcoming';
            }

            return [
                'id'            => $meeting->id,
                'enquiry_id'    => $meeting->enquiry_id,
                'name'          => $meeting->name,
                'email'         => $meeting->email,
                'agenda'        => $meeting->agenda,
                'meeting_at'    => $meeting->meeting_at,
                'minutes_until' => $minutesUntil,
                'reminder'      => $reminder,
            ];
        });

    return response()->json($meetings);
}

    /**
     * Log a phone call against this lead - same as CRM's storeCall().
     * No dedicated Call table on either side; it's just recorded as a
     * LeadActivity row.
     */
    public function storeCall(Request $request, $id)
    {
        if (! $this->authorizedEnquiryQuery($id)->exists()) {
            abort(403);
        }

        $request->validate([
            'call_outcome' => 'required|string|max:255',
            'call_notes' => 'nullable|string',
        ]);

        $this->logActivity(
            $id,
            'call',
            'Call logged ('.$request->call_outcome.')'.($request->call_notes ? ': '.$request->call_notes : '')
        );

        return back()->with('success', 'Call logged successfully.');
    }

    /**
     * Add a follow-up history entry (the "Description" card on the page)
     * - same as CRM's storeFollowupHistory().
     */
    public function storeFollowupHistory(Request $request, $id)
    {
        if (! $this->authorizedEnquiryQuery($id)->exists()) {
            abort(403);
        }

        $request->validate([
            'header' => 'required|string|max:255',
            'remarks' => 'required|string|max:5000',
        ]);

        $next = FollowupHistory::where('enquiry_id', $id)->count() + 1;

        FollowupHistory::create([
            'enquiry_id' => $id,
            'user_id' => session('user_id'),
            'followup_no' => $next,
            'header' => $request->header,
            'remarks' => $request->remarks,
            'completed_at' => now(),
        ]);

        $this->logActivity($id, 'followup', 'Follow-up note added: '.$request->header);

        return back()->with('success', 'Follow-up history added.');
    }
}
