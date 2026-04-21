@extends('admin.layouts.header')
@section('title', "Follow-up Detail")

@section('content')

<style>
.card-box {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.info-box {
    background: #f8f9fb;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}

.form-control {
    border-radius: 8px;
}

.history-box {
    max-height: 300px;
    overflow-y: auto;
}
</style>
<a href="{{ route('followups') }}" class="btn btn-secondary mb-3">
    ← Back to Follow-up List
</a>

<div class="container-fluid">

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        <!-- LEFT: FORM -->
        <div class="col-md-6">
            <div class="card-box">

                <h5>👤 Lead Details</h5>

                <div class="info-box">
                    <p><strong> {{ $enquiry->page_name ?? '-' }}</strong></p>
                    <p><b>{{ $enquiry->name }}</b></p>
                    <p>{{ $enquiry->email }}</p>
                    <p><b>📞</b> {{ $enquiry->contact }}</p>
                    <p>
                        <b>🌍 Country:</b> 
                        {{ $enquiry->country_name ?? 'N/A' }}
                    </p>
                    <!-- <p><b>📄</b> {{ $enquiry->page_name ?? '-' }}</p> -->
                    <p><b></b> {{ $enquiry->message }}</p>
                </div>

                <!-- FORM -->
                <form method="POST" action="{{ route('enquiry.update') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $enquiry->id }}">

                    <label>Status</label>
                    <select name="status" id="statusSelect" class="form-control">
                        <option value="new">New</option>
                        <option value="contacted">Contacted</option>
                        <option value="not_interested">Not Interested</option>
                        <option value="converted">Converted</option>
                    </select>

                            <br>

                            <!-- ✅ ADD THIS -->
                            <div id="leadTypeBox" style="display:none;">
                                <label>Lead Type</label>
                                <select name="lead_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="hot">🔥 Hot</option>
                                    <option value="warm">🟠 Warm</option>
                                    <option value="cold">❄️ Cold</option>
                                </select>
                            </div>
                            <script>
                            document.getElementById('statusSelect').addEventListener('change', function() {
                                let box = document.getElementById('leadTypeBox');

                                if (this.value === 'contacted') {
                                    box.style.display = 'block';
                                } else {
                                    box.style.display = 'none';
                                }
                            });
                            </script>

                    <br>

                    <label>Next Follow-up</label>
                    <input type="datetime-local" name="followup_date" class="form-control">

                    <br>

                    <label>Remark</label>
                    <textarea name="remark" class="form-control"></textarea>

                    <br>

                    <button class="btn btn-primary w-100">
                        ✔ Update Follow-up
                    </button>
                </form>

            </div>
        </div>

        <!-- RIGHT: HISTORY -->
        <div class="col-md-6">
            <div class="card-box">

                <h5>📜 Follow-up History</h5>

                <div class="history-box">
                    <table class="table table-bordered">
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Type</th> <!-- ✅ NEW -->
                            <th>Remark</th>
                        </tr>

                        @foreach($followups as $f)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($f->followup_date)->format('d M Y h:i A') }}
                            </td>
                       <td>
                                                    <span class="badge 
                                                        @if($f->status == 'new') bg-primary
                                                        @elseif($f->status == 'contacted') bg-warning
                                                        @elseif($f->status == 'converted') bg-success
                                                        @else bg-danger
                                                        @endif
                                                    ">
                                                        {{ ucfirst($f->status) }}
                                                    </span>
                        </td>

<!-- ✅ LEAD TYPE -->
<td>
    @if($f->lead_type == 'hot')
        <span class="badge bg-danger">Hot</span>
    @elseif($f->lead_type == 'warm')
        <span class="badge bg-warning text-dark">Warm</span>
    @elseif($f->lead_type == 'cold')
        <span class="badge bg-secondary">Cold</span>
    @else
        -
    @endif
</td>


                      <td>{{ $f->remark }}</td>
                        </tr>
                        @endforeach

                    </table>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection