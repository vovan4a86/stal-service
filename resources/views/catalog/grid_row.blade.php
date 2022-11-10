<div class="catalog-list__card">
    <!-- card-->
    <div class="card swiper-slide">
        @if($item->is_action)
            <div class="card__badge">%</div>
        @endif
        <a class="card__preview" href="{{ $item->url }}" title="Арматура 12 11.7м А500 34028-16">
            <img class="card__picture lazy entered loaded" src="/static/images/common/cat-7.png"
                 data-src="/static/images/common/cat-7.png" width="200" height="130" alt="Арматура 12 11.7м А500 34028-16">
        </a>
        <div class="card__status">
            <div class="product-status product-status--instock">
                В наличии
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.4375 2.81274L4.0625 7.18755L1.875 5.00024" stroke="#52AA52" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

            </div>
        </div>
        <h3 class="card__title">
            <a href="javascript:void(0)">Арматура 12 11.7м А500 34028-16</a>
        </h3>
        <div class="card__price price-card">
            <span class="price-card__label">Цена:</span>
            <span class="price-card__value">400 ₽</span>
            <span class="price-card__counts">/ шт.</span>
        </div>
            @include('cart.card_actions')
    </div>
</div>
