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
                Add New Lead
            </h1>

            <p class="page-subtitle">
                Create a new lead manually
            </p>

        </div>

        <a href="{{ route('leads.index') }}"
           class="btn-reset">

            Back

        </a>

    </div>

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="form-card">

        <form action="{{ route('leads.store') }}"
              method="POST">

            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label>Name *</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Phone *</label>
                    <input type="tel"
                           id="phoneInput"
                           name="phone"
                           class="form-control"
                           value="{{ old('phone') }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Company</label>
                    <input type="text"
                           name="company"
                           class="form-control"
                           value="{{ old('company') }}">
                </div>

                <div class="form-group">
                    <label>Designation</label>
                    <input type="text"
                           name="designation"
                           class="form-control"
                           value="{{ old('designation') }}">
                </div>

                <div class="form-group">
                    <label>Usage Type</label>

                    <select name="usage_type_choice"
                            id="adminUsageType"
                            class="form-control">

                        <option value="">Select usage type</option>
                        <option value="Enterprise" {{ old('usage_type') === 'Enterprise' ? 'selected' : '' }}>Enterprise</option>
                        <option value="Business" {{ old('usage_type') === 'Business' ? 'selected' : '' }}>Business</option>
                        <option value="Personal" {{ old('usage_type') === 'Personal' ? 'selected' : '' }}>Personal</option>
                        <option value="Academic/Research" {{ old('usage_type') === 'Academic/Research' ? 'selected' : '' }}>Academic / Research</option>
                        <option value="Government" {{ old('usage_type') === 'Government' ? 'selected' : '' }}>Government</option>
                        <option value="Other" {{ old('usage_type') && !in_array(old('usage_type'), ['Enterprise','Business','Personal','Academic/Research','Government']) ? 'selected' : '' }}>Others (please specify)</option>
                    </select>

                    <input type="text"
                           name="usage_type"
                           id="adminUsageTypeFinal"
                           class="form-control"
                           style="margin-top:8px;"
                           placeholder="Type usage type if 'Others' selected"
                           value="{{ old('usage_type') }}">
                </div>

                <div class="form-group">
                    <label>Country *</label>
                    <input type="text"
                           name="country"
                           class="form-control"
                           value="{{ old('country') }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Timezone *</label>

                    <select name="timezone"
                            class="form-control"
                            required>

                        <option value="" disabled {{ old('timezone') ? '' : 'selected' }}>Select timezone</option>

                        @foreach($regions as $region)

                            <option value="{{ $region->name }}" {{ old('timezone') === $region->name ? 'selected' : '' }}>
                                {{ $region->name }}{{ $region->reference_timezone ? ' ('.$region->reference_timezone.')' : '' }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>

                    {{-- Status is now fully automatic - every lead starts as
                         "New" and moves through Contacted / Engaged on its
                         own as the Global template is sent / the lead
                         replies, so there is nothing to pick here. --}}
                    <input type="text" class="form-control" value="New" disabled>
                    <small style="color:#6b7280;">
                        New leads always start as "New". Status updates automatically from here.
                    </small>

                </div>

                <div class="form-group">
                    <label>Lead Type</label>

                    <select name="lead_type"
                            class="form-control">

                        <option value="hot">
                            Hot
                        </option>

                        <option value="warm" selected>
                            Warm
                        </option>

                        <option value="cold">
                            Cold
                        </option>

                    </select>

                </div>

                <div class="form-group">
                    <label>Followup Count</label>

                    <input type="number"
                           name="followup_count"
                           class="form-control"
                           value="0">
                </div>

                <div class="form-group">
                    <label>Next Followup Date</label>

                    <input type="date"
                           name="next_followup_date"
                           class="form-control">
                </div>

            </div>

            <div class="form-actions">

                <button type="submit"
                        class="btn-save">

                    Save Lead

                </button>

            </div>

        </form>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const choice = document.getElementById('adminUsageType');
    const final = document.getElementById('adminUsageTypeFinal');
    choice.addEventListener('change', function () {
        if (choice.value) {
            final.value = choice.value === 'Other' ? '' : choice.value;
            if (choice.value === 'Other') { final.focus(); }
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/intlTelInput.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const phoneInput = document.getElementById('phoneInput');
    if (!phoneInput) return;

    // Country-aware mobile number input: shows a flag/country-code
    // dropdown and writes the number back in full international
    // (+<country code><number>) format before the form submits, which is
    // what the server-side InternationalPhone validation rule expects.
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: 'in',
        separateDialCode: true,
        loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/utils.js'),
    });

    phoneInput.closest('form').addEventListener('submit', function () {
        if (phoneInput.value.trim() !== '') {
            phoneInput.value = iti.getNumber();
        }
    });
});
</script>

@endsection