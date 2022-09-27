<footer class="footer">
    <div class="container">
        <div class="footer__grid">
            <div class="footer__info">
                <a class="footer__logo logo" href="{{ route('main') }}" title="Сталь Сервис">
                    <img class="lazy" data-src="/static/images/common/logo--white.svg" src="/" alt="Сталь Сервис" width="409" height="49">
                </a>
                <a class="footer__phone phone" href="tel:+{{ preg_replace('/[^\d]+/', '', Settings::get('footer_phone')) }}">{{Settings::get('footer_phone')}}</a>
                <a class="footer__email email" href="mailto:{{Settings::get('footer_email')}}">{{Settings::get('footer_email')}}</a>
                <p class="footer__description">{!! Settings::get('footer_text') !!}</p>
            </div>
            <div class="footer__navigation">
                <!-- .footer__column-->
                <div class="footer__column">
                    <a class="footer__category catalog-footer" href="{{ route('catalog.index') }}" title="Каталог продукции">
								<span class="catalog-footer__icon">
									<svg class="svg-sprite-icon icon-list">
										<use xlink:href="/static/images/sprite/symbol/sprite.svg#list"></use>
									</svg>
								</span>
                        <span class="catalog-footer__label">Каталог продукции</span>
                    </a>
                    <nav class="footer__nav nav-footer" itemscope itemtype="https://schema.org/SiteNavigationElement">
                        <ul class="nav-footer__list" itemprop="about" itemscope itemtype="https://schema.org/ItemList">
                            @foreach($catalogTop as $item)
                                <li class="nav-footer__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList">
                                    <a class="nav-footer__link" href="{{ $item->url }}"
                                       title="Профильная труба" itemprop="url">{{ $item->name }}</a>
                                    <meta itemprop="name" content="{{ $item->name }}">
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <!-- .footer__column-->
                <div class="footer__column">
                    <a class="footer__category" href="{{ $aboutLink }}">О Компании</a>
                    <nav class="footer__nav nav-footer" itemscope itemtype="https://schema.org/SiteNavigationElement">
                        <ul class="nav-footer__list" itemprop="about" itemscope itemtype="https://schema.org/ItemList">
                            @foreach($aboutMenuFooter as $item)
                                <li class="nav-footer__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList">
                                    <a class="nav-footer__link" href="{{ $item->alias }}"
                                       title="{{ $item->name }}" itemprop="url">{{ $item->name }}</a>
                                    <meta itemprop="name" content="{{ $item->name }}">
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <!-- .footer__column-->
                <div class="footer__column">
                    <a class="footer__category" href="{{ $directoryLink }}">Справочник</a>
                    <nav class="footer__nav nav-footer" itemscope itemtype="https://schema.org/SiteNavigationElement">
                        <ul class="nav-footer__list" itemprop="about" itemscope itemtype="https://schema.org/ItemList">
                            @foreach($directoryMenuFooter as $item)
                                <li class="nav-footer__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList">
                                    <a class="nav-footer__link" href="{{ $item->alias }}"
                                       title="{{ $item->name }}" itemprop="url">{{ $item->name }}</a>
                                    <meta itemprop="name" content="{{ $item->name }}">
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="footer__copyrights">
            <div class="footer__copyright">{{ Settings::get('footer_copy') }}</div>
            <a class="footer__policy" href="/_ajax-policy.html" data-fancybox data-type="ajax">Политика обработки персональных данных</a>
        </div>
    </div>
</footer>