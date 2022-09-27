@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <!-- homepage ? '' : 'section--inner'-->
        <section class="sale section {{ Request::url() === '/' ? '' : 'section--inner' }}">
            <div class="sale__container container">
                <h2 class="section__title">{{ $action->name }}</h2>
                <div class="sale__head text-content">
                    {!! $action->text_before !!}
                </div>
                <div class="sale__content">
                    <h3 class="sale__subtitle">{{ $action->subtitle }}</h3>
                    @if(count($action_products))
                        @foreach($action_products as $cat_name => $prods)
                            <h4 class="sale__category">{{ $cat_name }}</h4>
                            <div class="sale__grid">
                                @foreach($prods as $prod)
                                    <div class="sale__card">
                                    <!-- card-->
                                    <div class="card swiper-slide">
                                        <div class="card__badge">%</div>
                                        <a class="card__preview" href="{{ $prod->url }}" title="{{ $prod->name }}">
                                            <img class="card__picture lazy" src="{{ $prod->url }}"
                                                 data-src="{{ $prod->showCategoryImage($prod->catalog_id) }}" width="200" height="130"
                                                 alt="Арматура 12 11.7м А500 34028-16" />
                                        </a>
                                        <div class="card__status">
                                            @if($prod->in_stock)
                                                <div class="product-status product-status--instock">
                                                    В наличии
                                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8.4375 2.81274L4.0625 7.18755L1.875 5.00024" stroke="#52AA52" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="product-status product-status--out-stock">Под заказ</div>
                                            @endif
                                        </div>
                                        <h3 class="card__title">
                                            <a href="{{ $prod->url }}">{{ $prod->name }}</a>
                                        </h3>
                                        <div class="card__price price-card">
                                            <span class="price-card__label">Цена:</span>
                                            <span class="price-card__value">{{ $prod->price }} ₽</span>
                                            <span class="price-card__counts">/ {{ $prod->measure }}</span>
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
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="section__text text-content">
                    {!! $action->text_after !!}
                </div>
            </div>
        </section>
    </main>
@endsection