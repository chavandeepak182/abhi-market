@if ($paginator->hasPages())
    <nav class="modern-pagination">
        <ul class="pagination-list">
            {{-- Previous Page --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&lsaquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $start = max($paginator->currentPage() - 1, 1);
                $end = min($paginator->currentPage() + 1, $paginator->lastPage());
            @endphp

            {{-- Always show first page --}}
            @if ($start > 1)
                <li><a href="{{ $paginator->url(1) }}">1</a></li>
                @if ($start > 2)
                    <li class="disabled"><span>…</span></li>
                @endif
            @endif

            {{-- Page Range --}}
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $paginator->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            {{-- Always show last page --}}
            @if ($end < $paginator->lastPage())
                @if ($end + 1 < $paginator->lastPage())
                    <li class="disabled"><span>…</span></li>
                @endif
                <li><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            {{-- Next Page --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
            @else
                <li class="disabled"><span>&rsaquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
