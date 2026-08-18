@extends('admin.layouts.header')

@section('title','History')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="table-panel">

    <div class="panel-title">

        Leads Added On
        {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}

    </div>

    <table>

        <thead>

            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

        @forelse($leadsAdded as $lead)

            <tr>

                <td>{{ $lead->name }} <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span></td>

                <td>{{ $lead->company }}</td>

                <td>{{ ucfirst($lead->status) }}</td>

            </tr>

        @empty

            <tr>

                <td colspan="3">
                    No leads added.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<div class="table-panel">

    <div class="panel-title">
        Completed Followups
    </div>

    <table>

        <thead>

            <tr>
                <th>Lead</th>
                <th>Followup No.</th>
                <th>Remarks</th>
            </tr>

        </thead>

        <tbody>

        @forelse($completedFollowups as $history)

            <tr>

                <td>{{ $history->lead->name ?? '-' }} @if($history->lead?->lead_id)<span class="lead-id-badge">{{ $history->lead->lead_id }}</span>@endif</td>

                <td>{{ $history->followup_no }}</td>

                <td>{{ $history->remarks }}</td>

            </tr>

        @empty

            <tr>

                <td colspan="3">
                    No followups completed.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>
@include('agent.calendar.partials.meetings')
@endsection
