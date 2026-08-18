@extends('admin.layouts.header')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/css/intlTelInput.css">
<style>

:root{
    --primary:#2563eb;
    --primary-light:#dbeafe;
    --success:#10b981;
    --danger:#ef4444;
    --warning:#f59e0b;
    --border:#e5e7eb;
    --bg:#f8fafc;
    --card:#ffffff;
    --text:#1f2937;
    --muted:#6b7280;
}

body{
    background:var(--bg);
}

.crm-container{
    padding:30px;
}

.page-header{
    background:#fff;
    border-radius:16px;
    padding:25px 30px;
    margin-bottom:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.page-title{
    font-size:28px;
    font-weight:700;
    color:var(--text);
    margin:0;
}

.page-subtitle{
    margin-top:5px;
    color:var(--muted);
}

.header-right{
    text-align:right;
}

.summary-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.summary-card{
    background:#fff;
    border-radius:16px;
    padding:20px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.summary-card h6{
    color:var(--muted);
    margin-bottom:10px;
    font-size:13px;
    text-transform:uppercase;
}

.summary-card h3{
    margin:0;
    color:var(--text);
}

.top-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
    margin-bottom:25px;
}

.card{
    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.card h3{
    margin-bottom:20px;
    font-size:20px;
    color:var(--text);
}

.info-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 0;
    border-bottom:1px solid #f1f5f9;
}

.info-row:last-child{
    border-bottom:none;
}

.info-row span{
    color:var(--muted);
}

.info-row strong{
    color:var(--text);
}

.section-card{
    background:#fff;
    border-radius:16px;
    padding:30px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.section-card h3{
    margin-bottom:25px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
    color:#374151;
}

.form-control{
    width:100%;
    height:46px;
    border:1px solid var(--border);
    border-radius:10px;
    padding:0 15px;
    font-size:14px;
    transition:.3s;
}

.form-control:focus{
    outline:none;
    border-color:var(--primary);
    box-shadow:0 0 0 3px rgba(37,99,235,.15);
}

.btn-primary{
    margin-top:15px;
    background:var(--primary);
    border:none;
    color:#fff;
    padding:12px 28px;
    border-radius:10px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn-primary:hover{
    background:#1d4ed8;
}

.badge{
    padding:6px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

.status-new{
    background:#e5e7eb;
    color:#374151;
}

.status-contacted{
    background:#dbeafe;
    color:#1d4ed8;
}

.status-engaged{
    background:#dcfce7;
    color:#166534;
}

.status-converted{
    background:#ecfccb;
    color:#365314;
}

.status-not_interested{
    background:#fee2e2;
    color:#991b1b;
}

.type-hot{
    background:#fee2e2;
    color:#dc2626;
}

.type-warm{
    background:#fef3c7;
    color:#b45309;
}

.type-cold{
    background:#dbeafe;
    color:#2563eb;
}

@media(max-width:992px){

    .summary-grid{
        grid-template-columns:1fr 1fr;
    }

    .top-grid{
        grid-template-columns:1fr;
    }

    .form-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:576px){

    .summary-grid{
        grid-template-columns:1fr;
    }

    .page-header{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .crm-container{
        padding:15px;
    }
}
.icon-action-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:var(--primary-light);
    color:var(--primary);
    border:1px solid #bfdbfe;
    padding:9px 16px;
    border-radius:10px;
    font-weight:600;
    font-size:14px;
    cursor:pointer;
    margin-right:12px;
}

.icon-action-btn:hover{
    background:#c7ddfc;
}

.icon-action-btn svg{
    width:18px;
    height:18px;
}

.editable-card-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:12px;
    margin-bottom:20px;
}

.editable-card-head h3{
    margin:0;
}

.assigned-agent-pill{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:#f0f7ff;
    color:var(--text);
    border:1px solid #dbeafe;
    padding:8px 16px;
    border-radius:30px;
    font-size:13px;
}

.assigned-agent-pill svg{
    width:16px;
    height:16px;
    color:var(--primary);
}

.assigned-agent-pill strong{
    color:var(--primary);
}

/* Email history threads */

.email-thread-card{
    border:1px solid #e5e7eb;
    border-radius:12px;
    margin-bottom:18px;
    overflow:hidden;
    background:#fff;
}

.email-thread-head{
    display:flex;
    justify-content:space-between;
    gap:15px;
    padding:15px 18px;
    background:#f8fafc;
    color:#1f2937;
}

.email-thread-head span{
    color:#64748b;
    font-size:13px;
}

.email-thread-item{
    border-top:1px solid #eef2f7;
}

.email-thread-item summary{
    display:flex;
    justify-content:space-between;
    gap:14px;
    padding:14px 18px;
    cursor:pointer;
    list-style:none;
    font-size:14px;
}

.email-thread-item summary::-webkit-details-marker{
    display:none;
}

.email-meta{
    display:flex;
    align-items:center;
    gap:8px;
    color:#64748b;
    font-size:13px;
    white-space:nowrap;
}

.email-thread-body{
    padding:4px 18px 18px;
    line-height:1.6;
    color:#334155;
}

.email-cc-line{
    color:#64748b;
    font-size:13px;
    margin-top:10px;
}

/* Email history - scrollable box, most recent thread on top (same pattern as Activity Timeline) */

.email-history-scroll-box{
    max-height:600px;
    overflow-y:auto;
    padding-right:6px;
}

.email-history-scroll-box::-webkit-scrollbar{
    width:6px;
}

.email-history-scroll-box::-webkit-scrollbar-thumb{
    background:#cbd5e1;
    border-radius:10px;
}

/* Activity timeline - scrollable card, latest on top */

.activity-scroll-box{
    max-height:480px;
    overflow-y:auto;
    padding-right:6px;
    display:flex;
    flex-direction:column;
    gap:14px;
}

.activity-scroll-box::-webkit-scrollbar{
    width:6px;
}

.activity-scroll-box::-webkit-scrollbar-thumb{
    background:#cbd5e1;
    border-radius:10px;
}

.activity-card{
    border:1px solid #eef1f6;
    border-radius:12px;
    padding:16px 18px;
    background:#fafbfd;
}

.activity-card-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-bottom:8px;
}

.activity-type-badge{
    padding:4px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    background:#e2e8f0;
    color:#334155;
    text-transform:capitalize;
}

.activity-type-note{ background:#fef3c7; color:#92400e; }
.activity-type-followup{ background:#dbeafe; color:#1d4ed8; }
.activity-type-lead_update, .activity-type-update{ background:#ede9fe; color:#5b21b6; }
.activity-type-call{ background:#dcfce7; color:#166534; }
.activity-type-email{ background:#fee2e2; color:#b91c1c; }

.activity-time{
    color:var(--muted);
    font-size:12px;
    white-space:nowrap;
}

.activity-desc{
    color:var(--text);
    font-size:14px;
    margin:0 0 6px;
}

.activity-by{
    color:var(--muted);
    font-size:12px;
}

@media(max-width:576px){

    .editable-card-head{
        flex-direction:column;
        align-items:flex-start;
    }
}

</style>
@endpush

@section('content')

<div class="crm-container">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="page-header">

        <div>
            <!-- <button type="button" class="icon-action-btn" title="Back" onclick="history.back()" style="margin-bottom:10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Back
            </button> -->
            <h1 class="page-title">{{ $lead->name }}</h1>
            <p class="page-subtitle">Complete CRM Lead Profile</p>
            <p class="page-subtitle">Lead ID: <strong>{{ $lead->lead_id ?? '-' }}</strong></p>
        </div>

        <div class="header-right">
            <button type="button" class="icon-action-btn" title="Compose email" onclick="openAdminModal('emailComposeModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                    <path d="m3 7 9 6 9-6"/>
                </svg>
                Email
            </button>
            <span class="badge status-{{ $lead->status }}">
                {{ ucfirst(str_replace('_',' ',$lead->status)) }}
            </span>
        </div>

    </div>

    <div class="summary-grid">

        <div class="summary-card">
            <h6>Lead Type</h6>
            <h3>{{ ucfirst($lead->lead_type) }}</h3>
        </div>

        <div class="summary-card">
            <h6>Agent</h6>
            <h3>{{ $lead->user?->name ?? 'Unassigned' }}</h3>
            @if($lead->user?->agent_id)
                <p class="page-subtitle">Agent ID: {{ $lead->user->agent_id }}</p>
            @endif
        </div>

        <div class="summary-card">
            <h6>Country</h6>
            <h3>{{ $lead->country }}</h3>
        </div>

        <div class="summary-card">
            <h6>Follow Up</h6>
            <h3>{{ $lead->next_followup_date?->format('d M Y') ?? 'N/A' }}</h3>
        </div>

    </div>

    <div class="section-card">

        <div class="editable-card-head">
            <h3>Lead Details</h3>
            <div class="assigned-agent-pill">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 4-6 8-6s8 2 8 6"/>
                </svg>
                Assigned Agent: <strong>{{ $lead->user?->name ?? 'Unassigned' }}</strong>
                @if($lead->user?->agent_id)
                    <span>({{ $lead->user->agent_id }})</span>
                @endif
            </div>

            <form method="POST"
                  action="{{ route('admin.lead.reassign-agent',$lead->id) }}"
                  style="display:flex;gap:8px;align-items:center;margin-top:10px;">

                @csrf

                <select name="user_id" class="form-control" style="max-width:220px;" required>
                    <option value="" disabled selected>Reassign to agent…</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}" {{ $lead->user_id == $agent->id ? 'disabled' : '' }}>
                            {{ $agent->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-primary">Reassign</button>

            </form>
        </div>

        <form method="POST"
              action="{{ route('admin.crm.update',$lead->id) }}">

            @csrf

            <div class="form-grid">

                <div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $lead->name }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $lead->email }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" id="editLeadPhoneInput" name="phone" value="{{ $lead->phone }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" name="company" value="{{ $lead->company }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Designation</label>
                        <input type="text" name="designation" value="{{ $lead->designation }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Usage Type</label>
                        <input type="text" name="usage_type" value="{{ $lead->usage_type }}" class="form-control">
                    </div>

                </div>

                <div>

                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" name="country" value="{{ $lead->country }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Timezone</label>
                        <input type="text" name="timezone" value="{{ $lead->timezone }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Current Time There</label>
                        <input type="text" class="form-control ld-live-clock" data-tz="{{ $lead->timezone }}"
                               value="{{ $lead->timezone ? now()->setTimezone($lead->timezone)->format('h:i A') : '-' }}"
                               disabled>
                    </div>

                    <div class="form-group">
                        <label>Status</label>

                        <select name="status" class="form-control">
                            <option value="new" {{ $lead->status=='new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ $lead->status=='contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="engaged" {{ $lead->status=='engaged' ? 'selected' : '' }}>Engaged</option>
                            <option value="converted" {{ $lead->status=='converted' ? 'selected' : '' }}>Converted</option>
                            <option value="not_interested" {{ $lead->status=='not_interested' ? 'selected' : '' }}>Not Interested</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Lead Type</label>

                        <select name="lead_type" class="form-control">
                            <option value="hot" {{ $lead->lead_type=='hot' ? 'selected' : '' }}>Hot</option>
                            <option value="warm" {{ $lead->lead_type=='warm' ? 'selected' : '' }}>Warm</option>
                            <option value="cold" {{ $lead->lead_type=='cold' ? 'selected' : '' }}>Cold</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Report Category</label>
                        <input type="text" value="{{ $lead->reportCategory?->category_name ?? '-' }}" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label>Report</label>
                        <input type="text" value="{{ $lead->report?->report_title ?? '-' }}" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label>Next Followup Date</label>

                        <input type="date"
                               name="next_followup_date"
                               value="{{ $lead->next_followup_date?->format('Y-m-d') }}"
                               class="form-control">
                    </div>

                </div>

            </div>

            <button type="submit" class="btn-primary">
                Save Changes
            </button>

        </form>

    </div>

</div>
<div class="section-card" style="margin-top:25px;">

<div class="editable-card-head">
    <h3>Email History</h3>
    <button type="button" class="icon-action-btn" onclick="openAdminModal('emailComposeModal')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="5" width="18" height="14" rx="2"/>
            <path d="m3 7 9 6 9-6"/>
        </svg>
        New Email
    </button>
</div>

<h4 style="color:var(--muted);font-weight:500;margin-bottom:15px;">
Total Emails: {{ $lead->emails->count() }}
</h4>

<div class="email-history-scroll-box">

@forelse(
    $lead->emails
        ->groupBy(function($email){
            return $email->thread_id ?? $email->conversation_id ?? $email->id;
        })
        // Most recently active conversation first - mirrors the Activity
        // Timeline's "latest on top" ordering instead of the default
        // oldest-thread-first order the emails relation returns.
        ->sortByDesc(function($emails){
            return $emails->max('created_at');
        })
    as $threadId => $emails
)

    @php
        $latestEmail = $emails->last();
        $replyTo = $emails->where('message_type', 'received')->last()?->from_email ?? $lead->email;
        $threadCc = $emails->pluck('cc_email')->filter()->flatMap(fn ($cc) => explode(',', $cc))->map('trim')->filter()->unique()->implode(',');
    @endphp

    <div class="email-thread-card">

        <div class="email-thread-head">
            <strong>{{ $latestEmail->subject ?: '(No subject)' }}</strong>
            <span>{{ $emails->count() }} message{{ $emails->count() === 1 ? '' : 's' }}</span>
        </div>

        @foreach($emails as $email)

            <details class="email-thread-item" {{ $loop->last ? 'open' : '' }}>

                <summary>
                    <span>{{ $email->message_type=='sent' ? 'You' : $email->from_email }}</span>
                    <span class="email-meta">
                        {{ $email->created_at->format('d M Y h:i A') }}
                        @if($email->attachment_path)
                            <span class="badge" title="{{ $email->attachment_name ?? 'Attachment.pdf' }}">📎</span>
                        @endif
                        @if(($email->delivery_status ?? 'sent') === 'failed')
                            <span class="badge status-not_interested" title="{{ $email->delivery_error }}">Failed to send</span>
                        @endif
                    </span>
                </summary>

                <div class="email-thread-body">

                    {!! $email->body !!}

                    @if($email->cc_email)
                        <p class="email-cc-line"><strong>CC:</strong> {{ $email->cc_email }}</p>
                    @endif

                    @if($email->attachment_path)
                        <a href="{{ asset('storage/'.$email->attachment_path) }}" target="_blank" class="badge">
                            📎 {{ $email->attachment_name ?? 'Attachment.pdf' }}
                        </a>
                    @endif

                    @if($email->message_type == 'received')
                        <button type="button"
                                class="btn-primary reply-btn"
                                data-subject="{{ $email->subject }}"
                                data-cc="{{ $email->cc_email }}"
                                data-from="{{ $email->from_email }}">
                            Reply
                        </button>
                    @endif

                </div>

            </details>

        @endforeach

    </div>

@empty

    <p>No email conversation available.</p>

@endforelse

</div>

</div>

{{-- ---- EMAIL COMPOSER MODAL ---- --}}
<div class="app-modal-overlay" id="emailComposeModal">
    <div class="app-modal-box" style="width:640px;">

        <div class="app-modal-header">
            <h3>Compose Email</h3>
            <button type="button" class="app-modal-close" onclick="closeAdminModal('emailComposeModal')">&times;</button>
        </div>

        <form method="POST"
              action="{{ route('admin.email.send',$lead->id) }}"
              enctype="multipart/form-data">

            @csrf

            <input type="hidden" id="replyToEmail" name="reply_to_email">

            <div class="app-modal-body">

                <div class="form-group">
                    <label>Email Template</label>

                    <select id="templateSelect" name="template_id" class="form-control">
                        <option value="">Select Template</option>

                        @foreach($templates as $template)
                            <option value="{{ $template->id }}"
                                    data-type="{{ $template->type }}"
                                    data-subject="{{ $template->subject }}"
                                    data-body="{{ $template->body }}">
                                {{ $template->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="globalLockNotice" style="display:none;">
                    <small style="color:#b45309;">This is the Sample Report template — the subject and message are left blank so you can write this lead's message yourself.</small>
                </div>

                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" id="subjectField" name="subject" class="form-control">
                </div>

                <div class="form-group">
                    <label>CC Emails</label>
                    <input type="text" id="ccField" name="cc_email" class="form-control"
                           placeholder="abc@gmail.com, xyz@gmail.com">
                </div>

                <div class="form-group">
                    <label>Email Body</label>
                    <textarea id="emailEditor" name="body"></textarea>
                </div>

                <div class="form-group">
                    <label>Attach extra PDFs (optional)</label>
                    <input type="file" name="attachments[]" accept="application/pdf" multiple>
                    <small style="color:#64748b">The lead's report category PDF is attached automatically — use this only to add more PDFs on top of it (up to 5, 10MB total).</small>
                </div>

            </div>

            <div class="app-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeAdminModal('emailComposeModal')">Cancel</button>
                <button type="submit" class="btn-save">Send Email</button>
            </div>

        </form>

    </div>
</div>
<div class="section-card" style="margin-top:25px;">

    <h3>Activity Timeline</h3>

    <div class="activity-scroll-box">

        @forelse($lead->activities as $activity)

            <div class="activity-card">

                <div class="activity-card-head">
                    <span class="activity-type-badge activity-type-{{ $activity->activity_type }}">
                        {{ ucfirst(str_replace('_',' ',$activity->activity_type)) }}
                    </span>
                    <span class="activity-time">
                        {{ $activity->created_at->format('d M Y, h:i A') }}
                    </span>
                </div>

                <p class="activity-desc">
                    {{ $activity->description }}
                </p>

                <div class="activity-by">
                    by {{ $activity->created_by }}
                </div>

            </div>

        @empty

            <p>No activity found.</p>

        @endforelse

    </div>

</div>
<div class="section-card" style="margin-top:25px;">

    <h3>Followup History</h3>

    @forelse($lead->followupHistories as $followup)

        <div class="timeline-item">

            <strong>
                {{ $followup->header ?? 'Followup #'.$followup->followup_no }}
            </strong>

            <p>

                {{ $followup->remarks }}

            </p>

            <small>

                {{ $followup->completed_at ? \Carbon\Carbon::parse($followup->completed_at)->format('d M Y, h:i A') : '' }}

                @if($followup->user)

                    • {{ $followup->user->name }}

                @endif

            </small>

        </div>

        <hr>

    @empty

        <p>No followups completed.</p>

    @endforelse

</div>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/intlTelInput.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const phoneInput = document.getElementById('editLeadPhoneInput');
    if (!phoneInput) return;

    const iti = window.intlTelInput(phoneInput, {
        initialCountry: 'in',
        separateDialCode: true,
        loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/utils.js'),
    });

    phoneInput.closest('form').addEventListener('submit', function () {
        if (phoneInput.value.trim() !== '') {
            phoneInput.value = iti.getNumber();
        }
    });
});
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
function ldAdminUpdateClocks(){
    document.querySelectorAll('.ld-live-clock').forEach(function(el){
        const tz = el.dataset.tz;
        if(!tz){ return; }
        try{
            const formatted = new Intl.DateTimeFormat('en-US', {
                timeZone: tz,
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            }).format(new Date());
            if('value' in el){ el.value = formatted; } else { el.textContent = formatted; }
        }catch(e){ /* invalid timezone string, leave server-rendered value */ }
    });
}
ldAdminUpdateClocks();
setInterval(ldAdminUpdateClocks, 30000);
</script>

<script>

let emailEditor;

ClassicEditor
.create(document.querySelector('#emailEditor'))
.then(editor => {

    emailEditor = editor;

})
.catch(error => console.error(error));

/* ---------- Sample Report template selection ---------- */
// Picking the Sample Report (global) template no longer fills in, or
// locks, a fixed subject/body - it just shows a hint that this send will
// start the follow-up countdown. The subject field and CKEditor stay
// editable so the admin always writes this lead's message themselves.
function setAdminTemplateLock(isGlobal){

    const notice = document.getElementById('globalLockNotice');

    notice.style.display = isGlobal ? 'block' : 'none';
}

document
.querySelectorAll('.reply-btn')
.forEach(button => {

    button.addEventListener('click', function(){

        let subject = this.dataset.subject;
        let cc = this.dataset.cc;
        let from = this.dataset.from;


        if(!subject.startsWith('Re:')){

            subject = 'Re: ' + subject;

        }

        openAdminModal('emailComposeModal');

        // A reply is always freeform, never a locked Global template -
        // clear any template that was previously picked and unlock the
        // fields even if the last compose left them locked.
        document
        .getElementById('templateSelect')
        .value = '';

        setAdminTemplateLock(false);

        document
        .getElementById('subjectField')
        .value = subject;

        document
.getElementById('ccField')
.value = cc ?? '';
document
.getElementById('replyToEmail')
.value = from;


        emailEditor.setData('');

    });

});


</script>

<script>

function openAdminModal(id){
    document.getElementById(id).classList.add('active');
}

function closeAdminModal(id){
    document.getElementById(id).classList.remove('active');
}

document.querySelectorAll('.app-modal-overlay').forEach(function(overlay){
    overlay.addEventListener('click', function(e){
        if(e.target === overlay){
            overlay.classList.remove('active');
        }
    });
});

@if($errors->any() && $errors->has('subject'))
    document.addEventListener('DOMContentLoaded', function(){ openAdminModal('emailComposeModal'); });
@endif

</script>

<script>

document
.getElementById('templateSelect')
.addEventListener('change', function(){

    let option =
        this.options[this.selectedIndex];

    let isGlobal =
        option.dataset.type === 'global';

    // The Sample Report template no longer comes pre-filled with canned
    // wording - selecting it just starts a blank subject/body for the
    // admin to write themselves. Any other template type (if one is ever
    // added back) still autofills from what's saved on it.
    let subject =
        isGlobal ? '' : (option.dataset.subject || '');

    let body =
        isGlobal ? '' : (option.dataset.body || '');

  body = body.replace(
    new RegExp('\\{\\{name\\}\\}', 'g'),
    "{{ $lead->name }}"
);

    document
        .getElementById('subjectField')
        .value = subject;

    if(emailEditor){

        emailEditor.setData(body);

    }

    setAdminTemplateLock(isGlobal);

});

</script>
@endsection