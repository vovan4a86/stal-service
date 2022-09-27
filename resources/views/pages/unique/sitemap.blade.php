@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <!-- homepage ? '' : 'section--inner'-->
        <section class="section sitemap {{ Request::url() === '/' ? '' : 'section--inner' }}">
            <div class="container">
                <h2 class="section__title section__title--inner">Карта сайта</h2>
                <ul class="sitemap__list">
                    <li>
                        <a href="{{ route('main') }}">Главная</a>
                        @foreach($sitemap as $item)
                            <ul class="sitemap__middle sitemap__middle--grid">
                                <li>
                                    <a href="{{ $item->url }}">{{ $item->name }}</a>
                                    @if($children = $item->getPublicChildren())
                                        @foreach($children as $child)
                                            <ul class="sitemap__small">
                                                <li>
                                                    <a href="{{ $child->url }}">{{ $child->name }}</a>
                                                </li>
                                            </ul>
                                        @endforeach
                                    @endif
                                </li>
                            </ul>
                        @endforeach
                    </li>
                </ul>
            </div>
        </section>
    </main>
@stop