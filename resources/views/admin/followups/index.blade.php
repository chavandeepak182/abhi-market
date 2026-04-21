@extends('admin.layouts.header')
@section('title', "Follow-ups")
@section('content')

<style>
.page-title {
    font-weight: 600;
    font-size: 18px;
    margin-bottom: 15px;
}

.card-box {
    background: #fff;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.table-custom th {
    font-size: 13px;
    color: #555;
}

.table-custom td {
    font-size: 14px;
}

.badge-pill {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
}

.badge-personal { background:#6c757d; color:#fff; }
.badge-office { background:#28a745; color:#fff; }

.detail-box {
    background: #f9fafc;
    padding: 15px;
    border-radius: 10px;
}

.history-scroll {
    max-height: 200px;
    overflow-y: auto;
}
</style>

<div class="card-box">

    <div class="page-title">
    📋 Today Follow-ups 
    <span class="badge bg-primary">{{ $todayCount }}</span>
</div>

    <table class="table table-hover table-custom">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Country</th>
                <th>Page</th>
                <th>Usage</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($enquiries as $e)
            <tr>

                <td>
                    <b>{{ $e->name }}</b><br>
                    <small class="text-muted">{{ $e->email }}</small>
                </td>

                <td>{{ $e->contact }}</td>

                <td>{{ $e->country_name ?? '-' }}</td>

                <td>
                    <small title="{{ $e->page_name }}">
                        {{ \Illuminate\Support\Str::limit($e->page_name, 25) }}
                    </small>
                </td>

                <td>
                    <span class="badge-pill {{ $e->usage_type == 'office' ? 'badge-office' : 'badge-personal' }}">
                        {{ ucfirst($e->usage_type) }}
                    </span>
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($e->followup_date)->format('d M Y') }}
                </td>

                <td>
                  <a href="{{ route('followup.detail', $e->id) }}" 
   class="btn btn-sm btn-primary">
   Follow-up
</a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>


<!-- ================= MODAL ================= -->



<!-- ================= SCRIPT ================= -->



@endsection