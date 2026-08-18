@extends('admin.layouts.header')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leads.css') }}">
@endpush

@section('content')

<div class="crm-container">

    <div class="page-header">

        <div>
            <h1 class="page-title">
                Lead History
            </h1>

            <p class="page-subtitle">
                Leads and completed follow-ups on
                {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
            </p>
        </div>

    </div>

    <!-- Leads Added -->

    <div class="table-card mb-4">

        <div class="section-title">
            Leads Added
            <span>{{ $leadsAdded->count() }}</span>
        </div>

        <div class="table-responsive">

            <table class="crm-table">

                <thead>

                    <tr>

                        <th>Lead ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Country</th>
                        <th>Timezone</th>
                        <th>Status</th>
                        <th>Lead Type</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($leadsAdded as $lead)

                        <tr>

                            <td>
                                <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span>
                            </td>

                            <td>
                                <a href="{{ route('leads.show',$lead->id) }}"
                                   class="lead-link">
                                    {{ $lead->name }}
                                </a>
                            </td>

                            <td>{{ $lead->email }}</td>

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

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="empty-row">
                                No Leads Added
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <!-- Completed Followups -->

    <div class="table-card">

        <div class="section-title">
            Completed Follow-Ups
            <span>{{ $completedFollowups->count() }}</span>
        </div>

        <div class="table-responsive">

            <table class="crm-table">

                <thead>

                    <tr>

                        <th>Lead</th>
                        <th>Follow-Up Note</th>
                        <th>Completed At</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($completedFollowups as $history)

                        <tr>

                            <td>
                                {{ $history->lead?->name ?? '-' }}
                                @if($history->lead?->lead_id)
                                    <div class="lead-id-badge">{{ $history->lead->lead_id }}</div>
                                @endif
                            </td>

                            <td>
                                {{ $history->notes ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($history->completed_at)->format('d M Y h:i A') }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="empty-row">
                                No Follow-Ups Completed
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection