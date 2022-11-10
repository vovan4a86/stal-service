import { initMap } from './map';

export const tabs = ({ tabSelector, tabLink, tabView, map }) => {
  const tabsContainer = document.querySelectorAll(tabSelector);

  tabsContainer &&
    tabsContainer.forEach(tabs =>
      tabs.addEventListener('click', function (e) {
        const target = e.target;

        if (target.dataset.open) {
          const targetView = target.dataset.open;
          const views = tabs.querySelectorAll(tabView);
          const links = tabs.querySelectorAll(tabLink);

          if (views && links) {
            // set active tab link
            for (let i = 0; i < links.length; i++) {
              links[i].classList.remove('is-active');
              target.classList.add('is-active');
            }

            // set active tab view
            for (let i = 0; i < views.length; i++) {
              views[i].classList.remove('is-active');
              views[i].dataset.view === targetView &&
                views[i].classList.add('is-active');
            }

            // init map in tab
            map &&
              views.forEach(view => {
                if (view.classList.contains('is-active')) {
                  const map = view.querySelector('[data-map]');
                  const latitude = map.dataset.lat;
                  const longitude = map.dataset.long;
                  const label = map.dataset.hint;
                  const id = map.id;

                  // prevent map duplication
                  const yMap = view.querySelector('ymaps');

                  !yMap && initMap(id, latitude, longitude, 13, label);
                }
              });
          }
        }
      })
    );
};

tabs({
  tabSelector: '[data-tabs]',
  tabLink: '[data-open]',
  tabView: '[data-view]'
});

tabs({
  tabSelector: '[data-map-tabs]',
  tabLink: '[data-open]',
  tabView: '[data-view]',
  map: true
});

tabs({
  tabSelector: '[data-nav-tabs]',
  tabLink: '[data-open]',
  tabView: '[data-view]'
});
