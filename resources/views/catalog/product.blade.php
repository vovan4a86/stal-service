@extends('template')
@section('content')
        @include('blocks.bread')
        <main>
            <!-- homepage ? '' : 'section--inner'-->
            <section class="section {{ Request::url() === '/' ? '' : 'section--inner' }}">
            <div class="product__container container">
                    <div class="section__links">
                        <h2 class="section__title">{{ $product->name }}</h2>
                        @if(Settings::get('catalog_price'))
                            <a class="btn btn--outlined btn--tag" href="{{ Settings::fileSrc(Settings::get('catalog_price')) }}" download="Прайс-лист Сталь-Сервис">
                                <svg class="svg-sprite-icon icon-tag">
                                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#tag"></use>
                                </svg>
                                <span>Скачать прайс-лист</span>
                            </a>
                        @else
                            <span class="btn btn--outlined btn--tag">
                            <svg class="svg-sprite-icon icon-tag">
                                <use xlink:href="/static/images/sprite/symbol/sprite.svg#tag"></use>
                            </svg>
                            <span>Прайс-лист не добавлен</span>
                        </span>
                        @endif
                    </div>
                    <div class="product__content">
                        <div class="product__view">
                            <div class="slider-product swiper" data-product-slider>
                                <div class="slider-product__nav slider-nav">
                                    <div class="slider-product__icon slider-product__icon--prev slider-nav__icon slider-nav__icon--white slider-nav__prev" data-product-prev>
                                        <svg class="svg-sprite-icon icon-arrow-prev">
                                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow-prev"></use>
                                        </svg>
                                    </div>
                                    <div class="slider-product__icon slider-product__icon--next slider-nav__icon slider-nav__icon--white slider-nav__next" data-product-next>
                                        <svg class="svg-sprite-icon icon-arrow">
                                            <use xlink:href="/static/images/sprite/symbol/sprite.svg#arrow"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="slider-product__wrapper swiper-wrapper">
                                    <div class="slider-product__slide swiper-slide">
                                        <a class="slider-product__link" href="/static/images/common/product.png" data-fancybox="gallery">
                                            <img class="slider-product__picture swiper-lazy" src="/" data-src="/static/images/common/product.png" alt="alt" width="586" height="386">
                                        </a>
                                    </div>
                                    <div class="slider-product__slide swiper-slide">
                                        <a class="slider-product__link" href="/static/images/common/product.png" data-fancybox="gallery">
                                            <img class="slider-product__picture swiper-lazy" src="/" data-src="/static/images/common/product.png" alt="alt" width="586" height="386">
                                        </a>
                                    </div>
                                    <div class="slider-product__slide swiper-slide">
                                        <a class="slider-product__link" href="/static/images/common/product.png" data-fancybox="gallery">
                                            <img class="slider-product__picture swiper-lazy" src="/" data-src="/static/images/common/product.png" alt="alt" width="586" height="386">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product__info">
                            <div class="product-data">
                                <div class="product-data__price">Цена 63 244,00 руб. / т</div>
                                <div class="product-data__fields">
                                    <div class="fields">
                                        <div class="fields__field">
                                            <label class="fields__label">Длина, м
                                                <input class="fields__input" type="number" name="length" value="5" required data-popup-length>
                                            </label>
                                        </div>
                                        <div class="fields__field">
                                            <label class="fields__label">Кол-во, шт
                                                <input class="fields__input" type="number" name="count" value="700" required data-popup-count>
                                            </label>
                                        </div>
                                        <div class="fields__field">
                                            <label class="fields__label">Кол-во, т
                                                <input class="fields__input" type="number" name="weight" value="1" required data-popup-weight>
                                            </label>
                                        </div>
                                        <div class="fields__value">
                                            <label class="fields__label">На сумму, ₽
                                                <input class="fields__input" type="text" name="total" value="63 686,71 руб." data-popup-total disabled>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="product-data__option">
                                        <label class="checkbox">
                                            <input class="checkbox__input" type="checkbox" name="option">
                                            <span class="checkbox__box"></span>
                                            <span class="checkbox__policy">Резка</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="product-data__bottom">
                                    <div class="product-data__weight">Общий вес продукции
                                        <span>1 562 кг</span>
                                    </div>
                                    <div class="product-data__action">
                                        <div class="product-data__summary">Итого
                                            <span>63 686,71 руб.</span>
                                        </div>
                                        <div class="product-data__add">
                                            <button class="btn btn--content" type="button">
                                                <span>Добавить в корзину</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="params">
                        <div class="params__title">Характеристики</div>
                        <div class="params__grid">
                            <div class="params__column">
                                <div class="params__fields">
                                    <dl class="params__field">
                                        <dt class="params__param">Ширина 1</dt>
                                        <dd class="params__value">10</dd>
                                    </dl>
                                    <dl class="params__field">
                                        <dt class="params__param">Ширина 2</dt>
                                        <dd class="params__value">10</dd>
                                    </dl>
                                    <dl class="params__field">
                                        <dt class="params__param">Толщина</dt>
                                        <dd class="params__value">1.2</dd>
                                    </dl>
                                    <dl class="params__field">
                                        <dt class="params__param">Плоскоовальная</dt>
                                        <dd class="params__value"></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="params__column">
                                <div class="params__fields">
                                    <dl class="params__field">
                                        <dt class="params__param">ГОСТ</dt>
                                        <dd class="params__value">ГОСТ</dd>
                                    </dl>
                                    <dl class="params__field">
                                        <dt class="params__param">Наличие некондиции</dt>
                                        <dd class="params__value">1.2</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(count($features))
                        <div class="features-company">
                            <div class="features-company__grid">
                                @foreach($features as $feat)
                                    <div class="features-company__item">
                                        <img class="features-company__icon lazy" src="/" data-src="{{ \Fanky\Admin\Models\ProductIcon::UPLOAD_URL . $feat->image }}" alt="alt" width="50" height="42">
                                        <div class="features-company__label">{!! $feat->name !!}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <section class="section">
                        <div class="container">
                            <div class="section__text text-content">
                                {!! $product->text !!}
                            </div>
                        </div>
                    </section>
                    <nav class="related-products">
                        <div class="related-products__title">Похожие товары:</div>
                        <ul class="related-products__list">
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Труба 200х100х6 профильна" target="_blank">Труба 200х100х6 профильна</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Труба 200х100х6 профильна" target="_blank">Труба 200х100х6 профильна</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Труба 200х100х6 профильна" target="_blank">Труба 200х100х6 профильна</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Труба 200х100х6 профильна" target="_blank">Труба 200х100х6 профильна</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Труба 200х100х6 профильна" target="_blank">Труба 200х100х6 профильна</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Труба 200х100х6 профильна" target="_blank">Труба 200х100х6 профильна</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Труба 200х100х6 профильна" target="_blank">Труба 200х100х6 профильна</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Труба 200х100х6 профильна" target="_blank">Труба 200х100х6 профильна</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                            <li class="related-products__item">
                                <a class="related-products__link" href="javascript:void(0)" title="Трубы горячедеформированные 57х10, Ст20" target="_blank">Трубы горячедеформированные 57х10, Ст20</a>
                                <span>140 890 ₽</span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </section>
        </main>
@endsection
