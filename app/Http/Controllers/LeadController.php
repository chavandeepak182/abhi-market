<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\EmailTemplate;
use App\Models\EnquiryActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/**
 * Admin-side CRM lead detail page (resources/views/admin/leads/show.blade.php)
 * - the "same to same as global-crm" page opened when an admin clicks a
 * lead's name from All Enquiries (or anywhere else). Mirrors
 * global-crm's LeadController::view / reassignAgent / updateCRM /
 * sendEmail, adapted to abhi-market's Enquiry model.
 */
class LeadController extends Controller
{
    public function show(Enquiry $lead)
    {
        if ($lead->has_unread_reply) {
            $lead->update(['has_unread_reply' => false]);
        }

        $lead->load([
            'user',
            'activities',
            'emails' => function ($query) {
                $query->orderBy('thread_id')->orderBy('created_at');
            },
            'followupHistories.user',
        ]);

        $agents = DB::table('users')
            ->where('role_id', config('constants.roles.agent'))
            ->whereNull('deleted_at')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $templates = EmailTemplate::orderBy('name')->get();

        return view('admin.leads.show', compact('lead', 'agents', 'templates'));
    }

    public function reassignAgent(Request $request, Enquiry $lead)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $previousAgentId = $lead->assigned_to;

        $lead->update([
            'assigned_to' => $request->user_id,
            'assigned_by' => session('user_id'),
        ]);

        if ($previousAgentId != $request->user_id) {
            $agentName = DB::table('users')->where('id', $request->user_id)->value('name');

            EnquiryActivity::create([
                'enquiry_id'    => $lead->id,
                'user_id'       => session('user_id'),
                'activity_type' => 'reassign',
                'description'   => 'Lead reassigned to '.($agentName ?? 'agent #'.$request->user_id).'.',
            ]);
        }

        return back()->with('success', 'Agent reassigned successfully.');
    }

    public function updateCrm(Request $request, Enquiry $lead)
    {
        $request->validate([
            'name'               => 'nullable|string|max:255',
            'email'              => 'nullable|email|max:255',
            'phone'              => 'nullable|string|max:50',
            'company'            => 'nullable|string|max:255',
            'designation'        => 'nullable|string|max:255',
            'usage_type'         => 'nullable|string|max:255',
            'timezone'           => 'nullable|string|max:100',
            'status'             => 'nullable|string|max:50',
            'lead_type'          => 'nullable|string|max:50',
            'next_followup_date' => 'nullable|date',
        ]);

        $statusChanged = $request->filled('status') && $request->status !== $lead->status;

        $lead->update([
            'name'          => $request->name ?? $lead->name,
            'email'         => $request->email ?? $lead->email,
            'contact'       => $request->phone ?? $lead->contact,
            'company_name'  => $request->company ?? $lead->company_name,
            'job_title'     => $request->designation ?? $lead->job_title,
            'usage_type'    => $request->usage_type ?? $lead->usage_type,
            'timezone'      => $request->timezone ?? $lead->timezone,
            'status'        => $request->status ?? $lead->status,
            'lead_type'     => $request->lead_type ?? $lead->lead_type,
            'followup_date' => $request->next_followup_date ?? $lead->followup_date,
        ]);

        EnquiryActivity::create([
            'enquiry_id'    => $lead->id,
            'user_id'       => session('user_id'),
            'activity_type' => 'status',
            'description'   => $statusChanged
                ? 'Status changed to '.ucfirst(str_replace('_', ' ', $request->status)).'. Lead details updated.'
                : 'Lead details updated.',
        ]);

        return back()->with('success', 'Lead updated successfully.');
    }

    public function sendEmail(Request $request, Enquiry $lead)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
            'cc_email' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $attachmentPath = null;
        $attachmentName = null;

        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments')[0] ?? null;

            if ($file) {
                $attachmentPath = $file->store('email-attachments', 'public');
                $attachmentName = $file->getClientOriginalName();
            }
        }

        $toEmail = $request->reply_to_email ?: $lead->email;

        try {
            Mail::send([], [], function ($message) use ($request, $toEmail, $lead, $attachmentPath) {
                $message->to($toEmail)
                    ->subject($request->subject)
                    ->html($request->body);

                if ($request->filled('cc_email')) {
                    $message->cc(array_map('trim', explode(',', $request->cc_email)));
                }

                if ($attachmentPath) {
                    $message->attach(Storage::disk('public')->path($attachmentPath));
                }
            });

            $deliveryStatus = 'sent';
            $deliveryError = null;
        } catch (\Throwable $e) {
            $deliveryStatus = 'failed';
            $deliveryError = $e->getMessage();
        }

        DB::table('ai_email_logs')->insert([
            'enquiry_id'       => $lead->id,
            'agent_id'         => session('user_id'),
            'source'           => 'manual',
            'message_type'     => 'sent',
            'delivery_status'  => $deliveryStatus,
            'delivery_error'   => $deliveryError,
            'email_subject'    => $request->subject,
            'email_body'       => $request->body,
            'subject'          => $request->subject,
            'body'             => $request->body,
            'from_email'       => config('mail.from.address'),
            'to_email'         => $toEmail,
            'cc_email'         => $request->cc_email,
            'attachment_path'  => $attachmentPath,
            'attachment_name'  => $attachmentName,
            'status'           => $deliveryStatus === 'sent' ? 'sent' : 'failed',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        EnquiryActivity::create([
            'enquiry_id'    => $lead->id,
            'user_id'       => session('user_id'),
            'activity_type' => 'email',
            'description'   => $deliveryStatus === 'sent'
                ? 'Email sent: '.$request->subject
                : 'Email failed to send: '.$request->subject,
        ]);

        if ($deliveryStatus === 'failed') {
            return back()->with('error', 'Email could not be sent: '.$deliveryError);
        }

        return back()->with('success', 'Email sent successfully.');
    }
}
