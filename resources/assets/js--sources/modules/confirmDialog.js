import { showConfirmDialog } from './popups';

function confirmDialog() {
  const forms = document.querySelectorAll('form');

  forms &&
    forms.forEach(
      form =>
        !form.classList.contains('search-header') &&
        form.addEventListener('submit', function (e) {
          e.preventDefault();

          const event = new CustomEvent('form', {
            bubbles: true,
            detail: { name: 'form-submit' }
          });

          form.dispatchEvent(event);
          form.reset();

          showConfirmDialog();
        })
    );
}

// confirmDialog();
