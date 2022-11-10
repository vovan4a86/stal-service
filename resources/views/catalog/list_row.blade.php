<div class="catalog-list__row">
    <div class="catalog-list__grid">
        <div class="catalog-list__column catalog-list__column--one">
            @php
                $image = $item->images()->get();
            @endphp
            <a href="{{ $item->url }}" title="{{ $item->name }}">
                <img class="catalog-list__picture" src="{{ count($image) ? $image[0]->thumb(2) : $item->getRootImage() }}"
                     data-src="{{ count($image) ? $image[0]->thumb(2) : $item->getRootImage() }}"
                     alt="{{ $item->name }}"
                     width="112" height="61">
            </a>
        </div>
        <div class="catalog-list__column catalog-list__column--two">
            <a class="catalog-list__text" href="{{ $item->url }}">
                {{ $item->name }}</a>
        </div>
        <div class="catalog-list__column catalog-list__column--one">
            @php
                if(count($filters)) {
                    $alias = $filters[0]->alias;
                } else { $alias = null; }
            @endphp
            {{ $item->$alias ?? '' }}
        </div>
        <div class="catalog-list__column catalog-list__column--one">
            @php
                if(count($filters)) {
                    $alias = $filters[1]->alias;
                } else { $alias = null; }
            @endphp
            {{ $item->$alias ?? '' }}
        </div>
        <div class="catalog-list__column catalog-list__column--two">
            <div class="catalog-list__actions">
                <div class="catalog-list__price">{{ number_format($item->multiplyPrice($item->price), 2, ',', '') }}
                    <span>руб. / {{ $item->measure }}</span>
                </div>
                <button class="catalog-list__add" type="button" aria-label="Добавить в корзину"
                        data-product-id="{{ $item->id }}">
                    <svg class="svg-sprite-icon icon-cart">
                        <use xlink:href="/static/images/sprite/symbol/sprite.svg#cart"></use>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
