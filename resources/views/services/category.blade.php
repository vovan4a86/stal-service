@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <div class="container services__container">
            <h1>{{ $category->name }}</h1>

            <img src="{{ $category->thumb(2) }}">
            <hr>

            {!! $category->text !!}
        </div>
    </main>
@endsection