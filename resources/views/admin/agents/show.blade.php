@extends('admin.layouts.header')
@section('title', $agent->name . ' — Agent Detail')

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="breadcrumb mb-0">
                <ul class="flex-align gap-4 mb-0">
                    <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                    <li><span class="text-gray-500 d-flex"><i class="ph ph-caret-right"></i></span></li>
                    <li><a href="{{ route('agents.index') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Agents</a></li>
                    <li><span class="text-gray-500 d-flex"><i class="ph ph-caret-right"></i></span></li>
                    <li><span class="text-main-600 fw-normal text-15">{{ $agent->name }}</span></li>
                </ul>
            </div>

            <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-warning">
                <i class="far fa-edit"></i> Edit Agent
            </a>
        </div>
    </div>

    <!-- Agent summary card -->
    <div class="card mb-24">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <small class="text-muted d-block">Name</small>
                    <span class="fw-medium">{{ $agent->name }}</span>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Email</small>
                    <span class="fw-medium">{{ $agent->email_id }}</span>
                </div>
                <div class="col-md-2">
                    <small class="text-muted d-block">Mobile</small>
                    <span class="fw-medium">{{ $agent->mobile_no ?? '-' }}</span>
                </div>
                <div class="col-md-2">
                    <small class="text-muted d-block">Total Leads</small>
                    <span class="fw-medium">{{ $totalLeads }}</span>
                </div>
                <div class="col-md-2">
                    <small class="text-muted d-block">Converted</small>
                    <span class="fw-medium">{{ $convertedLeads }}</span>
                </div>
                <div class="col-12">
                    <small class="text-muted d-block">Regions Covered</small>
                    <span class="fw-medium">{{ $regionNames->implode(', ') ?: '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('agents.show', $agent->id) }}" class="mb-24">
        <div class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="new" {{ request('status')=='new' ? 'selected' : '' }}>New</option>
                    <option value="contacted" {{ request('status')=='contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="converted" {{ request('status')=='converted' ? 'selected' : '' }}>Converted</option>
                    <option value="not_interested" {{ request('status')=='not_interested' ? 'selected' : '' }}>Not Interested</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">From</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">To</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100">Filter</button>
                <a href="{{ route('agents.show', $agent->id) }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </div>
    </form>

    <!-- Leads under this agent -->
    <div class="card overflow-hidden">
        <div class="card-body p-0 overflow-x-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Mobile No.</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr class="{{ $lead->status == 'new' ? 'new-lead-row' : '' }}">
                        <td><span class="fw-medium text-gray-300">{{ $lead->id }}</span></td>
                        <td>
                            <a href="{{ route('enquiry.show', $lead->id) }}" class="lead-name-link">
                                {{ $lead->name }}
                            </a>
                        </td>
                        <td><span class="fw-medium text-gray-300">{{ $lead->email }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $lead->country_name }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ $lead->contact }}</span></td>
                        <td><span class="fw-medium text-gray-300">{{ \Carbon\Carbon::parse($lead->created_at)->format('d M, Y') }}</span></td>
                        <td>
                            @if($lead->status == 'new')
                                <span class="badge new-status-blink">NEW</span>
                            @elseif($lead->status == 'contacted')
                                <span class="badge bg-warning">Contacted</span>
                            @elseif($lead->status == 'converted')
                                <span class="badge bg-success">Converted</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($lead->status ?? '-') }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('enquiry.view', $lead->id) }}" class="btn btn-info btn-xs">
                                <i class="far fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No leads assigned to this agent yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($leads->hasPages())
            <div class="card-body">
                {{ $leads->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.new-lead-row { background-color: #fff3cd !important; }
.new-status-blink { background: red; color: white; padding: 6px 10px; border-radius: 5px; }
</style>
@endsection
