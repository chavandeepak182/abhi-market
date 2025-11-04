<div id="reports-list">
  @foreach($reports as $report)
    @include('frontend.reports.reports-card', ['report' => $report])
  @endforeach
</div>

<div id="reports-pagination" class="custom-pagination-wrapper mt-4">
  {{ $reports->appends(request()->query())->links('vendor.pagination.custom') }}
</div>
