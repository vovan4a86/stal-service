import { Fancybox } from '@fancyapps/ui';
import { closeButtonPopup } from './popups';
import { formatNumbers } from '../functions/formatNumbers';

const orderEdit = () => {
  Fancybox.bind('[data-edit-order]', {
    mainClass: 'popup--custom',
    hideClass: 'fancybox-zoomOut',
    template: { closeButton: closeButtonPopup },
    on: {
      reveal: (e, trigger) => {
        const orderItem = trigger.$trigger;
        const popup = trigger.$content;

        orderItem && popup && updateFields();

        function updateFields() {
          const orderName = orderItem.dataset.name;
          const orderPrice = orderItem.dataset.price;
          const orderCount = orderItem.dataset.count;
          const orderLength = orderItem.dataset.length;
          const orderInstock = orderItem.dataset.instock;

          const instock = '<div class="product-status product-status--instock">\n' +
              'В наличии\n' +
              '<svg width="10" height="10"\n' +
              'viewBox="0 0 10 10" fill="none"\n' +
              'xmlns="http://www.w3.org/2000/svg">\n' +
              '<path d="M8.4375 2.81274L4.0625 7.18755L1.875 5.00024"\n' +
              'stroke="#52AA52"\n' +
              'stroke-linecap="round"\n' +
              'stroke-linejoin="round"/>\n' +
              '</svg>\n' +
              '</div>';
          const timeoutstock = '<div class="product-status product-status--out-stock">\n' +
              'Временно отсутствует\n' +
              '</div>'
          const outstock = '<div class="product-status product-status--out-stock">\n' +
              'Под заказ\n' +
              '</div>'

          const popupTitle = popup.querySelector('[data-popup-title]');
          const popupPrice = popup.querySelector('[data-popup-price]');
          const popupTotal = popup.querySelector('[data-popup-total]');
          const popupSummary = popup.querySelector('[data-popup-summary]');
          const popupWeight = popup.querySelector('[data-popup-weight]');
          const popupLength = popup.querySelector('[data-popup-length]');

          const popupInstock = popup.querySelector('[data-popup-status]');

          popupTitle.textContent = orderName;
          popupPrice.textContent = orderPrice;
          popupWeight.value = orderCount;
          popupLength.value = orderLength;

          if(orderInstock == 0) popupInstock.innerHTML = timeoutstock;
          if(orderInstock == 1) popupInstock.innerHTML = instock;
          if(orderInstock == 2) popupInstock.innerHTML = outstock;


          popupSummary.textContent = calculate(orderPrice, orderCount);
          popupTotal.value = calculate(orderPrice, orderCount);
        }

        function calculate(price, count) {
          return formatNumbers(parseFloat(price) * parseInt(count));
        }
      }
    }
  });
};

orderEdit();
