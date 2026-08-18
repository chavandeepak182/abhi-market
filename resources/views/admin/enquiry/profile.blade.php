@extends('admin.layouts.header')

@section('title', 'Lead Profile - '.$enquiry->name)

@section('content')

<div class="dashboard-body">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">{{ $enquiry->name }}</h4>
            <p class="text-muted mb-0">Enquiry ID: #{{ $enquiry->id }} &middot; Complete Lead Profile (Read Only)</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('enquiry.export', $enquiry->id) }}" class="btn btn-success">
                <i class="fas fa-download"></i> Export
            </a>
            <a href="{{ route('enquiry.show', $enquiry->id) }}" class="btn btn-primary">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('enquiries.enquiryLead') }}" class="btn btn-secondary">Back to All Enquiries</a>
        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted small mb-1">Lead Type</div>
                    <div class="fw-bold">{{ $enquiry->lead_type ? ucfirst($enquiry->lead_type) : '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted small mb-1">Agent</div>
                    <div class="fw-bold">{{ $enquiry->agent_name ?? 'Unassigned' }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted small mb-1">Country</div>
                    <div class="fw-bold">{{ $enquiry->country_name ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="text-muted small mb-1">Follow Up</div>
                    <div class="fw-bold">{{ $enquiry->followup_date ? \Carbon\Carbon::parse($enquiry->followup_date)->format('d M Y') : 'N/A' }}</div>
                </div>
            </div>
        </div>

    </div>

    {{-- LEAD DETAILS --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Lead Details</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <p class="mb-0">{{ $enquiry->email }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Phone</label>
                    <p class="mb-0">{{ $enquiry->contact ?: '-' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Company</label>
                    <p class="mb-0">{{ $enquiry->company_name ?: '-' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Job Title</label>
                    <p class="mb-0">{{ $enquiry->job_title ?: '-' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Usage Type</label>
                    <p class="mb-0">{{ $enquiry->usage_type ? ucfirst($enquiry->usage_type) : '-' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Timezone</label>
                    <p class="mb-0">{{ $enquiry->timezone ?: '-' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <p class="mb-0">
                        <span class="badge status-{{ $enquiry->status }}">
                            {{ ucfirst(str_replace('_',' ', $enquiry->status)) }}
                        </span>
                    </p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Converted Amount</label>
                    <p class="mb-0">{{ $enquiry->converted_amount ? number_format($enquiry->converted_amount, 2) : '-' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Created At</label>
                    <p class="mb-0">{{ \Carbon\Carbon::parse($enquiry->created_at)->format('d M Y, h:i A') }}</p>
                </div>

                <div class="col-md-12 mb-0">
                    <label class="form-label fw-bold">Message</label>
                    <p class="mb-0">{{ $enquiry->message ?: 'No message available' }}</p>
                </div>

            </div>

        </div>

    </div>

    {{-- ACTIVITY TIMELINE --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Activity Timeline</h5>
        </div>

        <div class="card-body" style="max-height:400px; overflow-y:auto;">

            @forelse($activities as $activity)

                <div class="border-bottom py-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge activity-type-{{ $activity->activity_type }}">
                            {{ ucfirst(str_replace('_',' ', $activity->activity_type)) }}
                        </span>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($activity->created_at)->format('d M Y, h:i A') }}
                        </small>
                    </div>

                    <p class="mb-1 mt-1">{{ $activity->description }}</p>
                    <small class="text-muted">by {{ $activity->user_name ?? 'System' }}</small>

                </div>

            @empty
                <p class="text-muted mb-0">No activity yet.</p>
            @endforelse

        </div>

    </div>

    {{-- EMAIL HISTORY (read only) --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Email History</h5>
        </div>

        <div class="card-body">

            <div class="accordion" id="emailAccordion">

                @forelse($emails as $key => $mail)

                    <div class="accordion-item mb-2">

                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#email{{ $key }}">
                                <div class="w-100">
                                    <strong>{{ $mail->to_email ?? $enquiry->email }}</strong>
                                    @if(($mail->source ?? 'ai') === 'manual')
                                        <span class="badge bg-primary">Agent</span>
                                    @else
                                        <span class="badge bg-secondary">AI</span>
                                    @endif
                                    <br>
                                    <small>{{ $mail->email_subject }}</small>
                                </div>
                            </button>
                        </h2>

                        <div id="email{{ $key }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                {!! nl2br(e($mail->email_body)) !!}
                            </div>
                        </div>

                    </div>

                @empty
                    <p class="text-muted mb-0">No emails sent yet.</p>
                @endforelse

            </div>

        </div>

    </div>

    {{-- MEETINGS (read only) --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Meetings</h5>
        </div>

        <div class="card-body">

            @forelse($meetings as $m)

                <div class="border-bottom py-2 d-flex justify-content-between align-items-center">

                    <div>
                        <strong>{{ \Carbon\Carbon::parse($m->scheduled_at)->format('d M Y, h:i A') }}</strong>
                        ({{ $m->duration_minutes }} min)
                        @if($m->notes)
                            <div class="text-muted small">{{ $m->notes }}</div>
                        @endif
                    </div>

                    <span class="badge bg-info text-dark">{{ ucfirst($m->status) }}</span>

                </div>

            @empty
                <p class="text-muted mb-0">No meetings scheduled yet.</p>
            @endforelse

        </div>

    </div>

    {{-- FOLLOWUP HISTORY --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Followup History</h5>
        </div>

        <div class="card-body">

            @forelse($followups as $f)

                <div class="border-bottom py-2">
                    <strong>{{ $f->followup_date ? \Carbon\Carbon::parse($f->followup_date)->format('d M Y') : 'Followup' }}</strong>
                    <p class="mb-0">{{ $f->remark ?? '-' }}</p>
                </div>

            @empty
                <p class="text-muted mb-0">No followups yet.</p>
            @endforelse

        </div>

    </div>

</div>

<style>
    .activity-type-note{ background:#fef3c7; color:#92400e; }
    .activity-type-status{ background:#dbeafe; color:#1e40af; }
    .activity-type-attachment{ background:#dcfce7; color:#166534; }
    .activity-type-followup{ background:#fee2e2; color:#991b1b; }
    .activity-type-email{ background:#e0f2fe; color:#075985; }
    .activity-type-meeting{ background:#fae8ff; color:#86198f; }
    .status-new{ background:#e5e7eb; color:#374151; }
    .status-contacted{ background:#dbeafe; color:#1d4ed8; }
    .status-converted{ background:#ecfccb; color:#365314; }
    .status-not_interested{ background:#fee2e2; color:#991b1b; }
</style>

@endsection
