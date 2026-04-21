@extends('admin.layouts.header')
@section('title', "All Enquiries")

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
                        <th>country</th>
                        <th>Mobile No.</th>
                        <th>Page</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Assigned To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="user_table_body">
                    @foreach($enquiries as $enquiry)
                    <tr>
                        <td class="fixed-width"><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->id }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->name }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->email }}</span></td>
                        <td>
                            @if($enquiry->usage_type == 'office')
                                <span class="badge bg-success">Office</span>
                            @else
                                <span class="badge bg-secondary">Personal</span>
                            @endif
                        </td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->country_name }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->contact }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->page_name }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->message }}</span></td>
                        <!-- <td>
                                    <a href="{{ $enquiry->page_url }}" target="_blank" class="fw-medium text-primary">
                                {{ Str::limit($enquiry->page_url, 50) }}
                            </a>
                        </td> -->
                        <td>
                            <span class="fw-medium text-gray-300">
                                {{ \Carbon\Carbon::parse($enquiry->created_at)->format('d M, Y H:i') }}
                            </span>
                        </td>
                        <td>
                            @if($enquiry->assigned_to)
                                <span class="badge bg-success">
                                    {{ $enquiry->agent_name }}
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Unassigned
                                </span>
                            @endif
                        </td>
                        <td>
                            <!-- View Button -->
                            <button class="btn btn-info btn-xs view-enquiry-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#ViewEnquiry" 
                                    data-enquiry='@json($enquiry)'>
                                <i class="far fa-eye"></i>
                            </button>

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
</style>

<!-- Enquiry Modal -->
<div class="modal fade" id="ViewEnquiry" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enquiry Details</h5>
                <div style="
    background:#eef4ff;
    padding:10px 15px;
    border-radius:8px;
    margin-top:10px;
    margin-bottom:10px;
    border-left:4px solid #3b82f6;
    margin-left: 50px;
">
    
    <span id="modal_page_name" style="font-weight:500;"></span>
</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body mb-10">
                <form class="user" id="addUser" method="post">
                    @csrf
                    <input type="hidden" id="modal_enquiry_id" name="id">

                    <div class="row">

                        <!-- Readonly Fields -->
                        <div class="form-group col-md-4">
                            <label>Name:</label>
                            <input type="text" class="form-control" id="modal_name" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Email:</label>
                            <input type="email" class="form-control" id="modal_email" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Mobile:</label>
                            <input type="tel" class="form-control" id="modal_contact" readonly>
                        </div>
                                            <div class="form-group col-md-4">
                        <label>Country:</label>
                        <input type="text" class="form-control" id="modal_country" readonly>
                    </div>

                        <div class="form-group col-12">
                            <label>Message:</label>
                            <textarea class="form-control" id="modal_message" rows="3" readonly></textarea>
                        </div>
                      @if(session('role_id') != config('constants.roles.agent'))
                        <div class="form-group col-md-4">
                            <label>Assign To (Agent)</label>
                            <select name="assigned_to" id="modal_assigned_to" class="form-control">
                                <option value="">Select Agent</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                        <!-- ✅ NEW CRM FIELDS -->

                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <select name="status" id="modal_status" class="form-control">
                                <option value="new">New</option>
                                <option value="contacted">Contacted</option>
                                <option value="not_interested">Not Interested</option>
                                <option value="converted">Converted</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4" id="leadTypeField" style="display:none;">
                        <label>Lead Type</label>
                        <select name="lead_type" id="modal_lead_type" class="form-control">
                            <option value="">Select</option>
                            <option value="hot">Hot</option>
                            <option value="warm">Warm</option>
                            <option value="cold">Cold</option>
                        </select>
                    </div>

                        <div class="form-group col-md-4">
                            <label>Follow-up Date</label>
                            <input type="datetime-local" name="followup_date" id="modal_followup" class="form-control">
                        </div>

                        <div class="form-group col-md-4" id="amountField" style="display:none;">
                            <label>Converted Amount</label>
                            <input type="number" step="0.01" name="converted_amount" id="modal_amount" class="form-control">
                        </div>

                        <div class="form-group col-12">
                            <label>Remark</label>
                            <textarea name="remark" id="modal_remark" class="form-control"></textarea>
                        </div>

                    </div>

                    <!-- Submit button -->
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">Update Lead</button>
                    </div>

                </form>
            </div>
              <hr>
    <h6>📜 Follow-up History</h6>
    <div id="followHistoryBox" style="max-height:200px; overflow-y:auto; background:#f8f9fb; padding:10px;">
        Loading...
    </div>
        </div>
    </div>
    
</div>


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
document.addEventListener('DOMContentLoaded', function() {
    const exportSelect = document.getElementById('exportOptions');
    exportSelect.addEventListener('change', function() {
        const type = this.value;
        if (type) {
            window.location.href = `/admin/enquiries/export/${type}`;
            this.selectedIndex = 0; // Reset dropdown after click
        }
    });
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