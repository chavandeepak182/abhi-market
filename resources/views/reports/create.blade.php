@extends('admin.layouts.header')
@section('title', "Adding Report")

@section('content')
<div class="dashboard-body">
    <div class="breadcrumb-with-buttons mb-24 flex-between flex-wrap gap-8">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb mb-24">
            <ul class="flex-align gap-4">
                <li><a href="{{ url('admin/dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Dashboard</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><a href="{{ url('admin/reports') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">All Reports</a></li>
                <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
                <li><span class="text-main-600 fw-normal text-15">Add Report</span></li>
            </ul>
        </div>
        <!-- Breadcrumb End -->

        <!-- Breadcrumb Right Start -->
        <div class="flex-align gap-8 flex-wrap">
            <div class="flex-align text-gray-500 text-13 border-gray-100 focus-border-main-600">
                <a href="{{ route('reports.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <!-- Breadcrumb Right End -->
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="row gy-20">
                    <label class="h5 fw-semibold font-heading mt-15 mb-0">Add Report <span class="text-13 text-gray-400 fw-medium"></span> </label>
                    <div class="form-group">
    <label for="industry_category_id">Industry Category</label>
    <select name="industry_category_id" id="industry_category_id" class="form-control" required>
        <option value="">Select Industry Category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->pid }}">{{ $category->category_name }}</option>
        @endforeach
    </select>
</div>
                    <div class="col-md-8 col-sm-5">
                         <div class="position-relative pb-15 form-group">
                            <label for="report_name">Report title</label>
                            <input type="text" name="report_title" id="report_name" class="form-control" required>
                        </div>
                        <div class="position-relative pb-15 form-group">
                            <label for="report_name">Report Name</label>
                            <input type="text" name="report_name" id="report_name" class="form-control" required>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="summernote">Description</label>
                            <textarea name="description" id="summernote" class="form-control"></textarea>
                        </div>
                        <div class="position-relative pb-15 form-group">
                            <label for="summernote">Table Of Content</label>
                            <textarea name="toc" id="mySummernote" class="form-control"></textarea>
                        </div>
                        <script>
    $(document).ready(function() {
        $('#mySummernote').summernote({
            height: 250, // set editor height
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>

                    </div>
                    <div class="col-md-4 col-sm-7">
                        <div class="position-relative pb-15 form-group">
                            <label for="image">Report Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="slug">Slug URL</label>
                            <input type="text" name="slug" id="slug" class="form-control" required>
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control">
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control">
                        </div>

                        <div class="position-relative pb-15 form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control"></textarea>
                        </div>
                        <div class="position-relative pb-15 form-group">
                            <label for="meta_description">Schema Markup / Open Graph Meta / Twitter Card Meta</label>
                            <textarea name="schema_markup" id="schema_markup" class="form-control" style="height:150px;"></textarea>
                        </div>
                         <!-- <div class="position-relative pb-15 form-group">
                            <label for="slug">Graph Meta</label>
                            <input type="text" name="open_graph_meta" id="open_graph_meta" class="form-control" required>
                        </div>
                        <div class="position-relative pb-15 form-group">
                            <label for="slug">twitter Card </label>
                            <input type="text" name="twitter_card_meta" id="twitter_card_meta" class="form-control" required>
                        </div>
                        <div class="position-relative pb-15 form-group">
                            <label for="meta_description">FAQ</label>
                            <textarea name="faq" id="faq" class="form-control"></textarea>
                        </div> -->

                            <div class="form-group">
                                    <label>FAQs</label>
                                    <div id="faq-wrapper">

                                        <div class="faq-item border p-3 mb-3">
                                            <div class="form-group">
                                                <label>Question</label>
                                                <input type="text" name="faq_que[]" class="form-control" placeholder="Enter FAQ Question" />
                                            </div>
                                            <div class="form-group mt-2">
                                                <label>Answer</label>
                                                <textarea name="faq_ans[]" class="form-control" rows="3" placeholder="Enter FAQ Answer"></textarea>
                                            </div>
                                            <br>
                                            <!-- <button type="button" class="btn btn-danger mt-2 remove-faq">Remove</button> -->
                                            <button type="button" class="btn btn-danger rounded-pill py-9">Remove</button>
                                        </div>

                                    </div>
                                    <br>
                                    

                                    <!-- <button type="button" id="add-faq" class="btn mt-2" style="background-color: #3E80f9; color: white;">Add More FAQ</button> -->
                                    <button type="submit" class="btn btn-main rounded-pill py-9" id="add-faq">Add FAQ</button>
                            </div>
                                <br><br>

                        <div class="position-relative flex-align">
                            <button type="submit" class="btn btn-main rounded-pill py-9">Add Report</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('add-faq').addEventListener('click', function () {
        const wrapper = document.getElementById('faq-wrapper');

        const html = `
            <div class="faq-item border p-3 mb-3">
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" name="faq_que[]" class="form-control" placeholder="Enter FAQ Question" />
                </div>
                <div class="form-group mt-2">
                    <label>Answer</label>
                    <textarea name="faq_ans[]" class="form-control" rows="3" placeholder="Enter FAQ Answer"></textarea>
                </div>
                <button type="button" class="btn btn-danger mt-2 remove-faq">Remove</button>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-faq')) {
            e.target.closest('.faq-item').remove();
        }
    });
</script>

@endsection
