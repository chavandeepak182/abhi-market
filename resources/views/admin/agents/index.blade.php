@extends('admin.layouts.header')
@section('title', "Agents")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div class="breadcrumb mb-0">
                <ul class="flex-align gap-4 mb-0">
                    <li>
                        <a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <span class="text-gray-500 d-flex"><i class="ph ph-caret-right"></i></span>
                    </li>
                    <li>
                        <span class="text-main-600 fw-normal text-15">Agents</span>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                @if (session('success'))
                    <div class="alert alert-success mb-0 py-2 px-3">{{ session('success') }}</div>
                @endif

                <a href="{{ route('agent.regions') }}" class="btn btn-outline-primary">
                    <i class="ph ph-map-pin"></i> Region Assignment
                </a>

                <a href="{{ route('agents.create') }}" class="btn btn-primary">
                    <i class="ph ph-plus"></i> Add Agent
                </a>
            </div>

        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="card-body p-0 overflow-x-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Regions</th>
                        <th>Total Leads</th>
                        <th>Team Lead?</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agents as $agent)
                    <tr>
                        <td><span class="fw-medium text-gray-300">{{ $agent->id }}</span></td>
                        <td>
                            <a href="{{ route('agents.show', $agent->id) }}" class="lead-name-link">
                                {{ $agent->name }}
                            </a>
                        </td>
                        <td><span class="fw-medium text-gray-300">{{ $agent->email_id }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $agent->mobile_no ?? '-' }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $regionNames[$agent->id] ?? '-' }}</span></td>
                        <td>
                            <a href="{{ route('agents.show', $agent->id) }}" class="badge bg-info">
                                {{ $leadCounts[$agent->id] ?? 0 }}
                            </a>
                        </td>
                        <td>
                            @if($agent->can_assign_leads)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            @if(($agent->active ?? 1))
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('agents.show', $agent->id) }}" class="btn btn-info btn-xs">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-warning btn-xs">
                                <i class="far fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-secondary btn-xs"
                                    onclick="openResetPasswordModal({{ $agent->id }}, '{{ addslashes($agent->name) }}', '{{ route('agents.reset-password', $agent->id) }}')">
                                <i class="ph ph-key"></i>
                            </button>
                            <form action="{{ route('agents.toggle-status', $agent->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-xs {{ ($agent->active ?? 1) ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                                    {{ ($agent->active ?? 1) ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form action="{{ route('agents.destroy', $agent->id) }}" method="POST"
                                  style="display:inline-block;"
                                  onsubmit="return confirm('Remove this agent? Their existing leads stay assigned to them.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No agents yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="resetPasswordForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Set New Password <span id="resetPwAgentName"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" id="resetPwPassword" class="form-control" minlength="6" placeholder="At least 6 characters" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="resetPwConfirm" class="form-control" minlength="6" required>
                        </div>
                        <p class="text-danger d-none" id="resetPwError">Passwords do not match.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Set Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openResetPasswordModal(agentId, agentName, actionUrl) {
    document.getElementById('resetPasswordForm').action = actionUrl;
    document.getElementById('resetPwAgentName').textContent = '— ' + agentName;
    document.getElementById('resetPwPassword').value = '';
    document.getElementById('resetPwConfirm').value = '';
    document.getElementById('resetPwError').classList.add('d-none');
    new bootstrap.Modal(document.getElementById('resetPasswordModal')).show();
}

document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
    var pw = document.getElementById('resetPwPassword').value;
    var confirm = document.getElementById('resetPwConfirm').value;

    if (pw !== confirm) {
        e.preventDefault();
        document.getElementById('resetPwError').classList.remove('d-none');
    }
});
</script>
@endsection
