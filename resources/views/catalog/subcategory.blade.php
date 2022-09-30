@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <!-- homepage ? '' : 'section--inner'-->
        <section class="catalog section {{ Request::url() === '/' ? '' : 'section--inner' }}">
            <div class="catalog__container container">
                <h2 class="section__title">{{ $h1 }}</h2>
                <div class="catalog__text text-content">
                    {!! $category->announce !!}
                </div>
                @if(count($children))
                    <div class="catalog__links">
                        <nav class="subcategories">
                            <ul class="subcategories__list">
                                <li class="subcategories__item">
                                    <a class="subcategories__link" href="#" title="Показать все">Показать все</a>
                                </li>
                                @foreach($children as $child)
                                    <li class="subcategories__item">
                                        <a class="subcategories__link" href="{{ $child->url }}" title="{{ $child->name }}">{{ $child->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                        <div class="catalog__update">
                            <span>Цены обновлены 06.08.2022</span>
                        </div>
                    </div>
                @endif
                <!-- class=(catalogSubCatalogGrid ? 'catalog-list--grid' : '' )-->
                <div class="catalog-list catalog-list--grid">
                    <div class="catalog-list__top">
                        <div class="togglers">
                            <a class="togglers__toggle" href="javascript:void(0)" title="Вид сетка">
                                <svg class="svg-sprite-icon icon-grid-view">
                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#grid-view"></use>
                                </svg>
                            </a>
                            <a class="togglers__toggle togglers__toggle--active" href="javascript:void(0)"
                               title="Вид список">
                                <svg class="svg-sprite-icon icon-list-view">
                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#list-view"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="catalog-list__content">
                        <div class="catalog-list__head">
                            <div class="catalog-list__filter" data-filter-show>
                                <svg class="svg-sprite-icon icon-option">
                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#option"></use>
                                </svg>
                                <span>Показать фильтр</span>
                            </div>
                            <div class="catalog-list__hidden" data-filter-content>
                                <div class="catalog-list__grid catalog-list__grid--filters">
                                    <div class="catalog-list__column catalog-list__column--one">
                                        <div class="catalog-list__label">Фото</div>
                                    </div>
                                    <div class="catalog-list__column catalog-list__column--two">
                                        <div class="catalog-list__label">Наименование</div>
                                    </div>
                                    <div class="catalog-list__column catalog-list__column--one catalog-list__column--filter">
                                        <!-- https://slimselectjs.com/options-->
                                        <!-- js--sources/modules/select.js-->
                                        <select class="catalog-select" name="width" multiple>
                                            <option data-placeholder="true">Ширина</option>
                                            <option value="0.8м">0.8м</option>
                                            <option value="0.902м">0.902м</option>
                                            <option value="1.047м">1.047м</option>
                                            <option value="1.057м">1.057м</option>
                                            <option value="1.06м">1.06м</option>
                                            <option value="1.155м">1.155м</option>
                                            <option value="1.15м">1.15м</option>
                                            <option value="1.2м">1.2м</option>
                                        </select>
                                    </div>
                                    <div class="catalog-list__column catalog-list__column--one catalog-list__column--filter">
                                        <select class="catalog-select" name="size" multiple>
                                            <option data-placeholder="true">Толщина</option>
                                            <option value="0.35">0.35</option>
                                            <option value="0.4">0.4</option>
                                            <option value="0.45">0.45</option>
                                            <option value="0.45 ТУ">0.45 ТУ</option>
                                            <option value="0.5">0.5</option>
                                            <option value="0.55">0.55</option>
                                            <option value="0.65">0.65</option>
                                            <option value="0.7">0.7</option>
                                            <option value="0.8">0.8</option>
                                            <option value="0.9">0.9</option>
                                        </select>
                                    </div>
                                    <div class="catalog-list__column catalog-list__column--two">
                                        <div class="catalog-list__label">Цена</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(count($products))
                            <div class="catalog-list__products">
                                @foreach($products as $item)
                                    @include('catalog.list_row')
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="catalog-list__footer">
                        <nav class="pagination">
                        {{ $products->links('catalog.page_nav') }}
                        </nav>
                        <div class="catalog-list__show">
                            <input type="hidden" name="curpage" id="curpage" value="{{ url()->full() }}">
                            <span>Показывать</span>
                            <select class="catalog-list__pages" name="pages" onchange="numberProducts(this)">
                                @foreach(Settings::get('prods_per_page') as $option)
                                    @if($loop->first)
                                    <option data-placeholder="true">10</option>
                                    @endif
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="section__text text-content">
                    {!! $category->text !!}
                </div>
            </div>
        </section>
    </main>
@endsection
