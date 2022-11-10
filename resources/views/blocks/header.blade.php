<header class="header">
    <div class="header__top">
        <div class="container header__container">
            <div class="header__column">
                <a class="header__logo logo" href="{{ route('main') }}" title="Сталь Сервис">
                    <img class="lazy" data-src="/static/images/common/logo.svg" src="/" alt="Сталь Сервис" width="409" height="49">
                </a>
                <div class="header__city city">
                    <a class="city__label" href="{{ route('ajax.show-popup-cities') }}" data-fancybox data-type="ajax">
                        @if(isset($current_city) && $current_city)г. {{ $current_city->name }}@else Екатеринбург@endif
                        <svg class="svg-sprite-icon icon-dropdown">
                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#dropdown"></use>
                        </svg>
                    </a>
                    <div class="city__dialog dialog-city" data-city-dialog>
                        <div class="dialog-city__label">Ваш город
                            <span>@if(isset($current_city) && $current_city)г. {{ $current_city->name }}@else
                                    Екатеринбург@endif
                            </span>?
                        </div>
                        <div class="dialog-city__actions">
                            <button class="dialog-city__action dialog-city__action--confirm"
                                    type="button" data-city-confirm="confirm"
                                    aria-label="Подтвердить город Екатеринбург"
                                    data-id="{{ ($current_city)? $current_city->id: 0 }}"
                                    data-cur_url="{{ Request::path() }}"
                                    data-confirm-region>
                                <span>Да</span>
                            </button>
                            <a class="dialog-city__action dialog-city__action--change"
                                    href="{{ route('ajax.show-popup-cities') }}"
                                    title="Изменить регион"
                                    type="button" data-src="{{ route('ajax.show-popup-cities') }}"
                                    data-fancybox data-type="ajax" data-city-change="change"
                                    aria-label="Изменить текущий город"
                                   >
                                <span>Нет, другой</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header__column">
                <a class="header__send" href="#message" data-popup title="Написать нам">
                    <svg class="svg-sprite-icon icon-email">
                        <use xlink:href="/static/images/sprite/symbol/sprite.svg#email"></use>
                    </svg>
                    <span>Написать нам</span>
                </a>
                <a class="header__send" href="#callback" data-popup title="Заказать звонок">
                    <svg class="svg-sprite-icon icon-phone">
                        <use xlink:href="/static/images/sprite/symbol/sprite.svg#phone"></use>
                    </svg>
                    <span>Заказать звонок</span>
                </a>
                <a class="header__phone" href="tel:+{{ preg_replace('/[^\d]+/', '', Settings::get('header_phone')) }}">{{ Settings::get('header_phone') }}</a>
                <button class="header__hamburger hamburger hamburger--collapse" aria-label="Мобильное меню" data-open-overlay>
							<span class="hamburger-box">
								<span class="hamburger-inner"></span>
							</span>
                </button>
            </div>
        </div>
    </div>
    <div class="header__content">
        <div class="container header__container">
            <div class="header__column">
                <div class="header__catalog" title="Каталог продукции" aria-label="Каталог продукции">
                    <svg class="svg-sprite-icon icon-list">
                        <use xlink:href="/static/images/sprite/symbol/sprite.svg#list"></use>
                    </svg>
                    <span>Каталог продукции</span>
                    <div class="catalog-header" tabindex="-1">
                        <!-- data-nav-tabs-->
                        <div class="catalog-header__content" data-nav-tabs>
                            <div class="catalog-header__nav">
                                @foreach($catalogTop as $topItem)
                                        <a class="catalog-header__link {{ $loop->iteration == 1 ? 'is-active' : '' }}"
                                       href="{{$topItem->url}}" title="{{ $topItem->name }}"
                                       data-open="{{ $loop->iteration }}">
                                        <span>{{ $topItem->name }}</span>
                                        @if(count($topItem->getAllPublicChildren()))
                                            <svg class="svg-sprite-icon icon-caret">
                                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#caret"></use>
                                            </svg>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                            @foreach($catalogTop as $topItem)
                                @if(count($subItems = $topItem->getAllPublicChildren()))
                                    <div class="catalog-header__products {{ $loop->iteration == 1 ? 'is-active' : '' }}" data-view="{{ $loop->iteration }}">
                                        <ul class="catalog-header__list">
                                            @foreach($subItems as $subItem)
                                                @if($loop->iteration > 15)
                                                    @continue
                                                @else
                                                    <li class="catalog-header__item">
                                                        <a class="catalog-header__product" href="{{ $subItem->url }}"
                                                           title="{{ $subItem->name }}">{{ $subItem->name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                                <li class="catalog-header__item">
                                                    <a class="catalog-header__product" href="{{ $topItem->url }}"
                                                       title="Весь каталог" data-link-catalog="">Весь каталог</a>
                                                </li>
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <nav class="header__nav nav-header">
                    <ul class="nav-header__list list-reset">
                        @foreach($topMenu as $topItem)
                            <li class="nav-header__item">
                                <a class="nav-header__link" href="{{ $topItem->url }}" title="{{ $topItem->name }}">{{ $topItem->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
            <div class="header__column header__column--wide">
                <form class="header__search search-header" action="{{ route('search') }}">
                    <input class="search-header__input" type="search" name="q" value="{{ Request::get('q') }}"
                           placeholder="Поиск" aria-label="Поиск по сайту" required>
                    <button class="search-header__button">
                        <svg class="svg-sprite-icon icon-search">
                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#search"></use>
                        </svg>
                    </button>
                </form>
            @include('blocks.header_cart')
            </div>
        </div>
    </div>
</header>
