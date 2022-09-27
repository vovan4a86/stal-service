<a class="header__cart cart-header" href="{{ route('cart') }}" title="В корзину">
    @if(count($items))
        <div class="cart-header__link">
            <svg class="svg-sprite-icon icon-cart">
                <use xlink:href="/static/images/sprite/symbol/sprite.svg#cart"></use>
            </svg>
            <span class="cart-header__badge">{{ count($items) }}</span>
        </div>
        <div class="cart-header__value">
            <div class="cart-header__count">{{ $count }}</div>
            <div class="cart-header__price" data-end="₽">{{ $sum }}</div>
        </div>
    @else
        <div class="cart-header__link">
            <svg class="svg-sprite-icon icon-cart">
                <use xlink:href="/static/images/sprite/symbol/sprite.svg#cart"></use>
            </svg>
            <span class="cart-header__badge">0</span>
        </div>
        <div class="cart-header__value">
            <div class="cart-header__count">Пусто</div>
            <div class="cart-header__price" data-end="₽">0</div>
        </div>
    @endif
</a>

{{--
<div class="h_cart" id="h_cart">
    @if(count($items))
        <div class="h_cart__sum h_cart--full">{{ $count }} <span>({{ $sum }} руб.)</span></div>
        <div class="h_cart__drop">
            <ul class="h_cart__list">
                @foreach($items as $item)
                    <li class="h_cart__item"><a href="{{ $item['url'] }}">
                            {{ $item['name'] }} × {{ $item['count'] }} шт.</a></li>
                @endforeach
            </ul>
            <div class="h_cart__tocart"><a href="/cart">Оформить заказ</a></div>
        </div>
    @else
        <div class="h_cart__sum">Корзина пуста</div>
    @endif
</div>
--}}