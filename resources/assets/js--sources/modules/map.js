export const initMap = (id, lat, lon, zoom, text) => {
  ymaps.ready(function () {
    const myMap = new ymaps.Map(
        id,
        {
          center: [lat, lon],
          zoom: 16,
          controls: ['zoomControl']
        },
        {
          searchControlProvider: 'yandex#search'
        }
      ),
      myPlacemark = new ymaps.Placemark(
        myMap.getCenter(),
        {
          hintContent: text,
          balloonContent: text
        },
        {
          iconLayout: 'default#image',
          iconImageHref: 'static/images/common/ico_pin.svg',
          iconImageSize: [55, 65],
          iconImageOffset: [-25, -70]
        }
      );

    myMap.geoObjects.add(myPlacemark);
    myMap.behaviors.disable('scrollZoom');

    if (window.innerWidth < 600) myMap.behaviors.disable('drag');
  });
};

// init map on active tab view
document.addEventListener('DOMContentLoaded', function () {
  const tabViews = document.querySelectorAll('.tab__view');

  tabViews &&
    tabViews.forEach(tabView => {
      if (tabView && tabView.classList.contains('is-active')) {
        const map = tabView.querySelector('[data-map]');

        if (map) {
          const latitude = map.dataset.lat;
          const longitude = map.dataset.long;
          const label = map.dataset.hint;
          const id = map.id;

          // prevent map duplication
          const yMap = map.querySelector('ymaps');

          !yMap && initMap(id, latitude, longitude, 13, label);
        }
      }
    });
});
