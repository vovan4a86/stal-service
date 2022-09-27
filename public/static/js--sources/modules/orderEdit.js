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

          const popupTitle = popup.querySelector('[data-popup-title]');
          const popupTotal = popup.querySelector('[data-popup-total]');
          const popupSummary = popup.querySelector('[data-popup-summary]');
          const popupWeight = popup.querySelector('[data-popup-weight]');

          popupTitle.textContent = orderName;
          popupWeight.value = orderCount;

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
