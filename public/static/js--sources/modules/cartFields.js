import $ from 'jquery';

const cartFields = () => {
  $('[data-radio]').on('click', function (e) {
    if (e.target.dataset.radio === 'hide') {
      $(event.target)
        .closest('.cart__data')
        .find('[data-hide-content]')
        .slideUp('fast');

      $(event.target)
        .closest('.cart__data')
        .find('[data-hide-content]')
        .find('.cart__input')
        .prop('required', false);
    } else if (e.target.dataset.radio === 'show') {
      $(event.target)
        .closest('.cart__data')
        .find('[data-hide-content]')
        .slideDown('fast');

      $(event.target)
        .closest('.cart__data')
        .find('[data-hide-content]')
        .find('.cart__input')
        .prop('required', true);
    }
  });
};

cartFields();
