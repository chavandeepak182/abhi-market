@extends('admin.layouts.header')
@section('title', "All Enquiries")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
                <li><span class="text-main-600 fw-normal text-15">All Enquiries</span></li>
            </ul>
        </div>

        <!-- Export Option -->
        <div class="flex-align gap-8 flex-wrap">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="flex-align text-gray-500 text-13 border border-gray-100 rounded-4 ps-20 focus-border-main-600 bg-white">
                <span class="text-lg"><i class="ph ph-layout"></i></span>
                <select class="form-control ps-8 pe-20 py-16 border-0 text-inherit rounded-4 text-center" id="exportOptions">
                    <option value="" selected disabled>Export</option>
                    <option value="csv">CSV</option>
                    <option value="json">JSON</option>
                </select>
            </div>
        </div>
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
                        <th>country</th>
                        <th>Mobile No.</th>
                        <th>Page</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="user_table_body">
                    @foreach($enquiries as $enquiry)
                    <tr>
                        <td class="fixed-width"><div class="form-check"><input class="form-check-input" type="checkbox"></div></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->enquiry_id }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->name }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->email }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->country_name }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->contact }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $enquiry->page_name }}</span></td>
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
                            <!-- View Button -->
                            <button class="btn btn-info btn-xs view-enquiry-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#ViewEnquiry" 
                                    data-enquiry='@json($enquiry)'>
                                <i class="far fa-eye"></i>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('enquiries.destroy', $enquiry->enquiry_id) }}" 
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
    </div>    
</div>

<!-- Enquiry Modal -->
<div class="modal fade" id="ViewEnquiry" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enquiry Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body mb-10">
                <form class="user" id="addUser" method="post">
                    @csrf
                    <input type="hidden" id="modal_enquiry_id" name="enquiry_id">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="modal_name" name="name" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Email ID:</label>
                            <input type="email" class="form-control" id="modal_email" name="email" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Mobile Number:</label>
                            <input type="tel" class="form-control" id="modal_contact" name="contact" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Mobile Number:</label>
                            <input type="tel" class="form-control" id="modal_contact" name="contact" readonly>
                        </div>
                        <div class="form-group col-12">
                            <label class="col-form-label">Message:</label>
                            <textarea class="form-control" id="modal_message" name="message" rows="5" readonly></textarea>
                        </div>
                    </div>
                </form>
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
                const enquiry = JSON.parse(this.getAttribute('data-enquiry'));

                document.getElementById('modal_enquiry_id').value = enquiry.enquiry_id || '';
                document.getElementById('modal_name').value = enquiry.name || '';
                document.getElementById('modal_email').value = enquiry.email || '';
                document.getElementById('modal_contact').value = enquiry.contact || '';
                document.getElementById('modal_message').value = enquiry.message || '';
            });
        });
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
@endsection