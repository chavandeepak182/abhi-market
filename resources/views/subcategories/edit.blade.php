@extends('admin.layouts.header')

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Edit Sub Category</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="row gy-20">
                <div class="col-md-5 col-sm-5">
                    <form action="{{ route('subcategories.update', $subcategory->property_subcategory_id) }}" method="POST">
                        @csrf
                        <div class="position-relative">
                            <label for="pid" class="form-label">Select Category:</label>
                            <select name="pid" class="form-control placeholder-13 py-11 pe-76" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->pid }}" {{ $subcategory->pid == $category->pid ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="position-relative">
                            <label for="name" class="form-label">Subcategory Name:</label>
                            <input type="text" name="name" class="form-control placeholder-13 py-11 pe-76" value="{{ $subcategory->name }}" required>
                        </div>
                        
                        <div class="flex-align mt-10">
                            <button type="submit" class="btn btn-main rounded-pill py-9">Subcategory</button>
                            <a href="{{ route('subcategories.index') }}" class="btn btn-secondary rounded-pill py-9 ms-10">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
