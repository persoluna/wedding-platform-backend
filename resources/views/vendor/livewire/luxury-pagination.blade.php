@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-6 md:gap-12 w-full max-w-3xl mt-12 mb-8">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="btn-ghost opacity-50 cursor-not-allowed pointer-events-none px-6 py-3 rounded-full text-sm">
                Previous
            </span>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled" class="btn-ghost px-6 py-3 rounded-full text-sm hover:scale-105">
                Previous
            </button>
        @endif

        {{-- Pagination Elements --}}
        <div class="hidden md:flex gap-2">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-10 h-10 flex items-center justify-center text-black/40">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center rounded-full bg-navy-900 text-white font-medium shadow-lg">{{ $page }}</span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" class="w-10 h-10 flex items-center justify-center rounded-full text-navy-900 hover:bg-champagne-100 hover:text-champagne-700 transition-colors font-medium">{{ $page }}</button>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled" class="btn-ghost px-6 py-3 rounded-full text-sm hover:scale-105">
                Next
            </button>
        @else
            <span class="btn-ghost opacity-50 cursor-not-allowed pointer-events-none px-6 py-3 rounded-full text-sm">
                Next
            </span>
        @endif
    </nav>
@endif
