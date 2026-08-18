{{--
    Floating horizontal scrollbar for a wide table.

    Usage: put id="leadsTableScroll" on the scrollable wrapper around the
    table (the element with overflow-x:auto - e.g. .table-scroll or
    .table-responsive), then include this partial once anywhere after it:

        @include('partials.floating-scrollbar')

    It mirrors that wrapper's horizontal scroll position, but stays
    pinned to the bottom of the viewport so it's usable without first
    scrolling down the page to reach the table's own scrollbar. It only
    appears when the table is actually wider than its wrapper.
--}}

<div class="floating-hscroll" id="leadsFloatingScroll">
    <div class="floating-hscroll-track"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tableScroll = document.getElementById('leadsTableScroll');
    const floatBar = document.getElementById('leadsFloatingScroll');

    if (!tableScroll || !floatBar) {
        return;
    }

    const track = floatBar.querySelector('.floating-hscroll-track');

    let syncingFromTable = false;
    let syncingFromFloat = false;

    function sync() {

        const table = tableScroll.querySelector('table');

        if (!table) {
            return;
        }

        track.style.width = table.scrollWidth + 'px';

        const rect = tableScroll.getBoundingClientRect();
        floatBar.style.left = rect.left + 'px';
        floatBar.style.width = rect.width + 'px';

        const needsScroll = table.scrollWidth > tableScroll.clientWidth + 1;
        floatBar.classList.toggle('active', needsScroll);
    }

    tableScroll.addEventListener('scroll', function () {

        if (syncingFromFloat) {
            return;
        }

        syncingFromTable = true;
        floatBar.scrollLeft = tableScroll.scrollLeft;
        syncingFromTable = false;
    });

    floatBar.addEventListener('scroll', function () {

        if (syncingFromTable) {
            return;
        }

        syncingFromFloat = true;
        tableScroll.scrollLeft = floatBar.scrollLeft;
        syncingFromFloat = false;
    });

    window.addEventListener('resize', sync);
    window.addEventListener('scroll', sync);

    sync();

    // Table content can change after filtering/pagination without a full
    // reload in some setups - re-check dimensions shortly after too.
    setTimeout(sync, 300);
});
</script>