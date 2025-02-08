@if ($paginator->hasPages())
    <div class="nav-link">
        @if (!$paginator->onFirstPage())
            <a rel="prev" href="{{ $paginator->previousPageUrl() }}" title="Trang trước" class="page-numbers">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5"/>
                </svg>
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-numbers current">{{ $page }}</span>
                    @elseif (($page == $paginator->currentPage() - 1 || $page == $paginator->currentPage() - 2) || ($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2))
                        <a rel="next" title="Đến trang {{ $page }}" class="page-numbers" href="{{ $url }}">{{ $page }}</a>
                    @elseif(1 == $paginator->currentPage() && $page == $paginator->currentPage() + 3)
                        <a rel="next" title="Đến trang {{ $page }}" class="page-numbers" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a rel="next" href="{{ $paginator->nextPageUrl() }}" title="Trang tiếp" class="page-numbers">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L12.293 7.5H6.5A.5.5 0 0 0 6 8m-2.5 7a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5"/>
                </svg>
            </a>
        @endif
    </div>
@endif
