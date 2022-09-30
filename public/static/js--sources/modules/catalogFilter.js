import $ from 'jquery';

export const catalogFilter = () => {
  $('[data-filter-show]').on('click', function () {
    const $content = $('[data-filter-content]');

    $content.toggleClass('is-block');
    $content.slideToggle('fast');

    $content.hasClass('is-block')
      ? $(this).find('span').text('Скрыть фильтр')
      : $(this).find('span').text('Показать фильтр');
  });
};

catalogFilter();
