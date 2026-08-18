@extends('admin.layouts.header')
@section('title', 'Agent Region Assignment')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agent Region Assignment</li>
        </ol>
    </nav>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Agent Region Assignment</h6>
            <small class="text-muted">
                New enquiries auto-detect the visitor's timezone and are assigned
                to the least-busy agent covering that region.
            </small>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('agent.regions.update') }}">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th>Agent</th>
                                @foreach($regions as $region)
                                    <th class="text-center">{{ $region->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agents as $agent)
                                <tr>
                                    <td>{{ $agent->name }}</td>
                                    @foreach($regions as $region)
                                        <td class="text-center">
                                            <input
                                                type="checkbox"
                                                name="regions[{{ $agent->id }}][]"
                                                value="{{ $region->id }}"
                                                {{ in_array($region->id, $assigned[$agent->id] ?? []) ? 'checked' : '' }}
                                            >
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $regions->count() + 1 }}" class="text-center text-muted">
                                        No agents found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary">Save Assignments</button>
            </form>

        </div>
    </div>
</div>
@endsection
