<div class="popup" id="confirm" style="display: none">
    <div class="popup__confirm">
        <svg width="60" height="60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="30" cy="30" r="30" fill="#0F5ADB" />
            <path d="M41 23 27 37l-7-7" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="popup__alert">Ваша заявка отправлена. Наши специалисты свяжутся с вами в ближайшее время. Спасибо!</div>
    </div>
</div>
<form class="popup" id="callback" action="{{ route('ajax.callback') }}" onsubmit="sendCallback(this,event)" style="display: none">
    <div class="popup__title">Обратный звонок</div>
    <div class="popup__fields">
        <label class="popup__label">Имя *
            <input class="popup__input" type="text" name="name" placeholder="Представьтесь пожалуйста" required>
        </label>
        <label class="popup__label">Ваш телефон *
            <input class="popup__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" required>
        </label>
        <label class="popup__label">Удобное время
            <input class="popup__input" type="text" name="time" placeholder="с 8 до 18">
        </label>
    </div>
    <div class="popup__checkbox">
        <label class="checkbox">
            <input class="checkbox__input" type="checkbox" name="policy" checked required>
            <span class="checkbox__box"></span>
            <span class="checkbox__policy">Согласен на
						<a href="/_ajax-policy.html" data-fancybox data-type="ajax">обработку персональных данных</a>
					</span>
        </label>
    </div>
    <div class="popup__action">
        <button class="btn btn--small">
            <span>Отправить</span>
        </button>
    </div>
</form>
<form class="popup" id="message" action="{{ route('ajax.writeback') }}" onsubmit="sendWriteback(this,event)" style="display: none">
    <div class="popup__subtitle">Отправьте заявку в свободной форме, наши менеджеры сформируют предложение по вашему запросу</div>
    <div class="popup__fields">
        <label class="popup__label">Имя *
            <input class="popup__input" type="text" name="name" placeholder="Представьтесь пожалуйста" required>
        </label>
        <label class="popup__label">Ваш телефон *
            <input class="popup__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" required>
        </label>
        <label class="popup__label">Ваше сообщение
            <textarea class="popup__input" name="text" placeholder="Напишите сообщение" rows="4"></textarea>
        </label>
    </div>
    <div class="popup__checkbox">
        <label class="checkbox">
            <input class="checkbox__input" type="checkbox" name="policy" checked required>
            <span class="checkbox__box"></span>
            <span class="checkbox__policy">Согласен на
						<a href="/_ajax-policy.html" data-fancybox data-type="ajax">обработку персональных данных</a>
					</span>
        </label>
    </div>
    <div class="popup__action">
        <button class="btn btn--small">
            <span>Отправить</span>
        </button>
    </div>
</form>
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
<div class="v-hidden" id="company" itemprop="branchOf" itemscope itemtype="https://schema.org/Corporation" aria-hidden="true" tabindex="-1">
    <article itemscope itemtype="https://schema.org/LocalBusiness" itemref="company">
        {!! Settings::get('schema.org') !!}
    </article>
{{--    <article itemscope itemtype="https://schema.org/LocalBusiness" itemref="company">--}}
{{--        <div itemprop="name">Наименование организации--}}
{{--            <img itemprop="image" src="https://example.com/static/images/common/logo.svg" alt="logo">--}}
{{--            <a itemprop="url" href="https://example.com"></a>--}}
{{--            <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">--}}
{{--                <span itemprop="addressCountry">Россия</span>--}}
{{--                <span itemprop="addressRegion">Свердловская обл.</span>--}}
{{--                <span itemprop="postalCode">624350</span>--}}
{{--                <span itemprop="addressLocality">г. Качканар</span>--}}
{{--                <span itemprop="streetAddress">ул. Свердлова, 1/5</span>--}}
{{--            </div>--}}
{{--            <div itemprop="email">info@example.com</div>--}}
{{--            <div itemprop="telephone">+74952222222</div>--}}
{{--            <div itemprop="priceRange">RUB</div>--}}
{{--            <div itemprop="openingHours" content="Mo-Fr 9:00−18:00">Пн.-Пт.: 9.00-18.00 Сб., Вс.: выходной</div>--}}
{{--        </div>--}}
{{--    </article>--}}
</div>