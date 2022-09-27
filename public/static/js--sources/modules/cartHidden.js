import $ from 'jquery';

const cartHidden = () => {
  const $proceedBtn = $('[data-proceed-order]');
  $proceedBtn && $proceedBtn.on('click', showHiddenContent);

  function showHiddenContent() {
    $(this).addClass('is-disabled');
    // $(this).find('span').text('Заполните данные');
    const $cartHiddenContent = $('[data-cart-hidden]');

    if ($cartHiddenContent.hasClass('is-hidden')) {
      $cartHiddenContent.slideDown();

      setTimeout(() => {
        scrollToHiddenContent();
        $cartHiddenContent.removeClass('is-hidden');
      }, 250);
    }

    function scrollToHiddenContent() {
      $('html, body').animate(
        {
          scrollTop: $cartHiddenContent.offset().top
        },
        0
      );
    }
  }
};

cartHidden();
