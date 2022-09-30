<div class="catalog-list">
    <div class="catalog-list__top">
        @include('catalog.views.togglers')
    </div>
    <div class="catalog-list__content">
        <div class="catalog-list__head">
            <div class="catalog-list__filter" data-filter-show>
                <svg class="svg-sprite-icon icon-option">
                    <use xlink:href="/static/images/sprite/symbol/sprite.svg#option"></use>
                </svg>
                <span>Показать фильтр</span>
            </div>
            <div class="catalog-list__hidden" data-filter-content>
                <div class="catalog-list__grid catalog-list__grid--filters">
                    <div class="catalog-list__column catalog-list__column--one">
                        <div class="catalog-list__label">Фото</div>
                    </div>
                    <div class="catalog-list__column catalog-list__column--two">
                        <div class="catalog-list__label">Наименование</div>
                    </div>
                    <div class="catalog-list__column catalog-list__column--one catalog-list__column--filter">
                        <!-- https://slimselectjs.com/options-->
                        <!-- js--sources/modules/select.js-->
                        <select class="catalog-select" name="width" multiple>
                            <option data-placeholder="true">Ширина</option>
                            <option value="0.8м">0.8м</option>
                            <option value="0.902м">0.902м</option>
                            <option value="1.047м">1.047м</option>
                            <option value="1.057м">1.057м</option>
                            <option value="1.06м">1.06м</option>
                            <option value="1.155м">1.155м</option>
                            <option value="1.15м">1.15м</option>
                            <option value="1.2м">1.2м</option>
                        </select>
                    </div>
                    <div class="catalog-list__column catalog-list__column--one catalog-list__column--filter">
                        <select class="catalog-select" name="size" multiple>
                            <option data-placeholder="true">Толщина</option>
                            <option value="0.35">0.35</option>
                            <option value="0.4">0.4</option>
                            <option value="0.45">0.45</option>
                            <option value="0.45 ТУ">0.45 ТУ</option>
                            <option value="0.5">0.5</option>
                            <option value="0.55">0.55</option>
                            <option value="0.65">0.65</option>
                            <option value="0.7">0.7</option>
                            <option value="0.8">0.8</option>
                            <option value="0.9">0.9</option>
                        </select>
                    </div>
                    <div class="catalog-list__column catalog-list__column--two">
                        <div class="catalog-list__label">Цена</div>
                    </div>
                </div>
            </div>
        </div>
        @if(count($items))
            <div class="catalog-list__products">
                @foreach($items as $item)
                    @include('catalog.list_row')
                @endforeach
            </div>
        @endif
    </div>
    <div class="catalog-list__footer">
        <nav class="pagination">
            {{ $items->links('catalog.page_nav') }}
        </nav>
        @include('catalog.views.per_page')
    </div>
</div>
