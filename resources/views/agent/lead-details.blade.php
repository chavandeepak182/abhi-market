@extends('admin.layouts.header')

@section('title', 'Lead Details')

@section('content')

<div class="dashboard-body">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">{{ $enquiry->name }}</h4>
            <p class="text-muted mb-0">Lead ID: #{{ $enquiry->id }}</p>
        </div>

        <a href="{{ route('agent.leads') }}" class="btn btn-secondary">Back to My Enquiries</a>

    </div>

    {{-- READ-ONLY PROFILE --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Lead Profile</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <p class="mb-0">{{ $enquiry->email }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Mobile</label>
                    <p class="mb-0">{{ $enquiry->contact }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Country</label>
                    <p class="mb-0">{{ $enquiry->country_name ?? '-' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Job Title</label>
                    <p class="mb-0">{{ $enquiry->job_title ?? '-' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Company</label>
                    <p class="mb-0">{{ $enquiry->company_name ?? '-' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Current Status</label>
                    <p class="mb-0">
                        <span class="badge status-{{ $enquiry->status }}">
                            {{ ucfirst(str_replace('_',' ', $enquiry->status)) }}
                        </span>
                    </p>
                </div>

                <div class="col-md-12 mb-0">
                    <label class="form-label fw-bold">Message</label>
                    <p class="mb-0">{{ $enquiry->message ?? 'No message available' }}</p>
                </div>

            </div>

        </div>

    </div>

    {{-- STATUS CHANGE --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Change Status</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('enquiry.status.update', $enquiry->id) }}" method="POST" class="d-flex gap-2 align-items-center">

                @csrf

                <select name="status" class="form-control" style="max-width:250px;">
                    <option value="new" @selected($enquiry->status == 'new')>New</option>
                    <option value="contacted" @selected($enquiry->status == 'contacted')>Contacted</option>
                    <option value="converted" @selected($enquiry->status == 'converted')>Converted</option>
                    <option value="not_interested" @selected($enquiry->status == 'not_interested')>Not Interested</option>
                </select>

                <button type="submit" class="btn btn-primary">Update Status</button>

            </form>

        </div>

    </div>

    {{-- NOTES / ACTIVITY --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Notes &amp; Activity</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('enquiry.note.store', $enquiry->id) }}" method="POST" class="mb-4">

                @csrf

                <label class="form-label fw-bold">Add Note</label>

                <textarea name="note" rows="2" class="form-control mb-2"
                          placeholder="Add a note about this lead..." required></textarea>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add Note
                </button>

            </form>

            <div style="max-height:350px; overflow-y:auto;">

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

    </div>

    {{-- EMAIL --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Email</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('enquiry.email.send', $enquiry->id) }}" method="POST" class="mb-4">

                @csrf

                <div class="mb-2">
                    <label class="form-label fw-bold">Subject</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold">Message</label>
                    <textarea name="body" rows="4" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-paper-plane"></i> Send Email
                </button>

            </form>

            <div class="accordion" id="emailAccordion">

                @forelse($emails as $key => $mail)

                    <div class="accordion-item mb-2">

                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#email{{ $key }}">
                                <div class="w-100">
                                    <strong>{{ $mail->to_email ?? $enquiry->email }}</strong>
                                    @if(($mail->source ?? 'ai') === 'manual')
                                        <span class="badge bg-primary">You</span>
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

    {{-- MEETINGS --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header">
            <h5 class="mb-0">Meetings</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('enquiry.meeting.store', $enquiry->id) }}" method="POST" class="row g-2 align-items-end mb-4">

                @csrf

                <div class="col-md-4">
                    <label class="form-label fw-bold">Date &amp; Time</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Duration</label>
                    <select name="duration_minutes" class="form-control">
                        <option value="15">15 minutes</option>
                        <option value="30" selected>30 minutes</option>
                        <option value="45">45 minutes</option>
                        <option value="60">1 hour</option>
                        <option value="90">1.5 hours</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Notes</label>
                    <input type="text" name="notes" class="form-control" placeholder="Optional">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Schedule</button>
                </div>

            </form>

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

    {{-- FOLLOWUP HISTORY (read-only) --}}
    @if(count($followups))
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header">
                <h5 class="mb-0">Followup History</h5>
            </div>

            <div class="card-body">

                @foreach($followups as $f)

                    <div class="border-bottom py-2">
                        <strong>{{ $f->followup_date ? \Carbon\Carbon::parse($f->followup_date)->format('d M Y') : 'Followup' }}</strong>
                        <p class="mb-0">{{ $f->remark ?? '-' }}</p>
                    </div>

                @endforeach

            </div>

        </div>
    @endif

</div>

<style>
    .activity-type-note{ background:#fef3c7; color:#92400e; }
    .activity-type-status{ background:#dbeafe; color:#1e40af; }
    .activity-type-attachment{ background:#dcfce7; color:#166534; }
    .activity-type-followup{ background:#fee2e2; color:#991b1b; }
    .activity-type-email{ background:#e0f2fe; color:#075985; }
    .activity-type-meeting{ background:#fae8ff; color:#86198f; }
</style>

@endsection
