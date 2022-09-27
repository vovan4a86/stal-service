@extends('template')
@section('content')
    @include('blocks.bread')
    <!-- homepage ? '' : 'section--inner'-->
    <section class="section search-page {{ Request::url() === '/' ? '' : 'section--inner' }}">
        <div class="container">
            <h2 class="section__title section__title--inner">Результат поиска «{{ $data }}»</h2>
            @if(count($items))
                <div class="search-page__list">
                    @foreach($items as $item)
                        <div class="search-page__item card">
                        <div class="card__badge">%</div>
                        <a class="card__preview" href="{{ $item->url }}" title="{{ $item->name }}">
                            <img class="card__picture lazy" src="{{ $item->image ?? $item->showCategoryImage($item->catalog_id) }}"
                                 data-src="{{ $item->image ?? $item->showCategoryImage($item->catalog_id) }}" alt="{{ $item->name }}">
                        </a>
                            <div class="card__status">
                                @if($item->in_stock)
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
                                <a href="{{ $item->url }}">{{ $item->name }}</a>
                            </h3>
                            <div class="card__price price-card">
                                <span class="price-card__label">Цена:</span>
                                <span class="price-card__value">{{ $item->price }} ₽</span>
                                <span class="price-card__counts">/ {{ $item->measure }}</span>
                            </div>
                        <div class="card__actions">
                            <button class="btn" type="button" aria-label="Купить">
                                <span>Купить</span>
                            </button>
                            <button class="card__cart" type="button" aria-label="Добавить в корзину">
                                <svg class="svg-sprite-icon icon-cart">
                                    <use xlink:href="static/images/sprite/symbol/sprite.svg#cart"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="search-page__list">
                    <h4>Ничего не найдено</h4>
                </div>
            @endif
        </div>
    </section>
    </main>
@endsection