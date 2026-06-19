@extends('admin.layouts.header')
@section('title', "All Enquiries")
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
    <form method="GET" action="{{ url('admin/enquiries') }}" class="row g-2 mt-3">
                <!-- Email -->
                <div class="col-md-2">
                    <input type="text" name="email" class="form-control" 
                        placeholder="Search Email" 
                        value="{{ request('email') }}">
                </div>

        <!-- Status -->
        <div class="col-md-2">
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="new" {{ request('status')=='new' ? 'selected' : '' }}>New</option>
                <option value="contacted" {{ request('status')=='contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="converted" {{ request('status')=='converted' ? 'selected' : '' }}>Converted</option>
                <option value="not_interested" {{ request('status')=='not_interested' ? 'selected' : '' }}>Not Interested</option>
            </select>
        </div>

        <!-- Agent -->
        <div class="col-md-2">
            <select name="agent" class="form-control">
                <option value="">All Agents</option>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ request('agent')==$agent->id ? 'selected' : '' }}>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- From Date -->
        <div class="col-md-2">
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>

        <!-- To Date -->
        <div class="col-md-2">
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>


        <!-- Buttons -->
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-primary w-100">Filter</button>
            <a href="{{ url('admin/enquiries') }}" class="btn btn-secondary w-100">Reset</a>
        </div>

    </form>

</div>
    <div class="card overflow-hidden">
        <div class="card-body p-0 overflow-x-auto">
            <table id="studentTable" class="table table-striped">
                <thead>
                    <tr>
                        <th class="fixed-width"><div class="form-check"><input class="form-check-input" type="checkbox" id="selectAll"></div></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email ID</th>
                        <th>Usage type </th>
                        <th>Designation</th>
                        <th>country</th>
                        <th>Mobile No.</th>
                        <th>Page</th>
                        <!-- <th>Message</th> -->
                        <th>Date</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="user_table_body">
                    @foreach($enquiries as $enquiry)
                   <tr class="{{ $enquiry->status == 'new' ? 'new-lead-row' : '' }}">
                        <td class="fixed-width"><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->id }}</span></td>
                       <td>
                            <a href="{{ route('enquiry.show', $enquiry->id) }}"
                        class="lead-name-link">

                            {{ $enquiry->name }}

                        </a>
                        </td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->email }}</span></td>
                        <td>
                            @if($enquiry->usage_type == 'office')
                                <span class="badge bg-success">Office</span>
                            @else
                                <span class="badge bg-secondary">Personal</span>
                            @endif
                        </td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->job_title }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->country_name }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->contact }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->page_name }}</span></td>
                        <!-- <td><span class="fw-medium text-gray-300">{{ $enquiry->message }}</span></td> -->
                        <!-- <td>
                                    <a href="{{ $enquiry->page_url }}" target="_blank" class="fw-medium text-primary">
                                {{ Str::limit($enquiry->page_url, 50) }}
                            </a>
                        </td> -->
                        <td>
                            <span class="fw-medium text-gray-300">
                                {{ \Carbon\Carbon::parse($enquiry->created_at)->format('d M, Y ') }}
                            </span>
                        </td>
                        <td>
    @if($enquiry->status == 'new')
        <span class="badge new-status-blink">NEW</span>
    @elseif($enquiry->status == 'contacted')
        <span class="badge bg-warning">Contacted</span>
    @elseif($enquiry->status == 'converted')
        <span class="badge bg-success">Converted</span>
    @else
        <span class="badge bg-secondary">Not Interested</span>
    @endif
</td>
                        <td>
                            @if($enquiry->assigned_to)
                                <span class="badge bg-success">
                                    {{ $enquiry->agent_name ?? 'Assigned' }}
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Unassigned
                                </span>
                            @endif
                        </td>
                        <td>
                            <!-- View Button -->
                           <a href="{{ route('enquiry.view', $enquiry->id) }}"
   class="btn btn-info btn-xs">
    <i class="far fa-eye"></i>
</a>

                            <!-- Delete Button -->
                            <form action="{{ route('enquiries.destroy', $enquiry->id) }}" 
                                method="POST" 
                                style="display:inline-block;" 
                                onsubmit="return confirm('Are you sure you want to delete this enquiry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $enquiries->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>    
    
</div>
<div class="simple-summary mt-4">

    <div class="summary-title">📊 Summary</div>

    <div class="summary-line">
        <span>Total Leads</span>
        <b>{{ $totalLeads }}</b>
    </div>

    <div class="summary-line">
        <span>This Month</span>
        <b>{{ $thisMonth }}</b>
    </div>

    <div class="summary-line">
        <span>Today</span>
        <b>{{ $todayLeads }}</b>
    </div>

</div>
<style>
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
```html
<div class="modal fade" id="ViewEnquiry" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content crm-card">

            <!-- HEADER -->
            <div class="crm-header d-flex justify-content-between align-items-start">

                <div>

                    <h4 class="mb-2">
                        Lead Details
                    </h4>

                    <div class="crm-page-box">

                        <small class="text-muted d-block mb-1">
                            Landing Page
                        </small>

                        <span id="modal_page_name"></span>

                    </div>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <!-- BODY -->
            <div class="modal-body crm-body">

                <form class="user" id="addUser" method="post">

                    @csrf

                    <input type="hidden"
                           id="modal_enquiry_id"
                           name="id">

                    <div class="row g-4">

                        <!-- NAME -->
                        <div class="col-md-4">

                            <label class="crm-label">
                                Full Name
                            </label>

                            <input type="text"
                                   class="form-control crm-input"
                                   id="modal_name"
                                   readonly>

                        </div>

                        <!-- EMAIL -->
                        <div class="col-md-4">

                            <label class="crm-label">
                                Email Address
                            </label>

                            <input type="email"
                                   class="form-control crm-input"
                                   id="modal_email"
                                   readonly>

                        </div>

                        <!-- MOBILE -->
                        <div class="col-md-4">

                            <label class="crm-label">
                                Mobile Number
                            </label>

                            <input type="tel"
                                   class="form-control crm-input"
                                   id="modal_contact"
                                   readonly>

                        </div>

                        <!-- JOB TITLE -->
                        <div class="col-md-4">

                            <label class="crm-label">
                                Job Title
                            </label>

                            <input type="text"
                                   class="form-control crm-input"
                                   id="modal_job_title"
                                   name="job_title">

                        </div>

                        <!-- COUNTRY -->
                        <div class="col-md-4">

                            <label class="crm-label">
                                Country
                            </label>

                            <input type="text"
                                   class="form-control crm-input"
                                   id="modal_country"
                                   readonly>

                        </div>

                        <!-- STATUS -->
                        <div class="col-md-4">

                            <label class="crm-label">
                                Lead Status
                            </label>

                            <select name="status"
                                    id="modal_status"
                                    class="form-select crm-input">

                                <option value="new">New</option>
                                <option value="contacted">Contacted</option>
                                <option value="not_interested">Not Interested</option>
                                <option value="converted">Converted</option>

                            </select>

                        </div>

                        <!-- ASSIGN -->
                        @if(
                            session('role_id') != config('constants.roles.agent') ||
                            session('can_assign_leads') == 1
                        )

                        <div class="col-md-4">

                            <label class="crm-label">
                                Assign To Agent
                            </label>

                            <select name="assigned_to"
                                    id="modal_assigned_to"
                                    class="form-select crm-input">

                                <option value="">
                                    Select Agent
                                </option>

                                @foreach($agents as $agent)

                                    <option value="{{ $agent->id }}">
                                        {{ $agent->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        @endif

                        <!-- LEAD TYPE -->
                        <div class="col-md-4"
                             id="leadTypeField"
                             style="display:none;">

                            <label class="crm-label">
                                Lead Type
                            </label>

                            <select name="lead_type"
                                    id="modal_lead_type"
                                    class="form-select crm-input">

                                <option value="">Select</option>
                                <option value="hot">Hot</option>
                                <option value="warm">Warm</option>
                                <option value="cold">Cold</option>

                            </select>

                        </div>

                        <!-- FOLLOWUP -->
                        <div class="col-md-4">

                            <label class="crm-label">
                                Follow-up Date
                            </label>

                            <input type="datetime-local"
                                   name="followup_date"
                                   id="modal_followup"
                                   class="form-control crm-input">

                        </div>

                        <!-- AMOUNT -->
                        <div class="col-md-4"
                             id="amountField"
                             style="display:none;">

                            <label class="crm-label">
                                Converted Amount
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="converted_amount"
                                   id="modal_amount"
                                   class="form-control crm-input">

                        </div>

                        <!-- MESSAGE -->
                        <div class="col-12">

                            <label class="crm-label">
                                Client Message
                            </label>

                            <textarea class="form-control crm-textarea"
                                      id="modal_message"
                                      rows="3"
                                      readonly></textarea>

                        </div>

                        <!-- REMARK -->
                        <div class="col-12">

                            <label class="crm-label">
                                Internal Remark
                            </label>

                            <textarea name="remark"
                                      id="modal_remark"
                                      class="form-control crm-textarea"
                                      rows="3"></textarea>

                        </div>

                    </div>

                    <!-- BUTTONS -->
                    <div class="d-flex justify-content-between align-items-center mt-4">

                        <a href="#"
                           id="exportLeadBtn"
                           class="btn crm-export-btn">

                            Export Excel

                        </a>

                        <button type="submit"
                                class="btn crm-save-btn">

                            Update Lead

                        </button>

                    </div>

                </form>

                <!-- FOLLOWUP HISTORY -->
                <div class="crm-history-wrapper">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h6 class="mb-0 fw-bold">
                            Follow-up History
                        </h6>

                        <span class="crm-badge">
                            Timeline
                        </span>

                    </div>

                    <div id="followHistoryBox"
                         class="crm-history-box">

                        Loading...

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.modal-dialog{
    max-width: 950px;
}

.crm-card{
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 35px rgba(0,0,0,0.12);
}

.crm-header{
    background: #ffffff;
    padding: 18px 22px;
    border-bottom: 1px solid #eaecf0;
}

.crm-header h4{
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}

.crm-page-box{
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 10px 14px;
    width: fit-content;
}

.crm-page-box span{
    font-size: 13px;
    color: #344054;
    font-weight: 500;
}

.crm-body{
    background: #f9fafb;
    padding: 22px;
}

.crm-label{
    font-size: 13px;
    font-weight: 600;
    color: #344054;
    margin-bottom: 6px;
    display: block;
}

.crm-input{
    height: 44px;
    border-radius: 10px;
    border: 1px solid #d0d5dd;
    background: #fff;
    font-size: 14px;
    box-shadow: none !important;
}

.crm-input:focus{
    border-color: #2563eb;
}

.crm-textarea{
    border-radius: 10px;
    border: 1px solid #d0d5dd;
    padding: 12px;
    font-size: 14px;
    background: #fff;
    box-shadow: none !important;
}

.crm-save-btn{
    background: #2563eb;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-size: 14px;
    font-weight: 600;
}

.crm-export-btn{
    background: #16a34a;
    color: #fff;
    border-radius: 10px;
    padding: 10px 18px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.crm-history-wrapper{
    margin-top: 25px;
    background: #fff;
    border-radius: 14px;
    padding: 18px;
    border: 1px solid #eaecf0;
}

.crm-history-box{
    max-height: 180px;
    overflow-y: auto;
}

.crm-badge{
    background: #eff6ff;
    color: #2563eb;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.form-control[readonly]{
    background: #f9fafb;
}

.row.g-4{
    --bs-gutter-y: 1rem;
}

.crm-save-btn:hover{
    background:#1d4ed8;
    color:#fff;
}

.crm-export-btn:hover{
    background:#15803d;
    color:#fff;
}

</style>
```



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
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

$('#addUser').off('submit').on('submit', function(e) {
    e.preventDefault();
    e.stopPropagation(); // ✅ important

    $.ajax({
        url: "{{ route('enquiry.update') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(res) {
            alert('Updated successfully');
            location.reload();
        },
        error: function(err) {
            console.log(err.responseText);
            alert('Error: ' + err.responseText);
        }
    });

    return false; // ✅ extra safety
});
</script>
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