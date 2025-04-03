@extends('layouts.header')
@section('title')
@parent
Choose Localities
@endsection
@section('content')

@parent
<!-- Breadcrumbs and Search Bar -->
<div class="card-header py-3">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="d-flex align-items-center">
            <ol class="breadcrumb m-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Choose Localities</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row bg-white p-3 g-3">
    <div class="col-md-6">
        <div class="card-body choose_localities">
            <!-- Upload Form -->
            <form action="{{ route('admin.localities.store') }}" method="POST">
                @csrf
                <h4>Choose up to 3 Localities:</h4>
                <select name="localities[]" multiple class="form-control">
                    @foreach($localities as $locality)
                        <option value="{{ $locality->id }}" 
                            @if(in_array($locality->id, $selectedLocalities)) selected @endif>
                            {{ $locality->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary mt-2">Save</button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-body">
            <!-- Display Existing Banners -->
            <h4>Selected Localities</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        @foreach ($localities as $locality)
                            @if(in_array($locality->id, $selectedLocalities)) 
                                <tr>
                                    <td>{{ $locality->name }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>    
</div>
@endsection
