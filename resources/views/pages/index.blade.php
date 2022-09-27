@extends('template')
@section('content')
    <main>
        @include('blocks.main_slider')
        @if(count($offers))
            <section class="section offer">
                <div class="container">
                    <div class="section__links">
                        <h2 class="section__title">Спецпредложения</h2>
                        <a class="btn btn--outlined" href="{{ route('offers') }}">
                            <span>Все спецпредложения</span>
                            <svg class="svg-sprite-icon icon-arrow">
                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow"></use>
                            </svg>
                        </a>
                    </div>
                    <div class="offer__list">
                        @foreach($offers as $offer)
                            <div class="offer__item lazy" data-bg="/static/images/common/offer-1.png">
                                <div class="offer__content">
                                    <h3 class="offer__title">
                                        <a href="{{ $offer->url }}">{{ $offer->name }}</a>
                                    </h3>
                                    <p class="offer__description">{{ $offer->announce }}</p>
                                    <a class="offer__link link-offer" href="{{ $offer->url }}">
                                        <span class="link-offer__label">Подробнее</span>
                                        <span class="link-offer__icon">
                                                <svg class="svg-sprite-icon icon-arrow">
                                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow"></use>
                                                </svg>
                                            </span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <section class="section products">
            <div class="container">
                <div class="section__links">
                    <h2 class="section__title">Каталог продукциии</h2>
                    <a class="btn btn--outlined" href="{{ route('catalog.index') }}">
                        <span>Все категории</span>
                        <svg class="svg-sprite-icon icon-arrow">
                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow"></use>
                        </svg>
                    </a>
                </div>
                <ul class="products__list">
                    @foreach($main_catalog as $item)
                        @php
                            $wide = in_array($loop->iteration, [1,2,3]);
                        @endphp
                        <!-- --wide-->
                        <li class="products__item {{ $wide ? 'products__item--wide' : '' }}">
                            <a class="products__link" href="{{ $item->url }}" title="{{ $item->name }}">
                                <img class="products__picture lazy"
                                     data-src="{{ $wide ? $item->thumb(2) : $item->thumb(3) }}"
                                     src="{{ $wide ? $item->thumb(2) : $item->thumb(3) }}"
                                     alt="{{ $item->name }}" width="166" height="121">
                                <span class="products__row row-link">
                                        <span class="row-link__label">{{ $item->name }}</span>
                                        <span class="row-link__icon">
                                            <svg class="svg-sprite-icon icon-arrow">
                                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow"></use>
                                            </svg>
                                        </span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
        @include('blocks.tabs')
        @include('blocks.free_form')
        <!-- homepage ? '' : 'section--inner'-->
        @include('blocks.about')
        @include('blocks.slider_news')
        @include('blocks.question')
    </main>
@stop