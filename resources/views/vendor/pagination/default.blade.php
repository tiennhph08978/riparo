@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <img src="{{ asset("assets/img/paginate-previous.svg") }}">
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="previous" aria-label="@lang('pagination.previous')" class="pagination-btn">
                        <img src="{{ asset("assets/img/paginate-previous.svg") }}">
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @elseif ($page == $paginator->currentPage() - 1 || $page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2 || $page == $paginator->lastPage())
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($page == 1 && $paginator->currentPage() <= 3)
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($page == 1 && $paginator->currentPage() > 3)
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                            <li><img src="{{ asset("assets/img/paginate-dot.svg") }}"></li>
                        @elseif ($page == $paginator->lastPage() - 1)
                            <li><img src="{{ asset("assets/img/paginate-dot.svg") }}"></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" class="pagination-btn">
                        <img src="{{ asset("assets/img/paginate-next.svg") }}">
                    </a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <img src="{{ asset("assets/img/paginate-next.svg") }}">
                </li>
            @endif
        </ul>
    </nav>
@endif
