@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between py-4">
        {{-- Small screens: فقط دکمه‌های قبلی/بعدی --}}
        <div class="flex-1 flex items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 rounded-md" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 rounded-md hover:underline" aria-label="{{ __('pagination.previous') }}">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 rounded-md hover:underline" aria-label="{{ __('pagination.next') }}">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 rounded-md" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Larger screens: شماره صفحات --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md" dir="rtl">
                    {{-- previous --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium rounded-l-md">
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium rounded-l-md hover:underline">
                            {!! __('pagination.previous') !!}
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true" class="relative inline-flex items-center px-3 py-2 text-sm font-medium">
                                {{ $element }}
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="border border-zinc-100 text-sm md:text-base px-3.5 md:px-4 py-2 mx-1 transition-colors duration-300 transform bg-blue-500 text-white rounded-md">
                                        {{-- اگر خواستید ارقام فارسی کنید، از تابع تبدیل زیر استفاده کنید --}}
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="border border-zinc-100 text-sm md:text-base px-3.5 md:px-4 py-2 mx-1 text-gray-700 transition-colors duration-300 transform bg-white rounded-md hover:bg-blue-500 hover:text-white" aria-label="صفحه {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium rounded-r-md hover:underline">
                            {!! __('pagination.next') !!}
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium rounded-r-md">
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
