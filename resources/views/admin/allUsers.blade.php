@extends('admin.layouts.header')
@section('title', "User Management")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">All Users</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <button class="btn btn-primary" data-bs-toggle="modal" href="#addUserView">
                    <i class="fa fa-plus"></i> Add User
                </button>
            </div>
            <div class="flex-align text-gray-500 text-13 border border-gray-100 rounded-4 ps-20 focus-border-main-600 bg-white">
                <span class="text-lg"><i class="ph ph-layout"></i></span>
                <select class="form-control ps-8 pe-20 py-16 border-0 text-inherit rounded-4 text-center" id="exportOptions">
                    <option value="" selected disabled>Export</option>
                    <option value="csv">CSV</option>
                    <option value="json">JSON</option>
                </select>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>
    

    <div class="card overflow-hidden">
        <div class="card-body p-0 overflow-x-auto">
            <table id="studentTable" class="table table-striped">
                <thead>
                    <tr>
                        <th class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th class="h6 text-gray-300">Name</th>
                        <th class="h6 text-gray-300">Email ID</th>
                        <th class="h6 text-gray-300">Mobile No.</th>
                        <th class="h6 text-gray-300">Status</th>
                        <th class="h6 text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody id="user_table_body">
                    @foreach($data['allUsers'] as $user)
                    <tr>
                        <td class="fixed-width">
                            <div class="form-check">
                                <input class="form-check-input border-gray-200 rounded-4" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">{{ $user->name }}</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">{{ $user->email_id }}</span>
                        </td>
                        <td>
                            <span class="h6 mb-0 fw-medium text-gray-300">{{ $user->mobile_no }}</span>
                        </td>
                        <td>
                            <span class="status-toggle cursor-pointer text-13 py-2 px-8 
                                {{ $user->is_email_verify == 1 ? 'bg-success-50 text-success-600' : 'bg-warning-50 text-warning-600' }}
                                d-inline-flex align-items-center gap-8 rounded-pill"
                                data-user-id="{{ $user->id }}" 
                                data-status="{{ $user->is_email_verify }}">
                                
                                <span class="w-6 h-6 
                                    {{ $user->is_email_verify == 1 ? 'bg-success-600' : 'bg-warning-600' }} 
                                    rounded-circle flex-shrink-0">
                                </span> 
                                
                                {{ $user->is_email_verify == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a class="btn btn-warning btn-xs edit" title="Edit" href="{{ url('editUser/'.$user->id) }}">
                                <i class="far fa-edit"></i>
                            </a> 
                            <button class="btn btn-danger btn-xs delete" title="Delete" onclick="deleteUser('{{ $user->id }}')">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer flex-between flex-wrap">
            <span class="text-gray-900">Showing 1 to 10 of 12 entries</span>
            <ul class="pagination flex-align flex-wrap">
                <li class="page-item active">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">...</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">8</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">9</a>
                </li>
                <li class="page-item">
                    <a class="page-link h-44 w-44 flex-center text-15 rounded-8 fw-medium" href="#">10</a>
                </li>
            </ul>
        </div>
    </div>    
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="user" id="addUser" method="post">
                    @csrf   
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="recipient-name" class="col-form-label">Email ID:</label>
                            <input type="email" class="form-control" id="email_id" name="email_id" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="recipient-name" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="recipient-name" class="col-form-label">Mobile Number:</label>
                            <input type="tel" class="form-control" id="mobile_no" name="mobile_no" required>
                        </div>
                    </div> 

                    <div class="modal-footer mt-30">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".status-toggle").forEach(function (element) {
            element.addEventListener("click", function () {
                let userId = this.getAttribute("data-user-id");
                let currentStatus = this.getAttribute("data-status");
                let newStatus = currentStatus == "1" ? 0 : 1;
                let statusText = newStatus === 1 ? "activate" : "deactivate";

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to " + statusText + " this user?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, " + statusText + " it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/update-user-status/${userId}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ is_email_verify: newStatus })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Updated!", "User status has been updated.", "success");

                                // Update UI without reload
                                element.setAttribute("data-status", newStatus);
                                element.className = `status-toggle cursor-pointer text-13 py-2 px-8 
                                    ${newStatus === 1 ? "bg-success-50 text-success-600" : "bg-warning-50 text-warning-600"} 
                                    d-inline-flex align-items-center gap-8 rounded-pill`;
                                element.innerHTML = `<span class="w-6 h-6 ${newStatus === 1 ? "bg-success-600" : "bg-warning-600"} rounded-circle flex-shrink-0"></span> 
                                    ${newStatus === 1 ? "Active" : "Inactive"}`;
                            } else {
                                Swal.fire("Error!", "Something went wrong!", "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Error!", "Failed to update the status.", "error");
                        });
                    }
                });
            });
        });
    });
</script>
@endsection