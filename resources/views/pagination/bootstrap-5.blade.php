@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true" style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.2); color: var(--text-secondary); background: rgba(0, 102, 255, 0.05);">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')" style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.3); color: #0066ff; background: rgba(255, 255, 255, 0.9); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(0, 102, 255, 0.1)'; this.style.borderColor='rgba(0, 102, 255, 0.5)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 102, 255, 0.2)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.borderColor='rgba(0, 102, 255, 0.3)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.2); color: var(--text-secondary); background: rgba(0, 102, 255, 0.05);">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link" style="border-radius: 12px; border: 2px solid rgba(0, 102, 255, 0.6); background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.2)); color: #0066ff; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}" style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.3); color: #0066ff; background: rgba(255, 255, 255, 0.9); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(0, 102, 255, 0.1)'; this.style.borderColor='rgba(0, 102, 255, 0.5)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 102, 255, 0.2)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.borderColor='rgba(0, 102, 255, 0.3)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.3); color: #0066ff; background: rgba(255, 255, 255, 0.9); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(0, 102, 255, 0.1)'; this.style.borderColor='rgba(0, 102, 255, 0.5)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 102, 255, 0.2)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.borderColor='rgba(0, 102, 255, 0.3)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true" style="border-radius: 12px; border: 1px solid rgba(0, 102, 255, 0.2); color: var(--text-secondary); background: rgba(0, 102, 255, 0.05);">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

