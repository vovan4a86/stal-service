<div class="popup-order popup popup--order" id="edit-order" style="display: none">
    <div class="popup-order__head">
        <div class="popup-order__title" data-popup-title></div>
        <div class="popup-order__status">
            <div class="product-status product-status--instock">
                В наличии
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.4375 2.81274L4.0625 7.18755L1.875 5.00024" stroke="#52AA52" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

            </div>
        </div>
        <div class="popup-order__price">Цена
            <span data-popup-price data-end="₽ / т"></span>
        </div>
    </div>
    <div class="popup-order__fields">
        <div class="popup-order__field">
            <label class="popup-order__label">Длина, м
                <input class="popup-order__input" type="number" name="length" value="5" required data-popup-length>
            </label>
        </div>
        <div class="popup-order__field">
            <label class="popup-order__label">Кол-во, шт
                <input class="popup-order__input" type="number" name="count" value="1" required data-popup-count>
            </label>
        </div>
        <div class="popup-order__field">
            <label class="popup-order__label">Кол-во, т
                <input class="popup-order__input" type="number" name="weight" value="1" required data-popup-weight>
            </label>
        </div>
        <div class="popup-order__value">
            <label class="popup-order__label">На сумму, ₽
                <input class="popup-order__input" type="text" name="total" data-popup-total disabled>
            </label>
        </div>
    </div>
    <div class="popup-order__stats">
        <div class="popup-order__weights">Общий вес продукции: 1 т</div>
        <div class="popup-order__total-value">
            <span>Итого</span>
            <div class="popup-order__summary" data-end="₽" data-popup-summary></div>
        </div>
    </div>
    <div class="popup-order__action">
        <button class="btn btn--content" type="button">
            <span>Обновить</span>
        </button>
    </div>
</div>
