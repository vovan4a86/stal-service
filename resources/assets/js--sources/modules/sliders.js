import Swiper, { EffectFade, Lazy, Navigation, Pagination } from 'swiper';

export const mainSlider = ({ slider, pagination }) => {
  new Swiper(slider, {
    modules: [Pagination, EffectFade, Lazy],
    fadeEffect: { crossFade: true },
    effect: 'fade',
    lazy: true,
    pagination: {
      el: pagination,
      clickable: true
    }
  });
};

export const productSlider = ({ slider }) => {
  new Swiper(slider, {
    modules: [EffectFade, Lazy, Navigation],
    fadeEffect: { crossFade: true },
    effect: 'fade',
    lazy: true,
    navigation: {
      nextEl: '[data-product-next]',
      prevEl: '[data-product-prev]'
    }
  });
};

export const tabSlider = ({ slider, navigationNext, navigationPrev }) => {
  new Swiper(slider, {
    modules: [Lazy, Navigation],
    lazy: true,
    slidesPerView: 1.1,
    slidesPerGroup: 1,
    spaceBetween: 10,
    speed: 650,
    navigation: {
      nextEl: navigationNext,
      prevEl: navigationPrev
    },
    breakpoints: {
      768: {
        slidesPerView: 2.2,
        spaceBetween: 20,
        slidesPerGroup: 2
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
        slidesPerGroup: 3
      },
      1280: {
        slidesPerView: 4,
        spaceBetween: 30,
        slidesPerGroup: 4
      }
    },
    // tabs params
    observer: true,
    observeParents: true
  });
};

export const newsSlider = ({ slider }) => {
  new Swiper(slider, {
    modules: [Lazy, Navigation],
    slidesPerView: 1.2,
    slidesPerGroup: 1,
    spaceBetween: 10,
    speed: 650,
    navigation: {
      nextEl: '[data-news-next]',
      prevEl: '[data-news-prev]'
    },
    breakpoints: {
      768: {
        slidesPerView: 2.2,
        spaceBetween: 20,
        slidesPerGroup: 2
      },
      1024: {
        slidesPerView: 2.2,
        spaceBetween: 20,
        slidesPerGroup: 2
      },
      1280: {
        slidesPerView: 3,
        spaceBetween: 30,
        slidesPerGroup: 3
      }
    }
  });
};

mainSlider({
  slider: '[data-main-slider]',
  pagination: '.hero__pagination'
});

productSlider({ slider: '[data-product-slider]' });

tabSlider({
  slider: '[data-discount-slider]',
  navigationNext: '[data-discount-next]',
  navigationPrev: '[data-discount-prev]'
});

tabSlider({
  slider: '[data-popular-slider]',
  navigationNext: '[data-popular-next]',
  navigationPrev: '[data-popular-prev]'
});

newsSlider({ slider: '[data-news-slider]' });
