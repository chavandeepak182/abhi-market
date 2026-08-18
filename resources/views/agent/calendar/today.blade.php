@extends('admin.layouts.header')

@section('title','Today')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="table-panel">

    <div class="panel-title">
        Today's New Leads
    </div>

    <table>

        <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

        @forelse($todayLeads as $lead)

            <tr>

                <td>{{ $lead->name }} <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span></td>
                <td>{{ $lead->company }}</td>
                <td>{{ $lead->email }}</td>
                <td>{{ ucfirst($lead->status) }}</td>

            </tr>

        @empty

            <tr>
                <td colspan="4">
                    No leads added today.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<div class="table-panel">

    <div class="panel-title">
        Today's Followups
    </div>

    <table>

        <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Followup No.</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($followups as $lead)

            <tr>

                <td>{{ $lead->name }} <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span></td>

                <td>{{ $lead->company }}</td>

                {{-- followup_count is how many follow-ups this lead has already
                     completed, not the one that's coming up - the one scheduled
                     for this date is always the next one after that. --}}
                <td>{{ $lead->followup_count + 1 }}</td>

                <td>

                    <a
                        href="{{ route('agent.lead.details',$lead->id) }}"
                        class="dashboard-btn">

                        View

                    </a>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="4">
                    No followups today.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>
@include('agent.calendar.partials.meetings')
@endsection
