
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">
                <a href="{{ route('reports.details', $report->slug) }}" class="text-decoration-none text-dark">
                    {{ $report->report_title }}
                </a>
            </h5>

            <p class="card-text">
                {!! \Illuminate\Support\Str::limit(strip_tags($report->description), 200) !!}
                <a href="{{ route('reports.details', $report->slug) }}" class="text-info">Read More <i class="fa fa-external-link-alt"></i></a>
            </p>

            <p class="small text-muted mb-3">
                {{ $report->publish_date ? \Carbon\Carbon::parse($report->publish_date)->format('F, Y') : '' }} |
                Base Year: {{ $report->publish_date ? date('Y', strtotime($report->publish_date . ' -1 year')) : '' }}
            </p>

                <div class="d-flex gap-2">
                                    <a href="{{ route('request.sample', $report->slug) }}" class="btn btn-sm btn-info">Request Sample</a>
                                    <a href="{{ route('purchase.page', $report->id) }}" class="btn btn-primary">Buy Now</a>
               </div>
        </div>
    </div>


