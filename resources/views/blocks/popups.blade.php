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
@include('blocks.cart_popup')
<div class="v-hidden" id="company" itemprop="branchOf" itemscope itemtype="https://schema.org/Corporation" aria-hidden="true" tabindex="-1">
    <article itemscope itemtype="https://schema.org/LocalBusiness" itemref="company">
        {!! Settings::get('schema.org') !!}
    </article>
</div>
