@extends('admin.layouts.header')

@section('content')

<div class="crm-container">

    <div class="page-header">

        <div>

            <h1 class="page-title">
                My Calendar
            </h1>

            <p class="page-subtitle">
                Scheduled followups assigned to me
            </p>

        </div>

    </div>

    <div class="table-card">

        <table class="crm-table">

            <thead>

                <tr>

                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Followup Date</th>
                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($monthTasks as $lead)

                    <tr>

                        <td>{{ $lead->name }} <span class="lead-id-badge">{{ $lead->lead_id ?? '-' }}</span></td>

                        <td>{{ $lead->email }}</td>

                        <td>{{ $lead->company }}</td>

                        <td>{{ $lead->next_followup_date?->format('d M Y') }}</td>

                        <td>{{ $lead->status }}</td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5">

                            No followups scheduled.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection