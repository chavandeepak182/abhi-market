@extends('admin.layouts.header')

@section('title', 'Lead Profile - '.$lead->name)

@push('styles')
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
    flex-wrap:wrap;
    gap:15px;
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
    display:flex;
    align-items:center;
    gap:12px;
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

.section-card{
    background:#fff;
    border-radius:16px;
    padding:30px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
    margin-bottom:25px;
}

.section-card h3{
    margin-bottom:25px;
}

.readonly-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:0 40px;
}

.info-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 0;
    border-bottom:1px solid #f1f5f9;
    gap:15px;
}

.info-row:last-child{
    border-bottom:none;
}

.info-row span{
    color:var(--muted);
    font-weight:500;
}

.info-row strong{
    color:var(--text);
    text-align:right;
}

.badge{
    padding:6px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

.status-new{ background:#e5e7eb; color:#374151; }
.status-contacted{ background:#dbeafe; color:#1d4ed8; }
.status-engaged{ background:#dcfce7; color:#166534; }
.status-converted{ background:#ecfccb; color:#365314; }
.status-not_interested{ background:#fee2e2; color:#991b1b; }

.type-hot{ background:#fee2e2; color:#dc2626; }
.type-warm{ background:#fef3c7; color:#b45309; }
.type-cold{ background:#dbeafe; color:#2563eb; }

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
    text-decoration:none;
}

.icon-action-btn:hover{
    background:#c7ddfc;
    color:var(--primary);
}

.icon-action-btn svg{
    width:18px;
    height:18px;
}

.btn-export{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:var(--success);
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:10px;
    font-weight:600;
    font-size:14px;
    cursor:pointer;
    text-decoration:none;
}

.btn-export:hover{
    background:#0d9c6d;
    color:#fff;
}

.btn-export svg{
    width:18px;
    height:18px;
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
    margin-bottom:20px;
}

.assigned-agent-pill svg{
    width:16px;
    height:16px;
    color:var(--primary);
}

.assigned-agent-pill strong{
    color:var(--primary);
}

/* Email history threads (read only, no reply actions) */

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

/* Activity timeline */

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

.timeline-item strong{
    color:var(--text);
}

.timeline-item p{
    color:#334155;
    margin:6px 0;
}

.timeline-item small{
    color:var(--muted);
}

@media(max-width:992px){

    .summary-grid{
        grid-template-columns:1fr 1fr;
    }

    .readonly-grid{
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

    .info-row strong{
        text-align:left;
    }
}

/* Hide chrome (buttons/back link) when printing, so "Export" doubles as a
   clean PDF print of the profile if the user chooses "Save as PDF". */
@media print{

    .no-print{
        display:none !important;
    }
}

</style>
@endpush

@section('content')

<div class="crm-container">

    <div class="page-header">

        <div>
            <!-- <button type="button" class="icon-action-btn no-print" title="Back" onclick="history.back()" style="margin-bottom:10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Back
            </button> -->
            <h1 class="page-title">{{ $lead->name }}</h1>
            <p class="page-subtitle">Complete Lead Profile (Read Only)</p>
            <p class="page-subtitle">Lead ID: <strong>{{ $lead->lead_id ?? '-' }}</strong></p>
        </div>

        <div class="header-right">

            <a href="{{ route('leads.view.export', $lead->id) }}" class="btn-export no-print">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export
            </a>
            
            <a href="{{ route('leads.show',$lead->id)}}"
                                class= "btn-edit">

                                    Edit

                                </a>


            <span class="badge status-{{ $lead->status }}">
                {{ ucfirst(str_replace('_',' ',$lead->status)) }}
            </span>

        </div>

    </div>

    <div class="summary-grid">

        <div class="summary-card">
            <h6>Lead Type</h6>
            <h3><span class="badge type-{{ $lead->lead_type }}">{{ ucfirst($lead->lead_type) }}</span></h3>
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

        <div class="readonly-grid">

            <div>

                <div class="info-row">
                    <span>Name</span>
                    <strong>{{ $lead->name }}</strong>
                </div>

                <div class="info-row">
                    <span>Email</span>
                    <strong>{{ $lead->email }}</strong>
                </div>

                <div class="info-row">
                    <span>Phone</span>
                    <strong>{{ $lead->phone ?: '-' }}</strong>
                </div>

                <div class="info-row">
                    <span>Company</span>
                    <strong>{{ $lead->company ?: '-' }}</strong>
                </div>

                <div class="info-row">
                    <span>Designation</span>
                    <strong>{{ $lead->designation ?: '-' }}</strong>
                </div>

                <div class="info-row">
                    <span>Usage Type</span>
                    <strong>{{ $lead->usage_type ?: '-' }}</strong>
                </div>

                <div class="info-row">
                    <span>Source</span>
                    <strong>{{ $lead->source ?: '-' }}</strong>
                </div>

            </div>

            <div>

                <div class="info-row">
                    <span>Country</span>
                    <strong>{{ $lead->country ?: '-' }}</strong>
                </div>

                <div class="info-row">
                    <span>Timezone</span>
                    <strong>{{ $lead->timezone ?: '-' }}</strong>
                </div>

                <div class="info-row">
                    <span>Status</span>
                    <strong><span class="badge status-{{ $lead->status }}">{{ ucfirst(str_replace('_',' ',$lead->status)) }}</span></strong>
                </div>

                <div class="info-row">
                    <span>Lead Type</span>
                    <strong><span class="badge type-{{ $lead->lead_type }}">{{ ucfirst($lead->lead_type) }}</span></strong>
                </div>

                <div class="info-row">
                    <span>Report Category</span>
                    <strong>{{ $lead->reportCategory?->category_name ?? '-' }}</strong>
                </div>

                <div class="info-row">
                    <span>Report</span>
                    <strong>{{ $lead->report?->report_title ?? '-' }}</strong>
                </div>

                <div class="info-row">
                    <span>Next Followup Date</span>
                    <strong>{{ $lead->next_followup_date?->format('d M Y') ?? 'N/A' }}</strong>
                </div>

                <div class="info-row">
                    <span>Created At</span>
                    <strong>{{ $lead->created_at?->format('d M Y, h:i A') }}</strong>
                </div>

            </div>

        </div>

    </div>

    <div class="section-card">

        <h3>Email History</h3>

        <h4 style="color:var(--muted);font-weight:500;margin-bottom:15px;">
            Total Emails: {{ $lead->emails->count() }}
        </h4>

        <div class="email-history-scroll-box">

            @forelse(
                $lead->emails
                    ->groupBy(function($email){
                        return $email->thread_id ?? $email->conversation_id ?? $email->id;
                    })
                    ->sortByDesc(function($emails){
                        return $emails->max('created_at');
                    })
                as $threadId => $emails
            )

                @php
                    $latestEmail = $emails->last();
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

                            </div>

                        </details>

                    @endforeach

                </div>

            @empty

                <p>No email conversation available.</p>

            @endforelse

        </div>

    </div>

    <div class="section-card">

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

    <div class="section-card">

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

</div>

@endsection