@extends('admin.layouts.header')

@section('title', "Today's Leads")

@section('content')

<div class="dashboard-body">

    <div class="card">

        <div class="card-body">

            <h4 class="mb-4">Today's Leads</h4>

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

                    <tr class="{{ $lead->status == 'new' ? 'blink-row' : '' }}">

                        <td>{{ $lead->id }}</td>

                        <td>{{ $lead->name }}</td>

                        <td>{{ $lead->email }}</td>

                        <td>{{ $lead->contact }}</td>

                        <td>
                            @if($lead->status == 'new')

                                <span class="badge bg-danger blink-badge">
                                    NEW
                                </span>

                            @else

                                <span class="badge bg-success">
                                    {{ ucfirst($lead->status) }}
                                </span>

                            @endif
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($lead->created_at)->format('d M Y h:i A') }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No Leads Found Today
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