@extends('admin.layouts.header')

@section('title','Sample Reports')

@section('content')

<div class="dashboard-body">

<div class="card">

<div class="card-header">


<div class="d-flex justify-content-between align-items-center">

    <h5 class="mb-0">
        Sample Reports
    </h5>

    <a
        href="{{ route('sample-reports.create') }}"
        class="btn btn-primary">

        Add Sample Report

    </a>

</div>

<form
    method="GET"
    action="{{ route('sample-reports.index') }}"
    class="mt-3">

    <div class="row">

        <div class="col-md-4">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="Search Report Title">

        </div>

        <div class="col-md-2">

            <button
                type="submit"
                class="btn btn-success">

                Search

            </button>

            <a
                href="{{ route('sample-reports.index') }}"
                class="btn btn-secondary">

                Reset

            </a>

        </div>

    </div>

</form>


</div>


<div class="card-body">

<table class="table">

<thead>

<tr>

<th>ID</th>

<th>Title</th>

<th>PDF</th>

</tr>

</thead>

<tbody>

@foreach($reports as $report)

<tr>

<td>{{ $report->id }}</td>

<td>{{ $report->report_title }}</td>

<td>

<a
href="{{ asset('storage/'.$report->pdf_file) }}"
target="_blank"
class="btn btn-success btn-sm">

View PDF

</a>

</td>

</tr>

@endforeach

</tbody>

</table>
<div class="mt-3">
    {{ $reports->appends(request()->query())->links() }}
</div>


</div>

</div>

</div>

@endsection