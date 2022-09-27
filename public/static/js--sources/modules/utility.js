import $ from 'jquery';

export const preloader = () => {
  $('.preloader').fadeOut();
  $('body').removeClass('no-scroll');
};

export const utils = () => {
  const blocks = '.lazy, picture, img, video';
  $(blocks).on('contextmenu', () => false);
};

export const noDrag = () => {
  const blocks = '.lazy, picture, img, video, a';
  $(blocks).on('dragstart', () => false);
};

preloader();
utils();
noDrag();
