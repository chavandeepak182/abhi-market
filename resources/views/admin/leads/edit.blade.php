@extends('admin.layouts.header')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/leads.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/css/intlTelInput.css">
@endpush

@section('content')

<div class="crm-container">

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Edit Lead
            </h1>

            <p class="page-subtitle">
                Update lead information and assignment details
            </p>

        </div>

        <a href="{{ route('leads.index') }}"
           class="btn-reset">

            Back

        </a>

    </div>

    <div class="form-card">

        <form action="{{ route('leads.update', $lead->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Lead ID</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $lead->lead_id ?? '-' }}"
                           readonly
                           disabled>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name',$lead->name) }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email',$lead->email) }}">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel"
                           id="phoneInput"
                           name="phone"
                           class="form-control"
                           value="{{ old('phone',$lead->phone) }}">
                </div>

                <div class="form-group">
                    <label>Company</label>
                    <input type="text"
                           name="company"
                           class="form-control"
                           value="{{ old('company',$lead->company) }}">
                </div>

                <div class="form-group">
                    <label>Designation</label>
                    <input type="text"
                           name="designation"
                           class="form-control"
                           value="{{ old('designation',$lead->designation) }}">
                </div>

                <div class="form-group">
                    <label>Usage Type</label>
                    <input type="text"
                           name="usage_type"
                           class="form-control"
                           value="{{ old('usage_type',$lead->usage_type) }}">
                </div>

                <div class="form-group">
                    <label>Country</label>
                    <input type="text"
                           name="country"
                           class="form-control"
                           value="{{ old('country',$lead->country) }}">
                </div>

               <div class="form-group">

    <label>Timezone</label>

    <select name="timezone"
            class="form-control">

        <option value="">Select Timezone</option>

        @php($currentTimezone = old('timezone', $lead->timezone))
        @php($matchedInRegions = false)

        @foreach($regions as $region)

            @php($isSelected = $currentTimezone === $region->name)
            @php($matchedInRegions = $matchedInRegions || $isSelected)

            <option value="{{ $region->name }}" {{ $isSelected ? 'selected' : '' }}>
                {{ $region->name }}{{ $region->reference_timezone ? ' ('.$region->reference_timezone.')' : '' }}
            </option>

        @endforeach

        {{-- Preserve the lead's existing value even if it doesn't match a known
             region (e.g. older leads saved with a raw IANA string like
             "Asia/Kolkata" before this field was standardised). --}}
        @if($currentTimezone && !$matchedInRegions)
            <option value="{{ $currentTimezone }}" selected>{{ $currentTimezone }} (existing value)</option>
        @endif

    </select>

</div>

                <div class="form-group">
                    <label>Status</label>

                    <select name="status"
                            class="form-control">

                        <option value="new"
                            {{ $lead->status == 'new' ? 'selected' : '' }}>
                            New
                        </option>

                        <option value="contacted"
                            {{ $lead->status == 'contacted' ? 'selected' : '' }}>
                            Contacted
                        </option>

                        <option value="engaged"
                            {{ $lead->status == 'engaged' ? 'selected' : '' }}>
                            Engaged
                        </option>

                        <option value="converted"
                            {{ $lead->status == 'converted' ? 'selected' : '' }}>
                            Converted
                        </option>

                        <option value="not_interested"
                            {{ $lead->status == 'not_interested' ? 'selected' : '' }}>
                            Not Interested
                        </option>

                    </select>

                </div>

                <div class="form-group">
                    <label>Lead Type</label>

                    <select name="lead_type"
                            class="form-control">

                        <option value="hot"
                            {{ $lead->lead_type == 'hot' ? 'selected' : '' }}>
                            Hot
                        </option>

                        <option value="warm"
                            {{ $lead->lead_type == 'warm' ? 'selected' : '' }}>
                            Warm
                        </option>

                        <option value="cold"
                            {{ $lead->lead_type == 'cold' ? 'selected' : '' }}>
                            Cold
                        </option>

                    </select>

                </div>

                <div class="form-group">
                    <label>Followup Count</label>

                    <input type="number"
                           name="followup_count"
                           class="form-control"
                           value="{{ old('followup_count',$lead->followup_count) }}">
                </div>

                <div class="form-group">
                    <label>Next Followup Date</label>

                    <input type="date"
                           name="next_followup_date"
                           class="form-control"
                           value="{{ old('next_followup_date',$lead->next_followup_date?->format('Y-m-d')) }}">
                </div>

            </div>

            <div class="form-actions">

                <button type="submit"
                        class="btn-save">

                    Update Lead

                </button>

            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/intlTelInput.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const phoneInput = document.getElementById('phoneInput');
    if (!phoneInput) return;

    const iti = window.intlTelInput(phoneInput, {
        initialCountry: 'in',
        separateDialCode: true,
        loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/utils.js'),
    });

    // If the existing number already has a country code, intl-tel-input
    // auto-detects it from the input's initial value; either way, write
    // the full international format back before submit.
    phoneInput.closest('form').addEventListener('submit', function () {
        if (phoneInput.value.trim() !== '') {
            phoneInput.value = iti.getNumber();
        }
    });
});
</script>

@endsection