import { isLocalStorageEnabled } from '../functions/isLocalStorageEnabled';

export const changeRegion = () => {
  const dialog = document.querySelector('[data-city-dialog]');

  // hide dialog if region already confirmed
  isLocalStorageEnabled() &&
    localStorage.getItem('client-region') &&
    dialog.remove();

  if (dialog) {
    dialog.addEventListener('click', function (e) {
      const target = e.target;

      target.dataset.cityConfirm && confirm();
      target.dataset.cityChange && changeRegion();

      // remove dialog
      function confirm() {
        dialog.classList.add('is-hidden');

        isLocalStorageEnabled() &&
          localStorage.setItem('client-region', 'confirm');
      }

      // open cities list popup
      function changeRegion() {
        dialog.classList.add('is-hidden');

        setTimeout(() => {
          const regionLinks = document.querySelectorAll('.cities-page__link');

          regionLinks &&
            regionLinks.forEach(link =>
              link.addEventListener('click', function () {
                isLocalStorageEnabled() &&
                  localStorage.setItem('client-region', 'confirm');
              })
            );
        }, 500);
      }
    });
  }
};

changeRegion();
