import $ from 'jquery';
import { isLocalStorageEnabled } from '../functions/isLocalStorageEnabled';

export const cookie = () => {
  const cookieBlock = $('.cookie');

  // checked if cookies is confirmed → remove cookies block
  localStorage.getItem('cookie') && cookieBlock.slideUp('slow');

  cookieBlock.on('click', function (event) {
    const target = event.target;

    // remove cookies block
    target.closest('.cookie__confirm') && cookieBlock.slideUp('slow');

    // store data of cookies confirmed
    isLocalStorageEnabled() && localStorage.setItem('cookie', 'confirmed');
  });
};

cookie();
