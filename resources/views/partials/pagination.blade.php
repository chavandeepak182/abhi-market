{{--
    Standard pagination component.

    Usage:
    @include('partials.pagination', ['paginator' => $leads])
--}}

@php
    // Keep all current filters when moving between pages
    $paginator->appends(request()->except('page'));

    $current = $paginator->currentPage();
    $last    = $paginator->lastPage();

    $window = 2;

    $start = max(1, $current - $window);
    $end   = min($last, $current + $window);
@endphp


<div class="pagination-wrapper">

    {{-- =========================================
         RESULT INFORMATION
    ========================================== --}}
    


    {{-- =========================================
         PAGINATION CONTROLS
    ========================================== --}}
    <div class="custom-pagination">


        {{-- =====================================
             PREVIOUS BUTTON
        ====================================== --}}
        @if($paginator->onFirstPage())

            <span class="pagination-arrow disabled">
                <span>&laquo;</span>
                Previous
            </span>

        @else

            <a href="{{ $paginator->previousPageUrl() }}"
               class="pagination-arrow">

                <span>&laquo;</span>
                Previous

            </a>

        @endif


        {{-- =====================================
             PAGE NUMBERS
        ====================================== --}}

        {{-- First page --}}
        @if($start > 1)

            <a href="{{ $paginator->url(1) }}"
               class="pagination-number">

                1

            </a>

            {{-- Dots --}}
            @if($start > 2)

                <span class="pagination-dots">
                    &hellip;
                </span>

            @endif

        @endif


        {{-- Current page window --}}
        @for($i = $start; $i <= $end; $i++)

            @if($i == $current)

                {{-- Active page --}}
                <span class="pagination-number active">
                    {{ $i }}
                </span>

            @else

                {{-- Other pages --}}
                <a href="{{ $paginator->url($i) }}"
                   class="pagination-number">

                    {{ $i }}

                </a>

            @endif

        @endfor


        {{-- Last page --}}
        @if($end < $last)

            {{-- Dots --}}
            @if($end < $last - 1)

                <span class="pagination-dots">
                    &hellip;
                </span>

            @endif


            <a href="{{ $paginator->url($last) }}"
               class="pagination-number">

                {{ $last }}

            </a>

        @endif


        {{-- =====================================
             NEXT BUTTON
        ====================================== --}}
        @if($paginator->hasMorePages())

            <a href="{{ $paginator->nextPageUrl() }}"
               class="pagination-arrow">

                Next
                <span>&raquo;</span>

            </a>

        @else

            <span class="pagination-arrow disabled">

                Next
                <span>&raquo;</span>

            </span>

        @endif

    </div>

</div>