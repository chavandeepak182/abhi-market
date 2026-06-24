@extends('admin.layouts.header')

@section('title','Upload Sample Report')

@section('content')

<div class="dashboard-body">

<div class="card">

<div class="card-header">

<h5>Upload Sample Report PDF</h5>

</div>

<div class="card-body">

<form
action="{{ route('sample-reports.store') }}"
method="POST"
enctype="multipart/form-data">

@csrf

<div class="mb-3">

<label>Report Title</label>

<input
type="text"
name="report_title"
class="form-control">

</div>

<div class="mb-3">

<label>PDF File</label>

<input
type="file"
name="sample_pdf"
class="form-control"
accept=".pdf">

</div>

<button
type="submit"
class="btn btn-primary">

Upload PDF

</button>

</form>

</div>

</div>

</div>

@endsection