import { matchMedia } from '../functions/matchMedia';

const catalogHeader = () => {
  const catalogLinks = document.querySelectorAll('.catalog-header__link');

  !matchMedia('600px') &&
    catalogLinks &&
    catalogLinks.forEach(link => {
      link.addEventListener('click', e => e.preventDefault());
    });
};

catalogHeader();
