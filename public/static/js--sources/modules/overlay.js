import $ from 'jquery';
import { getScrollbarWidth } from '../functions/scrollBarWidth';

export const overlay = () => {
  const burger = document.querySelector('[data-open-overlay]');
  const overlay = document.querySelector('[data-overlay]');
  const overlayClose = document.querySelector('[data-overlay-close]');

  burger && burger.addEventListener('click', openOverlay);

  function openOverlay() {
    this.classList.toggle('is-active');
    overlay && overlay.classList.add('is-active');

    removePageScroll();

    overlayClose && overlayClose.addEventListener('click', closeOverlay);
  }

  function closeOverlay() {
    burger.classList.remove('is-active');
    overlay.classList.remove('is-active');

    setPageScroll();
  }

  function removePageScroll() {
    document.body.classList.add('no-scroll');
    document.body.style.marginRight = getScrollbarWidth() + 'px';
  }

  function setPageScroll() {
    document.body.classList.remove('no-scroll');
    document.body.style.marginRight = '';
  }

  $('[data-overlay-dropdown]').on('click', function () {
    $(this).siblings('[data-overlay-menu]').slideToggle();
    $(this).find('.category-overlay__icon').toggleClass('is-active');
  });
};

overlay();
