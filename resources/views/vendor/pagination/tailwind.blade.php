@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2 my-8">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-gray-100 dark:bg-gray-800/50 text-gray-400 dark:text-gray-600 cursor-not-allowed border border-transparent">
                <i class="fas fa-chevron-left text-sm"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-white dark:bg-[#151f32] text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white dark:hover:bg-primary hover:border-primary transition-all duration-300 shadow-sm border border-gray-100 dark:border-gray-800">
                <i class="fas fa-chevron-left text-sm"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="inline-flex items-center justify-center w-11 h-11 text-gray-400 dark:text-gray-500 font-medium">
                    {{ $element }}
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-primary text-white font-bold shadow-lg shadow-primary/30 border border-primary scale-110 transition-transform" aria-current="page">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-white dark:bg-[#151f32] text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white dark:hover:bg-primary hover:border-primary transition-all duration-300 shadow-sm border border-gray-100 dark:border-gray-800 font-medium">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-white dark:bg-[#151f32] text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white dark:hover:bg-primary hover:border-primary transition-all duration-300 shadow-sm border border-gray-100 dark:border-gray-800">
                <i class="fas fa-chevron-right text-sm"></i>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-gray-100 dark:bg-gray-800/50 text-gray-400 dark:text-gray-600 cursor-not-allowed border border-transparent">
                <i class="fas fa-chevron-right text-sm"></i>
            </span>
        @endif
    </nav>
@endif
