@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <!-- homepage ? '' : 'section--inner'-->
        <section class="section vacancy {{ Request::url() === '/' ? '' : 'section--inner' }}">
            <div class="container">
                <h2 class="section__title section__title--inner">Вакансии</h2>
                {!! $text !!}
            </div>
        </section>
    </main>
@endsection