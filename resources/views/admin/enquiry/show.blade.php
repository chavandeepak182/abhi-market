@extends('admin.layouts.header')

@section('title', 'Lead Details')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


@section('content')

<div class="dashboard-body">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">Lead Details</h4>

            <p class="text-muted mb-0">
                Manage and update lead information
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('enquiry.export', $enquiry->id) }}"
               class="btn btn-success">

                <i class="fas fa-download"></i>
                Export

            </a>

            <a href="{{ url()->previous() }}"
               class="btn btn-secondary">

                Back

            </a>

        </div>

    </div>

    <!-- Main Card -->
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form action="{{ route('enquiry.update') }}"
                  method="POST">

                @csrf

                <input type="hidden"
                       name="id"
                       value="{{ $enquiry->id }}">

                <div class="row">

                    <!-- NAME -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">
                            Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ $enquiry->name }}">
                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ $enquiry->email }}">
                    </div>

                    <!-- MOBILE -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">
                            Mobile
                        </label>

                        <input type="text"
                               name="contact"
                               class="form-control"
                               value="{{ $enquiry->contact }}">
                    </div>

                    <!-- JOB TITLE -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">
                            Job Title
                        </label>

                        <input type="text"
                               name="job_title"
                               class="form-control"
                               value="{{ $enquiry->job_title }}">
                    </div>

                    <!-- COUNTRY -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">
                            Country
                        </label>

                        <input type="text"
                               class="form-control"
                               value="{{ $enquiry->country_name }}"
                               readonly>
                    </div>

                    <!-- STATUS -->
                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-bold">
                            Status
                        </label>

                        <select name="status"
                                id="status"
                                class="form-control">

                            <option value="new"
                                {{ $enquiry->status == 'new' ? 'selected' : '' }}>
                                New
                            </option>

                            <option value="contacted"
                                {{ $enquiry->status == 'contacted' ? 'selected' : '' }}>
                                Contacted
                            </option>

                            <option value="converted"
                                {{ $enquiry->status == 'converted' ? 'selected' : '' }}>
                                Converted
                            </option>

                            <option value="not_interested"
                                {{ $enquiry->status == 'not_interested' ? 'selected' : '' }}>
                                Not Interested
                            </option>

                        </select>
                    </div>

                  <!-- ASSIGNED TO -->
                    <div class="col-md-4 mb-4">

                        <label class="form-label fw-bold">
                            Assign To
                        </label>

                        @if(session('role_id') != config('constants.roles.agent') || session('can_assign_leads') == 1)

                            <select name="assigned_to" class="form-control">
                                <option value="">Select Agent</option>

                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}"
                                        {{ $enquiry->assigned_to == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach

                            </select>

                        @else

                            <input type="text"
                                class="form-control"
                                value="{{ $enquiry->agent_name ?? 'Not Assigned' }}"
                                readonly>

                            <input type="hidden"
                                name="assigned_to"
                                value="{{ $enquiry->assigned_to }}">

                        @endif

                    </div>

                    <!-- LEAD TYPE -->
                    <div class="col-md-4 mb-4">

                        <label class="form-label fw-bold">
                            Lead Type
                        </label>

                        <select name="lead_type"
                                class="form-control">

                            <option value="">Select</option>

                            <option value="hot"
                                {{ $enquiry->lead_type == 'hot' ? 'selected' : '' }}>
                                Hot
                            </option>

                            <option value="warm"
                                {{ $enquiry->lead_type == 'warm' ? 'selected' : '' }}>
                                Warm
                            </option>

                            <option value="cold"
                                {{ $enquiry->lead_type == 'cold' ? 'selected' : '' }}>
                                Cold
                            </option>

                        </select>

                    </div>

                   
<div class="col-md-12 mb-4">

    <div class="d-flex justify-content-between align-items-center mb-2">

        <label class="form-label fw-bold mb-0">
            Followups
        </label>

        <button type="button"
                class="btn btn-sm btn-primary"
                id="addFollowup">

            <i class="fas fa-plus"></i> Add Followup

        </button>

    </div>

    <div id="followupWrapper">

<div class="followup-item border rounded p-3 mb-3">


<h5 class="mb-3 text-primary followup-title">

    1st Followup

</h5>


    <div class="row">

        <!-- DATE -->
        <div class="col-md-5">

            <label class="form-label">
                Followup Date
            </label>

          <input type="datetime-local"
       id="followup_date"
       name="followup_date[]"
       class="form-control">

        </div>
        <input type="hidden" name="followup_id[]" id="followup_id">

        <!-- REMARK -->
       <div class="col-md-5">

    <label class="form-label">
        Remark
    </label>

    <textarea id="remark"
          name="remark[]"
          class="form-control summernote"></textarea>

    <label class="form-label mt-2">
        Client Reply
    </label>

    <textarea id="client_reply"
          name="client_reply[]"
          class="form-control"
          placeholder="Client Reply"></textarea>

</div>
  

        <!-- REMOVE -->
        <div class="col-md-2 d-flex align-items-end">

            <button type="button"
                    class="btn btn-danger removeFollowup w-100">

                Remove

            </button>

        </div>

    </div>

</div>

    </div>

</div>
<script>

document.getElementById('addFollowup').addEventListener('click', function () {

    let count = document.querySelectorAll('.followup-item').length + 1;

    let html = `

    <div class="followup-item border rounded p-3 mb-3">

        <h5 class="mb-3 text-primary followup-title">
            ${count} Followup
        </h5>

        <div class="row">

            <div class="col-md-5">
                <label class="form-label">
                    Followup Date
                </label>

                <input type="datetime-local"
                       name="followup_date[]"
                       class="form-control">
            </div>

            <div class="col-md-5">

                <label class="form-label">
                    Remark
                </label>

                <textarea name="remark[]"
                          class="form-control summernote"></textarea>

                <label class="form-label mt-2">
                    Client Reply
                </label>

                <textarea name="client_reply[]"
                          class="form-control"
                          placeholder="Client Reply"></textarea>

            </div>

            <div class="col-md-2 d-flex align-items-end">

                <button type="button"
                        class="btn btn-danger removeFollowup w-100">
                    Remove
                </button>

            </div>

        </div>

    </div>
    `;

    document.getElementById('followupWrapper')
        .insertAdjacentHTML('beforeend', html);

    $('.summernote').summernote({
        height: 120,
        placeholder: 'Write followup notes...'
    });

});

$(document).ready(function () {

    $('.summernote').summernote({
        height: 120,
        placeholder: 'Write followup notes...'
    });

});

document.addEventListener('click', function(e){

    if(e.target.classList.contains('removeFollowup')){

        e.target.closest('.followup-item').remove();

    }

});

</script>
                    <!-- AMOUNT -->
                    <div class="col-md-4 mb-4">

                        <label class="form-label fw-bold">
                            Converted Amount
                        </label>

                        <input type="number"
                               step="0.01"
                               name="converted_amount"
                               class="form-control"
                               value="{{ $enquiry->converted_amount }}">
                    </div>

                    <!-- PAGE -->
                    <div class="col-md-12 mb-4">

                        <label class="form-label fw-bold">
                            Page Name
                        </label>

                        <input type="text"
                               class="form-control"
                               value="{{ $enquiry->page_name }}"
                               readonly>
                    </div>

                    <!-- MESSAGE -->
                    <div class="col-md-12 mb-4">

                        <label class="form-label fw-bold">
                            Message
                        </label>

                        <textarea name="message"
                                  rows="4"
                                  class="form-control">{{ $enquiry->message }}</textarea>
                    </div>

                 

                </div>

                <!-- Submit -->
                <div class="text-end">

                    <button type="submit"
                            class="btn btn-primary px-5">

                        Update Lead

                    </button>

                </div>

            </form>
@if(isset($followups) && count($followups))

<div class="card mt-4">

    <div class="card-header">
        <h5 class="mb-0">Followup Timeline</h5>
    </div>

    <div class="card-body">

        @foreach($followups as $index => $f)

            {{-- your followup code --}}

        @endforeach

    </div>

</div>

@endif


{{-- EMAIL CONVERSATION STARTS HERE --}}

<div class="accordion" id="emailAccordion">

@foreach($emails as $key => $mail)

<div class="accordion-item mb-2">

    <h2 class="accordion-header">

        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#email{{ $key }}">

            <div class="w-100">

                <strong>
                    {{ $mail->from_email }}
                </strong>

                <br>

                <small>
                    {{ $mail->email_subject }}
                </small>

            </div>

        </button>

    </h2>

    <div
        id="email{{ $key }}"
        class="accordion-collapse collapse">

        <div class="accordion-body">

            {!! nl2br(e($mail->email_body)) !!}

        </div>

    </div>

</div>

@endforeach

</div>
<style>
    .accordion-button{
    background:#fff;
}

.accordion-button:not(.collapsed){
    background:#f8f9fa;
}

.accordion-body{
    white-space:pre-wrap;
    line-height:1.8;
    font-size:15px;
}
</style>
{{-- EMAIL CONVERSATION ENDS HERE --}}

{{-- COMPOSE EMAIL (CC / Reply-To / BCC / Attachments / Template) STARTS HERE --}}

<div class="card mt-4">

    <div class="card-header">
        <h5 class="mb-0">Compose Email</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.email.send', $enquiry->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            @if(isset($emailTemplate) && $emailTemplate)
                <div class="mb-3">
                    <label class="form-label fw-bold">Template</label>
                    <select name="template_id" id="templateSelect" class="form-control">
                        <option value="">-- No template --</option>
                        <option value="{{ $emailTemplate->id }}"
                                data-subject="{{ $emailTemplate->subject }}"
                                data-body="{{ $emailTemplate->body }}">
                            {{ $emailTemplate->name }}
                        </option>
                    </select>
                    <small class="text-muted">
                        Picking this only starts the follow-up countdown on send - subject/body below are always yours to edit.
                    </small>
                </div>
            @endif

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Subject</label>
                    <input type="text" name="subject" id="emailSubject" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Reply-To (optional)</label>
                    <input type="email" name="reply_to_email" class="form-control"
                           placeholder="Different from lead's own email, if needed">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">CC (comma separated)</label>
                    <input type="text" name="cc_email" class="form-control"
                           placeholder="agent@example.com, another@example.com">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">BCC (comma separated)</label>
                    <input type="text" name="bcc_email" class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Message</label>
                    <textarea name="body" id="emailBody" rows="6" class="form-control" required></textarea>
                    <small class="text-muted">
                       <small class="text-muted">
    Placeholders available:
    @{{name}},
    @{{report_name}},
    @{{agent_name}},
    @{{company}}
</small>S
                    </small>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Attachments (up to 5, 10MB total)</label>
                    <input type="file" name="attachments[]" class="form-control" multiple>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Send Email
            </button>

        </form>

    </div>

</div>

@if(isset($emailTemplate) && $emailTemplate)
<script>
document.getElementById('templateSelect')?.addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    if (!opt.dataset.subject && !opt.dataset.body) return;
    document.getElementById('emailSubject').value = opt.dataset.subject || '';
    document.getElementById('emailBody').value = opt.dataset.body || '';
});
</script>
@endif

{{-- EMAIL THREAD (email_messages: sent history, with CC/BCC/attachments) --}}

<div class="card mt-4">

    <div class="card-header">
        <h5 class="mb-0">Email Thread</h5>
    </div>

    <div class="card-body">

        <div class="accordion" id="emailThreadAccordion">

            @forelse($emailThread as $key => $mail)

                <div class="accordion-item mb-2">

                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#emailThread{{ $key }}">
                            <div class="w-100">
                                <strong>{{ $mail->to_email }}</strong>
                                @if($mail->delivery_status === 'failed')
                                    <span class="badge bg-danger">Failed</span>
                                @else
                                    <span class="badge bg-success">Sent</span>
                                @endif
                                <br>
                                <small>{{ $mail->subject }}</small>
                                @if($mail->cc_email)
                                    <br><small class="text-muted">CC: {{ $mail->cc_email }}</small>
                                @endif
                            </div>
                        </button>
                    </h2>

                    <div id="emailThread{{ $key }}" class="accordion-collapse collapse">
                        <div class="accordion-body">

                            {!! nl2br(e($mail->body)) !!}

                            @if($mail->delivery_error)
                                <p class="text-danger mt-2 mb-0">Error: {{ $mail->delivery_error }}</p>
                            @endif

                            @if($mail->attachments->count())
                                <hr>
                                @foreach($mail->attachments as $att)
                                    <a href="{{ asset('storage/'.$att->file_path) }}" target="_blank" class="d-block">
                                        📎 {{ $att->file_name }}
                                    </a>
                                @endforeach
                            @endif

                        </div>
                    </div>

                </div>

            @empty
                <p class="text-muted mb-0">No emails sent yet through the compose form.</p>
            @endforelse

        </div>

    </div>

</div>

{{-- COMPOSE EMAIL ENDS HERE --}}
        </div>

    </div>

</div>
<script>
    document.addEventListener('click', function(e){

    if(e.target.classList.contains('edit-followup')){

        document.getElementById('followup_id').value =
            e.target.dataset.id;

        document.getElementById('followup_date').value =
            e.target.dataset.date;

        $('#remark').summernote('code',
            e.target.dataset.remark);

        document.getElementById('client_reply').value =
            e.target.dataset.reply;
    }

});
</script>

@endsection