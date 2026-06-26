@extends('admin.layouts.header')
@section('title', "New Leads")
<style>/* NEW lead highlight */
.new-lead-row {
    background-color: #fff3cd !important;
    animation: blinkRow 1s infinite;
}

/* NEW badge */
.new-status-blink {
    background: red;
    color: white;
    padding: 6px 10px;
    border-radius: 5px;
    animation: blinkText 1s infinite;
}
.table-striped > tbody > tr:nth-of-type(odd) > * {
    background-color: #ffffff !important;
    --bs-table-bg-type: #ffffff !important;
}

/* Row blinking */
@keyframes blinkRow {
    0% {
        background-color: #fff3cd;
    }
    50% {
        background-color: #ffe08a;
    }
    100% {
        background-color: #fff3cd;
    }
}

/* Badge blinking */
@keyframes blinkText {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.3;
    }
    100% {
        opacity: 1;
    }
}</style>
@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24">

    <!-- TOP ROW -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

        <!-- Breadcrumb -->
        <div class="breadcrumb mb-0">
            <ul class="flex-align gap-4 mb-0">
                <li>
                    <a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">
                        Dashboard
                    </a>
                </li>
                <li>
                    <span class="text-gray-500 d-flex">
                        <i class="ph ph-caret-right"></i>
                    </span>
                </li>
                <li>
                    <span class="text-main-600 fw-normal text-15">
                        All Enquiries
                    </span>
                </li>
            </ul>
        </div>

        <!-- Right Side (Export + Message) -->
        <div class="d-flex align-items-center gap-2 flex-wrap">

            @if (session('status'))
                <div class="alert alert-success mb-0 py-2 px-3">
                    {{ session('status') }}
                </div>
            @endif

            <select class="form-control" id="exportOptions" style="width:120px;">
                <option value="" selected disabled>Export</option>
                <option value="csv">CSV</option>
                <option value="json">JSON</option>
            </select>

        </div>

    </div>

    <!-- FILTER ROW -->
   <form method="GET" action="{{ route('agent.new.leads') }}">
    <div class="row align-items-end g-3">

        <div class="col-md-2">
            <label class="form-label">Email</label>
            <input type="text"
                   name="email"
                   class="form-control"
                   placeholder="Search Email"
                   value="{{ request('email') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="new" {{ request('status')=='new' ? 'selected' : '' }}>New</option>
                <option value="contacted" {{ request('status')=='contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="converted" {{ request('status')=='converted' ? 'selected' : '' }}>Converted</option>
                <option value="not_interested" {{ request('status')=='not_interested' ? 'selected' : '' }}>Not Interested</option>
                <option value="unassigned" {{ request('status')=='unassigned' ? 'selected' : '' }}>Unassigned</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Agent</label>
            <select name="agent" class="form-control">
                <option value="">All Agents</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}"
                        {{ request('agent') == $agent->id ? 'selected' : '' }}>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">From</label>
            <input type="date"
                   name="from_date"
                   class="form-control"
                   value="{{ request('from_date') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label">To</label>
            <input type="date"
                   name="to_date"
                   class="form-control"
                   value="{{ request('to_date') }}">
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-primary w-100">Filter</button>
            <a href="{{ url('/agent/new-leads') }}" class="btn btn-secondary w-100">Reset</a>
        </div>

    </div>
</form>

</div>
   

<div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <h4 class="mb-4">Today's Leads</h4>
            <div class="table-responsive">


           <table class="table align-middle mb-0">

              <thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email ID</th>
    <th>Usage Type</th>
    <th>Designation</th>
    <th>Country</th>
    <th>Mobile No.</th>
    <th>Page</th>
    <th>Date</th>
    <th>Status</th>
    <th>Assigned To</th>
    <th>Action</th>
</tr>
</thead>

                <tbody style="backgraound-color:grey;">

@forelse($leads as $lead)

<tr class="{{ $lead->status == 'new' ? 'new-lead-row' : '' }}">

    <td>{{ $lead->id }}</td>

    <td>
        <a href="{{ route('enquiry.show', $lead->id) }}" class="lead-name-link">
            {{ $lead->name }}
        </a>
    </td>

    <td>{{ $lead->email }}</td>

    <td>
        @if($lead->usage_type == 'office')
            <span class="badge bg-success">Office</span>
        @else
            <span class="badge bg-secondary">Personal</span>
        @endif
    </td>

    <td>{{ $lead->job_title }}</td>

    <td>{{ $lead->country_name ?? '-' }}</td>

    <td>{{ $lead->contact }}</td>

    <td>{{ $lead->page_name ?? '-' }}</td>

    <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('d M, Y') }}</td>

    <td>
        @if($lead->status=='new')
            <span class="badge new-status-blink">NEW</span>
        @elseif($lead->status=='contacted')
            <span class="badge bg-warning">Contacted</span>
        @elseif($lead->status=='converted')
            <span class="badge bg-success">Converted</span>
        @else
            <span class="badge bg-secondary">Not Interested</span>
        @endif
    </td>

    <td>
        @if(empty($lead->assigned_to))

            @if(session('role_id') != config('constants.roles.agent') || session('can_assign_leads') == 1)

                <select class="form-select assign-agent" data-id="{{ $lead->id }}">
                    <option value="">Select Agent</option>

                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">
                            {{ $agent->name }}
                        </option>
                    @endforeach
                </select>

            @else

                <span class="badge bg-secondary">
                    Not Assigned
                </span>

            @endif

        @else

            <span class="badge bg-success">
                {{ $lead->agent_name }}
            </span>

        @endif
    </td>

    <td>
        <a href="{{ route('enquiry.view', $lead->id) }}"
           class="btn btn-info btn-xs">
            <i class="far fa-eye"></i>
        </a>
    </td>

</tr>

@empty

<tr>
    <td colspan="12" class="text-center">
        No Leads Found Today
    </td>
</tr>

@endforelse

</tbody>

            </table>
</div>
            <div class="card-footer">
    <div class="d-flex justify-content-center">
        {{ $leads->onEachSide(1)->links() }}
    </div>
</div>

        </div>

    </div>

</div>


<script>

</script>
<style>

    /* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.pagination .page-item {
    margin: 0;
}

.pagination .page-link {
    min-width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background: #fff;
    color: #0d6efd;
    font-weight: 600;
    text-decoration: none;
    transition: all .3s ease;
}

.pagination .page-link:hover {
    background: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}

.pagination .page-item.active .page-link,
.pagination .page-link.active {
    background: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}

.pagination .page-item.disabled .page-link {
    color: #999;
    background: #f8f9fa;
    border-color: #dee2e6;
    cursor: not-allowed;
}
.simple-summary {
    max-width: 350px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-left: 445px;
    margin-bottom: 30px;
}

.summary-title {
    font-weight: 600;
    margin-bottom: 10px;
    border-bottom: 1px dashed #ccc;
    padding-bottom: 5px;
}

.summary-line {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 14px;
}

.lead-name-link {
    color: #344054;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s ease;
}

.lead-name-link:hover {
    color: #0d6efd;
    text-decoration: none;
}




</style>

<!-- Enquiry Modal -->






<!-- JavaScript for Populating Modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const viewButtons = document.querySelectorAll('.view-enquiry-btn');

    viewButtons.forEach(button => {
       button.addEventListener('click', function () {

    const enquiry = JSON.parse(this.getAttribute('data-enquiry')); // ✅ ADD THIS
    document.getElementById('modal_country').value = enquiry.country_name || '-';

    document.getElementById('modal_page_name').innerText = enquiry.page_name || '-';

            // Basic fields
            document.getElementById('modal_enquiry_id').value = enquiry.id || '';
if (document.getElementById('modal_assigned_to')) {
    document.getElementById('modal_assigned_to').value = enquiry.assigned_to || '';
}            document.getElementById('modal_name').value = enquiry.name || '';
            document.getElementById('modal_email').value = enquiry.email || '';
            document.getElementById('modal_contact').value = enquiry.contact || '';
            document.getElementById('modal_job_title').value = enquiry.job_title || '';
            document.getElementById('modal_message').value = enquiry.message || '';

            // CRM fields
            document.getElementById('modal_status').value = enquiry.status || 'new';

            // Fix datetime format for input
            if (enquiry.followup_date) {
                document.getElementById('modal_followup').value = enquiry.followup_date.replace(' ', 'T');
            } else {
                document.getElementById('modal_followup').value = '';
            }

            document.getElementById('modal_remark').value = enquiry.remark || '';
            document.getElementById('modal_amount').value = enquiry.converted_amount || '';

            // Show/Hide amount
            toggleFields(enquiry.status);
              // ✅ ADD THIS EXACTLY HERE
        fetch('/get-followups/' + enquiry.id)
        .then(res => res.text())
        .then(data => {
            document.getElementById('followHistoryBox').innerHTML = data;
        });
        });
    });

    // Status change handler (ONLY ONCE)
 document.getElementById('modal_status').addEventListener('change', function () {
    toggleFields(this.value);
});
   function toggleFields(status) {
    const amountField = document.getElementById('amountField');
    const leadTypeField = document.getElementById('leadTypeField');

    // Converted → show amount
    if (status === 'converted') {
        amountField.style.display = 'block';
    } else {
        amountField.style.display = 'none';
        document.getElementById('modal_amount').value = '';
    }

    // Contacted → show Hot/Warm/Cold
    if (status === 'contacted') {
        leadTypeField.style.display = 'block';
    } else {
        leadTypeField.style.display = 'none';
        document.getElementById('modal_lead_type').value = '';
    }
}
});
</script>

<!-- ✅ AJAX -->

<script>
document.getElementById('exportOptions').addEventListener('change', function () {

    let type = this.value;

    // Current filters from URL
    let params = new URLSearchParams(window.location.search);

    // Redirect with filters
    window.location.href =
        "{{ url('admin/enquiries/export') }}/" + type + "?" + params.toString();
});
</script>
<script>
document.getElementById('modal_status').addEventListener('change', function () {
    let amountField = document.getElementById('amountField');

    if (this.value === 'converted') {
        amountField.style.display = 'block';
    } else {
        amountField.style.display = 'none';
    }
});
</script>

@endsection