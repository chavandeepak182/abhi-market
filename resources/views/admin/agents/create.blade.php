@extends('admin.layouts.header')
@section('title', "Add Agent")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24">
        <div class="breadcrumb mb-0">
            <ul class="flex-align gap-4 mb-0">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li><span class="text-gray-500 d-flex"><i class="ph ph-caret-right"></i></span></li>
                <li><a href="{{ route('agents.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Agents</a></li>
                <li><span class="text-gray-500 d-flex"><i class="ph ph-caret-right"></i></span></li>
                <li><span class="text-main-600 fw-normal text-15">Add Agent</span></li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('agents.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email_id" class="form-control" value="{{ old('email_id') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" name="mobile_no" class="form-control" value="{{ old('mobile_no') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">App Password</label>
                        <div style="position:relative;">
                            <input type="password" id="app_password" name="app_password" class="form-control"
                                value="{{ old('app_password') }}" autocomplete="new-password"
                                style="padding-right:44px;" required minlength="6">
                            <button type="button"
                                onclick="
                                    const f = document.getElementById('app_password');
                                    f.type = f.type === 'password' ? 'text' : 'password';
                                    this.textContent = f.type === 'password' ? 'View' : 'Hide';
                                "
                                style="position:absolute;right:6px;top:50%;transform:translateY(-50%);border:none;background:none;color:#2563eb;font-size:13px;cursor:pointer;padding:4px 6px;">
                                View
                            </button>
                        </div>
                        <small class="text-muted">Gmail App Password for this agent's email account (used to send/receive mail as this agent). You can paste it exactly as Gmail shows it, spaces and all - they're stripped out automatically.</small>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="can_assign_leads" value="1" id="can_assign_leads" {{ old('can_assign_leads') ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_assign_leads">
                                Team Lead (can assign leads to other agents)
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Timezone Regions Covered</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($regions as $region)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="regions[]" value="{{ $region->id }}" id="region-{{ $region->id }}"
                                        {{ collect(old('regions'))->contains($region->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="region-{{ $region->id }}">
                                        {{ $region->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">New enquiries from these timezones will be auto-assigned to this agent.</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Create Agent</button>
                    <a href="{{ route('agents.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
