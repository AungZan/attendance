@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled page-item pagination-prev"><span class="page-link"></span></li>
        @else
            <li class="page-item pagination-prev"><a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link">&laquo;</a></li>
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
                        <li class="active page-item"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item pagination-next"><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link">&raquo;</a></li>
        @else
            <li class="disabled page-item pagination-next"><span class="page-link"></span></li>
        @endif
    </ul>
@endif
