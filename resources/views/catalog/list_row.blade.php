<div class="catalog-list__row">
    <div class="catalog-list__grid">
        <div class="catalog-list__column catalog-list__column--one">
            @php
                $item_images = $item->images()->get();
            @endphp
            <a href="{{ $item->url }}" title="{{ $item->name }}">
                <img class="catalog-list__picture lazy" src="/"
                     data-src="{{ count($item_images) ? \Fanky\Admin\Models\ProductImage::UPLOAD_URL . $item_images[0]->image :
                                                        \Fanky\Admin\Models\Catalog::UPLOAD_URL . $root->image }}"
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
                $alias = $filters[0]->alias;
            @endphp
            {{ $item->$alias }}{{ $filters[0]->measure }}

        </div>
        <div class="catalog-list__column catalog-list__column--one">
            @php
                $alias = $filters[1]->alias;
            @endphp
            {{ $item->$alias }}{{ $filters[1]->measure }}
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
