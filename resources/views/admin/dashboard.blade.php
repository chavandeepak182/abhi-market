@extends('admin.layouts.header')
@section('title', "Dashboard")

@section('content')
<div class="dashboard-body">
    <div class="row gy-4">

        <!-- LEFT SIDE -->
        <div class="col-lg-9">

            <!-- COUNTS -->
            <div class="row gy-4">
                <div class="col-xxl-3 col-sm-6">
                    <div class="card" onclick="window.location='{{ route('reports.index') }}';" style="cursor: pointer;">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $reportsCount }}</h4>
                            <span class="text-gray-600">Total Reports</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-600 text-white text-2xl">
                                    <i class="ph-fill ph-book-open"></i>
                                </span>
                                <div id="complete-course" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="card" onclick="window.location='{{ route('industries.index') }}';" style="cursor: pointer;">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $industriesCount }}</h4>
                            <span class="text-gray-600">Total Industries</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-main-two-600 text-white text-2xl">
                                    <i class="ph-fill ph-certificate"></i>
                                </span>
                                <div id="earned-certificate" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="card" onclick="window.location='{{ route('services.index') }}';" style="cursor: pointer;">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $servicesCount }}</h4>
                            <span class="text-gray-600">Total Capabilities</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-purple-600 text-white text-2xl">
                                    <i class="ph-fill ph-graduation-cap"></i>
                                </span>
                                <div id="course-progress" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="card" onclick="window.location='{{ route('enquiries.enquiryLead') }}';" style="cursor: pointer;">
                        <div class="card-body">
                            <h4 class="mb-2">{{ $enquiriesCount }}</h4>
                            <span class="text-gray-600">Total Enquiries</span>
                            <div class="flex-between gap-8 mt-16">
                                <span class="flex-shrink-0 w-48 h-48 flex-center rounded-circle bg-warning-600 text-white text-2xl">
                                    <i class="ph-fill ph-users-three"></i>
                                </span>
                                <div id="community-support" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MONTHLY REVENUE -->
            <div class="card mt-24">
                <div class="card-body">
                    <h4>Monthly Revenue</h4>
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>

            <!-- LEAD STATUS -->
            <div class="card mt-24">
                <div class="card-body text-center">
                    <h4>Lead Status</h4>
                    <div style="height:250px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- REVENUE SUMMARY -->
            <div class="card mt-24">
                <div class="card-body">
                    <h4>Revenue Summary</h4>
                    <p><strong>Total Revenue:</strong> ₹{{ number_format($totalRevenue) }}</p>
                    <p><strong>This Month:</strong> ₹{{ number_format($currentMonthRevenue) }}</p>
                </div>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-lg-3">

            <!-- CALENDAR -->
            <div class="card">
                <div class="card-body">
                    <div class="calendar">
                        <div class="calendar__header">
                            <button class="calendar__arrow left"><i class="ph ph-caret-left"></i></button>
                            <p class="display h6 mb-0"></p>
                            <button class="calendar__arrow right"><i class="ph ph-caret-right"></i></button>
                        </div>
                        <div class="calendar__week week">
                            <div>Su</div><div>Mo</div><div>Tu</div>
                            <div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                        </div>
                        <div class="days"></div>
                    </div>
                </div>
            </div>

            <!-- RECENT LEADS -->
            <div class="card mt-24">
                <div class="card-body">
                    <h5>Recent Leads</h5>

                    @foreach(DB::table('enquiries')->latest()->limit(5)->get() as $lead)
                        <div class="mb-2">
                            <strong>{{ $lead->name }}</strong><br>
                            <small>{{ ucfirst($lead->status) }}</small>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Monthly Revenue Chart
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            label: 'Monthly Revenue',
            data: @json($months),
            borderWidth: 1
        }]
    }
});

// Lead Status Doughnut Chart (FIXED SIZE)
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['New', 'Contacted', 'Converted', 'Not Interested'],
        datasets: [{
            data: [
                {{ $statusCounts['new'] ?? 0 }},
                {{ $statusCounts['contacted'] ?? 0 }},
                {{ $statusCounts['converted'] ?? 0 }},
                {{ $statusCounts['not_interested'] ?? 0 }}
            ],
            backgroundColor: [
                '#0d6efd',
                '#ffc107',
                '#198754',
                '#dc3545'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

@endsection