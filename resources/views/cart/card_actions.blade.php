<div class="card__actions">
    <button class="btn" type="button" data-product-id="{{ $product->id }}" aria-label="Купить">
        <span>Купить</span>
    </button>
    <button class="card__cart @if($in_cart = $product->in_cart) btn--added @endif" type="button"
            aria-label="Добавить в корзину" data-product-id="{{ $product->id }}">
        <svg class="svg-sprite-icon icon-cart">
            <use xlink:href="/static/images/sprite/symbol/sprite.svg#cart"></use>
        </svg>
    </button>
</div>