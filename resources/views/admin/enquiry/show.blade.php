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

                        <select name="assigned_to"
                                class="form-control">

                            @foreach($agents as $agent)

                                <option value="{{ $agent->id }}"
                                    {{ $enquiry->assigned_to == $agent->id ? 'selected' : '' }}>

                                    {{ $agent->name }}

                                </option>

                            @endforeach

                        </select>

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

    <h5 class="mb-0">
        Followup Timeline
    </h5>

</div>

<div class="card-body">

    @foreach($followups as $index => $f)

        <div class="border-start border-primary ps-3 mb-4">

            <h6 class="fw-bold text-primary">
                {{ $index + 1 }} Followup
            </h6>

            <p class="mb-1">
                <strong>Date:</strong>
                {{ \Carbon\Carbon::parse($f->followup_date)->format('d M Y h:i A') }}
            </p>

            <p class="mb-1">
                <strong>Status:</strong>
                {{ ucfirst($f->status) }}
            </p>

            <div>
                <strong>Remark:</strong>
                {!! $f->remark !!}
            </div>

            @if(!empty($f->client_reply))
                <div class="mt-2">
                    <strong>Client Reply:</strong>
                    {!! $f->client_reply !!}
                </div>
            @endif

            <div class="mt-2">
                <button type="button"
                        class="btn btn-sm btn-warning edit-followup"
                        data-id="{{ $f->id }}"
                        data-date="{{ $f->followup_date ? \Carbon\Carbon::parse($f->followup_date)->format('Y-m-d\TH:i') : '' }}"
                        data-remark="{{ strip_tags($f->remark) }}"
                        data-reply="{{ $f->client_reply }}">
                    Edit
                </button>
            </div>

        </div>

    @endforeach

</div>
@if(isset($emails) && count($emails))

<div class="card mt-4">
    <div class="card-header">
        <h5>Email Conversation</h5>
    </div>

    <div class="card-body">

        @foreach($emails as $mail)

        <div class="border p-3 mb-3">

            <strong>
                {{ $mail->direction == 'incoming'
                    ? 'Customer Reply'
                    : 'Company Email' }}
            </strong>

            <br>

            Subject:
            {{ $mail->email_subject }}

            <hr>

            {!! $mail->email_body !!}

        </div>

        @endforeach

    </div>
</div>

@endif

</div>

@endif


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