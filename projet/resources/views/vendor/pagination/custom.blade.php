@if ($paginator->hasPages())
    <div class="pagination-wrapper">
        {{-- Bouton Précédent --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-btn disabled">
                <i class="ri-arrow-left-s-line"></i> Précédent
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn">
                <i class="ri-arrow-left-s-line"></i> Précédent
            </a>
        @endif

        {{-- Info page --}}
        <span class="pagination-info">
            Page {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
        </span>

        {{-- Bouton Suivant --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn">
                Suivant <i class="ri-arrow-right-s-line"></i>
            </a>
        @else
            <span class="pagination-btn disabled">
                Suivant <i class="ri-arrow-right-s-line"></i>
            </span>
        @endif
    </div>
@endif
