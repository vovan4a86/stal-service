import { Fancybox } from '@fancyapps/ui';

const closeBtn =
  '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path fill="currentColor" d="M16 2C8.2 2 2 8.2 2 16s6.2 14 14 14s14-6.2 14-14S23.8 2 16 2zm5.4 21L16 17.6L10.6 23L9 21.4l5.4-5.4L9 10.6L10.6 9l5.4 5.4L21.4 9l1.6 1.6l-5.4 5.4l5.4 5.4l-1.6 1.6z"/></svg>';

export const closeButtonPopup = `
    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M21.0938 5.90625L5.90625 21.0938" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M21.0938 21.0938L5.90625 5.90625" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  `;

Fancybox.bind('[data-fancybox]', {
  closeButton: 'outside',
  mainClass: 'popup--ajax',
  hideClass: 'fancybox-zoomOut',
  infinite: false
});

Fancybox.bind('[data-popup]', {
  mainClass: 'popup--custom',
  template: {
    closeButton: closeButtonPopup
  },
  hideClass: 'fancybox-zoomOut'
});

export const showConfirmDialog = () => {
  Fancybox.show([{ src: '#confirm', type: 'inline' }], {
    mainClass: 'popup--custom popup--confirm',
    template: {
      closeButton: closeBtn
    },
    hideClass: 'fancybox-zoomOut'
  });
};

// showConfirmDialog();
