@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <!-- homepage ? '' : 'section--inner'-->
        <section class="section {{ Request::url() === '/' ? '' : 'section--inner' }}">
            <div class="container">
                <div class="section__links">
                    <h2 class="section__title">{{ $h1 }}</h2>
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