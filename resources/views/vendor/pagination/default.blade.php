@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled page-item pagination-prev"><span>&laquo;</span></li>
        @else
            <li class="page-item pagination-prev"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled page-item"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active page-item"><span>{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item pagination-next"><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled page-item pagination-next"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
