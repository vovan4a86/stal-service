<!DOCTYPE html>
<html lang="ru">
@include('blocks.head')
<body class="no-scroll {{ $pageClass ?? '' }}">
    {!! Settings::get('counters') !!}
    @include('blocks.preloader')
    @include('blocks.header')
    @include('blocks.overlay')

    @yield('content')

    @include('blocks.footer')
    @include('blocks.cookie')
    @include('blocks.popups')

</body>
</html>
