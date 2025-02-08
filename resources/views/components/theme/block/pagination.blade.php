@if ($paginator->hasPages())
    <div class="pagination">
        @if (!$paginator->onFirstPage())
            <a class="page" rel="prev" href="{{ $paginator->previousPageUrl() }}" title="Về trang trước">« Trước</a>
        @endif

        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page active">{{ $page }}</span>
                    @elseif (($page == $paginator->currentPage() - 1 || $page == $paginator->currentPage() - 2) || ($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2))
                        <a rel="next" title="Đến trang {{ $page }}" class="page" href="{{ $url }}">{{ $page }}</a>
                    @elseif(1 == $paginator->currentPage() && $page == $paginator->currentPage() + 3)
                        <a rel="next" title="Đến trang {{ $page }}" class="page" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="page" rel="next" href="{{ $paginator->nextPageUrl() }}" title="Đến trang tiếp">Tiếp »</a>
        @endif
    </div>
@endif
