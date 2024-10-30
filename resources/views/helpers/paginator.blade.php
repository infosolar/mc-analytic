<nav>
    <ul class="pagination justify-content-end">
        @if($paginator->resolveCurrentPage() === 1)
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
            </li>
        @endif
        <li class="page-item"><span class="page-link">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span></li>
        @if($paginator->resolveCurrentPage() === $paginator->lastPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
            </li>
        @endif
    </ul>
</nav>
