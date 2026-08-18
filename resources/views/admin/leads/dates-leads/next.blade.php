@extends('admin.layouts.header')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leads.css') }}">
@endpush

@section('content')

<div class="crm-container">

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Scheduled Follow-Ups
            </h1>

            <p class="page-subtitle">
                Follow-ups planned for
                {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
            </p>

        </div>

    </div>

    <div class="summary-cards">

        <div class="summary-card">
            <span>Total Follow-Ups</span>
            <h3>{{ $scheduledFollowups->count() }}</h3>
        </div>

        <div class="summary-card hot-card">
            <span>Hot Leads</span>
            <h3>{{ $scheduledFollowups->where('lead_type','hot')->count() }}</h3>
        </div>

        <div class="summary-card warm-card">
            <span>Warm Leads</span>
            <h3>{{ $scheduledFollowups->where('lead_type','warm')->count() }}</h3>
        </div>

        <div class="summary-card cold-card">
            <span>Cold Leads</span>
            <h3>{{ $scheduledFollowups->where('lead_type','cold')->count() }}</h3>
        </div>

    </div>

    <div class="table-card">

        <div class="table-responsive">

            <table class="crm-table">

                <thead>

                    <tr>

                        <th>Lead ID</th>
                        <th>Lead</th>
                        <th>Company</th>
                        <th>Country</th>
                        <th>Timezone</th>
                        <th>Status</th>
                        <th>Lead Type</th>
                        <th>Follow-Up Count</th>
                        <th>Assigned Agent</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($scheduledFollowups as $lead)

                        <tr>

                            <td>
                                <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span>
                            </td>

                            <td>

                                <div class="lead-name">

                                    <a href="{{ route('leads.show',$lead->id) }}"
                                       class="lead-link">

                                        {{ $lead->name }}

                                    </a>

                                </div>

                                <div class="lead-email">

                                    {{ $lead->email }}

                                </div>

                            </td>

                            <td>{{ $lead->company }}</td>

                            <td>{{ $lead->country }}</td>

                            <td>{{ $lead->timezone }}</td>

                            <td>

                                <span class="badge status-{{ $lead->status }}">
                                    {{ ucfirst(str_replace('_',' ',$lead->status)) }}
                                </span>

                            </td>

                            <td>

                                <span class="badge type-{{ $lead->lead_type }}">
                                    {{ ucfirst($lead->lead_type) }}
                                </span>

                            </td>

                            <td>

                                {{ $lead->followup_count }}/6

                            </td>

                            <td>

                                {{ $lead->user?->name ?? 'Not Assigned' }}

                                @if($lead->user?->agent_id)
                                    <div class="agent-id-badge">{{ $lead->user->agent_id }}</div>
                                @endif

                            </td>

                            <td>

                                <a href="{{ route('leads.show',$lead->id) }}"
                                   class="btn-view">

                                    View

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="10"
                                class="empty-row">

                                No Follow-Ups Scheduled

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection