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
                @if($is_subcategory)
                    <div class="catalog__links">
                        <nav class="subcategories">
                            <ul class="subcategories__list">
                                <li class="subcategories__item">
                                    <a class="subcategories__link" href="javascript:void(0)"
                                       title="Показать все">Показать все</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="catalog__update">
                            <span>Цены обновлены 06.08.2022</span>
                        </div>
                    </div>
                @else
                    @if(count($children))
                        <ul class="sublinks">
                            @foreach($children as $child)
                                <li class="sublinks__item">
                                    <a class="sublinks__link sublink" href="{{ $child->url }}"
                                       title="{{ $child->name }}">
                                        <img class="sublink__picture lazy" src="/"
                                             data-src="/static/images/common/cat-c8.png" alt="" width="64" height="34">
                                        <span class="sublink__title">{{ $child->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="catalog__update">
                        <span>Цены обновлены 06.08.2022</span>
                    </div>
                @endif

            <!-- class=(catalogSubCatalogGrid ? 'catalog-list--grid' : '' )-->
                {!! $items !!}
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
