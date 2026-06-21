@extends('admin.layouts.header')

@section('title','Lead Details')

@section('content')

<div class="lead-view-wrapper">

    <div class="lead-view-card">

        <div class="lead-top-bar">

            <div>
                <h2>{{ $enquiry->name }}</h2>
                <span>Lead ID : #{{ $enquiry->id }}</span>
            </div>

            <a href="{{ url()->previous() }}" class="lead-back-btn">
                Back
            </a>

        </div>

        <div class="lead-grid">

            <div class="lead-item">
                <label>Email Address</label>
                <p>{{ $enquiry->email }}</p>
            </div>

            <div class="lead-item">
                <label>Mobile Number</label>
                <p>{{ $enquiry->contact }}</p>
            </div>

            <div class="lead-item">
                <label>Country</label>
                <p>{{ $enquiry->visitor_country ?? '-' }}</p>
            </div>

            <div class="lead-item">
                <label>Job Title</label>
                <p>{{ $enquiry->job_title ?? '-' }}</p>
            </div>

            <div class="lead-item">
                <label>Usage Type</label>
                <p>{{ ucfirst($enquiry->usage_type ?? '-') }}</p>
            </div>

            <div class="lead-item">
                <label>Status</label>

                <span class="lead-status">
                    {{ ucfirst($enquiry->status) }}
                </span>
            </div>

            <div class="lead-item">
                <label>Page Name</label>
                <p>{{ $enquiry->page_name ?? '-' }}</p>
            </div>

            <div class="lead-item">
                <label>Follow Up Date</label>
                <p>{{ $enquiry->followup_date ?? '-' }}</p>
            </div>

            <div class="lead-item">
                <label>Created Date</label>
                <p>
                    {{ date('d M Y h:i A', strtotime($enquiry->created_at)) }}
                </p>
            </div>

        </div>

        <div class="lead-section">

            <h5>Message</h5>

            <div class="lead-box">
                {{ $enquiry->message ?? 'No Message Available' }}
            </div>

        </div>

        <div class="lead-section">

            <h5>Remark</h5>

            <div class="lead-box">
                {{ $enquiry->remark ?? 'No Remark Available' }}
            </div>

        </div>

    </div>

</div>

<style>

.lead-view-wrapper{
    padding:30px;
}

.lead-view-card{
    background:#fff;
    border-radius:20px;
    box-shadow:0 5px 25px rgba(0,0,0,0.08);
    overflow:hidden;
}

.lead-top-bar{
    background:#0f172a;
    color:#fff;
    padding:25px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.lead-top-bar h2{
    margin:0;
    font-size:26px;
    font-weight:700;
}

.lead-top-bar span{
    opacity:.8;
}

.lead-back-btn{
    background:#fff;
    color:#111;
    text-decoration:none;
    padding:10px 20px;
    border-radius:10px;
    font-weight:600;
}

.lead-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    padding:30px;
}

.lead-item{
    background:#f8fafc;
    padding:18px;
    border-radius:12px;
    border:1px solid #e5e7eb;
}

.lead-item label{
    display:block;
    color:#6b7280;
    font-size:12px;
    text-transform:uppercase;
    margin-bottom:8px;
    font-weight:600;
}

.lead-item p{
    margin:0;
    font-size:15px;
    font-weight:600;
    color:#111827;
}

.lead-status{
    background:#22c55e;
    color:#fff;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

.lead-section{
    padding:0 30px 25px;
}

.lead-section h5{
    margin-bottom:12px;
    font-weight:700;
}

.lead-box{
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:12px;
    padding:18px;
    min-height:90px;
    line-height:1.8;
}

@media(max-width:991px){

    .lead-grid{
        grid-template-columns:1fr;
    }

    .lead-top-bar{
        flex-direction:column;
        gap:15px;
        text-align:center;
    }
}

</style>

@endsection