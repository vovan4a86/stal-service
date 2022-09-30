<ul class="pagination__list">
    <!-- Ссылка на предыдущую страницу -->
{{--    @if ($paginator->onFirstPage())--}}
{{--        <li class="pagination__item">--}}
{{--            <span>&laquo;</span>--}}
{{--        </li>--}}
{{--    @else--}}
{{--        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>--}}
{{--    @endif--}}

<!-- Элементы страничной навигации -->
    @foreach ($elements as $element)
    <!-- Разделитель "Три точки" -->
{{--        @if (is_string($element))--}}
{{--            <li class="disabled"><span>{{ $element }}</span></li>--}}
{{--        @endif--}}

    <!-- Массив ссылок -->
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="pagination__item">
                        <span class="pagination__link pagination__link--current">{{ $page }}</span>
                    </li>
                @else
                    <li class="pagination__item">
                        <a class="pagination__link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach
        @endif
    @endforeach

<!-- Ссылка на следующую страницу -->
    @if ($paginator->hasMorePages())
        <li class="pagination__item">
            <a class="pagination__link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                <svg class="svg-sprite-icon icon-triangle">
                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#triangle"></use>
                </svg>
            </a>
        </li>
    @else
        <li class="pagination__item disabled">
            <span class="pagination__link">
                <svg class="svg-sprite-icon icon-triangle">
                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#triangle"></use>
                </svg>
            </span>
        </li>
    @endif
</ul>
