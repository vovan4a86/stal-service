<div class="cart__values">
    <div class="cart-data">
        <div class="cart-data__subtitle">Ваш заказ</div>
        <div class="cart-data__weight">Общий вес заказа: - т</div>
        <div class="cart-data__prices">
            <div class="cart-data__price">
                <dl>
                    <dt>Сумма:</dt>
                    <dd data-currency="₽">{{ $sum }}</dd>
                </dl>
            </div>
            <div class="cart-data__price">
                <dl>
                    <dt>Итого:</dt>
                    <dd data-currency="₽">{{ $sum }}</dd>
                </dl>
            </div>
        </div>
        <ul class="cart-data__labels">
            <li class="cart-data__label">* Все цены с учетом НДС</li>
            <li class="cart-data__label">* Окончательную стоимость заказа Вам сообщит
                менеджер.
            </li>
        </ul>
        <div class="cart-data__action">
            <button class="btn btn--content" type="button" data-proceed-order>
                <span>Оформить заказ</span>
            </button>
        </div>
    </div>
</div>
