@if ($paginator->hasPages())
    <!-- Pagination -->
    <div class="pull-right pagination">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <span><i class="fa fa-angle-double-left page-link h-100"></i></span>
                </li>
            @else
                <li>
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                        <span><i class="fa fa-angle-double-left h-100"></i></span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link h-100 paginate-center">{{ $page }}</span></li>
                        @elseif (($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2) || $page == $paginator->lastPage())
                            <li class=""><a class="page-link " href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($page == $paginator->lastPage() - 1)
                            <li class="disabled page-item"><span class="page-link h-100 paginate-center"><i class="fa fa-ellipsis-h"></i></span></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}">
                        <span><i class="fa fa-angle-double-right page-link h-100"></i></span>
                    </a>
                </li>
            @else
                <li class="disabled">
                    <span><i class="fa fa-angle-double-right page-link h-100"></i></span>
                </li>
            @endif
        </ul>
    </div>
    <!-- Pagination -->
@endif



