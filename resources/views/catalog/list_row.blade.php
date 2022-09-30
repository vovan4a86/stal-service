<div class="catalog-list__row">
    <div class="catalog-list__grid">
        <div class="catalog-list__column catalog-list__column--one">
            <a href="{{ $item->url }}" title="{{ $item->name }}">
                <img class="catalog-list__picture lazy" src="/"
                     data-src="/static/images/common/preview.png"
                     alt="{{ $item->name }}"
                     width="112" height="61">
            </a>
        </div>
        <div class="catalog-list__column catalog-list__column--two">
            <a class="catalog-list__text" href="{{ $item->url }}">
                {{ $item->name }}</a>
        </div>
        <div class="catalog-list__column catalog-list__column--one">
            200х100х6
        </div>
        <div class="catalog-list__column catalog-list__column--one">L-5,06м</div>
        <div class="catalog-list__column catalog-list__column--two">
            <div class="catalog-list__actions">
                <div class="catalog-list__price">{{ $item->price }}
                    <span>руб. / {{ $item->measure }}</span>
                </div>
                <button class="catalog-list__add" type="button">
                    <svg class="svg-sprite-icon icon-cart">
                        <use xlink:href="/static/images/sprite/symbol/sprite.svg#cart"></use>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
