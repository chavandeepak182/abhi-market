@extends('admin.layouts.header')

@section('title', 'New Leads')

@section('content')

<div class="dashboard-body">

    <div class="card">

        <div class="card-body">

            <h4 class="mb-4">New Leads</h4>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($leads as $lead)

                    <tr class="blink-row">

                        <td>{{ $lead->id }}</td>

                        <td>{{ $lead->name }}</td>

                        <td>{{ $lead->email }}</td>

                        <td>{{ $lead->contact }}</td>

                        <td>
                            <span class="badge bg-danger blink-badge">
                                NEW
                            </span>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($lead->created_at)->format('d M Y h:i A') }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No New Leads Found
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

            {{ $leads->links() }}

        </div>

    </div>

</div>

<style>

.blink-row {
    animation: blinkRow 1s infinite;
}

.blink-badge {
    animation: blinkBadge 1s infinite;
}

@keyframes blinkRow {

    0% {
        background: #fff3cd;
    }

    50% {
        background: #ffe08a;
    }

    100% {
        background: #fff3cd;
    }
}

@keyframes blinkBadge {

    0% {
        opacity: 1;
    }

    50% {
        opacity: 0.3;
    }

    100% {
        opacity: 1;
    }
}

</style>

@endsection