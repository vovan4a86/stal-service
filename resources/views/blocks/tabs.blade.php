<section class="section tabs" data-tabs>
    <div class="container tabs__container">
        <div class="tabs__nav">
            <div class="tabs__link is-active" data-open="discount">Товары по акции</div>
            <div class="tabs__link" data-open="popular">Популярные товары</div>
        </div>
        <div class="tabs__views">
            <!-- view discount-->
            <div class="tabs__view is-active" data-view="discount">
                <h2 class="v-hidden">Товары по акции</h2>
                <!-- slider nav-->
                <div class="slider-nav">
                    <div class="slider-nav__icon slider-nav__prev" data-discount-prev>
                        <svg class="svg-sprite-icon icon-arrow-prev">
                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow-prev"></use>
                        </svg>
                    </div>
                    <div class="slider-nav__icon slider-nav__next" data-discount-next>
                        <svg class="svg-sprite-icon icon-arrow">
                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow"></use>
                        </svg>
                    </div>
                </div>
                <!-- slider-->
                <div class="tabs__slider swiper" data-discount-slider>
                    <div class="tabs__wrapper swiper-wrapper">
                        <!-- slide-->
                        @foreach($action_products as $product)
                            {{--                                    @dd($product->showCategoryImage(1))--}}
                            <div class="card swiper-slide">
                                <div class="card__badge">%</div>
                                <a class="card__preview" href="{{ $product->url }}" title="{{ $product->name }}">
                                    <img class="card__picture swiper-lazy"
                                         src="{{ $product->image ?? $product->showCategoryImage($product->catalog_id) }}"
                                         data-src="{{ $product->image ?? $product->showCategoryImage($product->catalog_id) }}"
                                         alt="{{ $product->name }}" />
                                </a>
                                <div class="card__status">
                                    @if($product->in_stock)
                                        <div class="product-status product-status--instock">
                                            В наличи
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.4375 2.81274L4.0625 7.18755L1.875 5.00024" stroke="#52AA52" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="product-status product-status--out-stock">Под заказ</div>
                                    @endif
                                </div>
                                <h3 class="card__title">
                                    <a href="{{ $product->url }}">{{ $product->name }}</a>
                                </h3>
                                <div class="card__price price-card">
                                    <span class="price-card__label">Цена:</span>
                                    <span class="price-card__value">{{ $product->price }} ₽</span>
                                    <span class="price-card__counts">/ {{ $product->measure }}</span>
                                </div>
                                <div class="card__actions">
                                    <button class="btn" type="button" aria-label="Купить">
                                        <span>Купить</span>
                                    </button>
                                    <button class="card__cart @if($in_cart = $product->in_cart) btn--added @endif" type="button" aria-label="Добавить в корзину" data-product-id="{{ $product->id }}">
                                        <svg class="svg-sprite-icon icon-cart">
                                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#cart"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- view popular-->
            <div class="tabs__view" data-view="popular">
                <h2 class="v-hidden">Популярные товары</h2>
                <!-- slider nav-->
                <div class="slider-nav">
                    <div class="slider-nav__icon slider-nav__prev" data-popular-prev>
                        <svg class="svg-sprite-icon icon-arrow-prev">
                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow-prev"></use>
                        </svg>
                    </div>
                    <div class="slider-nav__icon slider-nav__next" data-popular-next>
                        <svg class="svg-sprite-icon icon-arrow">
                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow"></use>
                        </svg>
                    </div>
                </div>
                <!-- slider-->
                <div class="tabs__slider swiper" data-popular-slider>
                    <div class="tabs__wrapper swiper-wrapper">
                        <!-- slide-->
                        @foreach($popular_products as $product)
                            <div class="card swiper-slide">
                                <div class="card__badge">%</div>
                                <a class="card__preview" href="{{ $product->url }}" title="{{ $product->name }}">
                                    <img class="card__picture swiper-lazy"
                                         src="{{ $product->image ?? $product->showCategoryImage($product->catalog_id) }}"
                                         data-src="{{ $product->image ?? $product->showCategoryImage($product->catalog_id) }}"
                                         alt="{{ $product->name }}" />
                                </a>
                                <div class="card__status">
                                    @if($product->in_stock)
                                        <div class="product-status product-status--instock">
                                            В наличи
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.4375 2.81274L4.0625 7.18755L1.875 5.00024" stroke="#52AA52" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="product-status product-status--out-stock">Под заказ</div>
                                    @endif
                                </div>
                                <h3 class="card__title">
                                    <a href="{{ $product->url }}">{{ $product->name }}</a>
                                </h3>
                                <div class="card__price price-card">
                                    <span class="price-card__label">Цена:</span>
                                    <span class="price-card__value">{{ $product->price }} ₽</span>
                                    <span class="price-card__counts">/ шт.</span>
                                </div>
                                <div class="card__actions">
                                    <button class="btn" type="button" aria-label="Купить">
                                        <span>Купить</span>
                                    </button>
                                    <button class="card__cart" type="button" aria-label="Добавить в корзину">
                                        <svg class="svg-sprite-icon icon-cart">
                                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#cart"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
