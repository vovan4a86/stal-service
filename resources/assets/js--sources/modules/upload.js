import $ from 'jquery';

const $uploadInput = $('.upload input');

$uploadInput && uploadInit();

function uploadInit() {
  $uploadInput.on('change', function (e) {
    e.preventDefault();

    $(this)
      .closest('.upload')
      .find('.upload__name')
      .text(getFileName(this.value));
    $('.upload__status').toggleClass('v-hidden');

    function getFileName(prop) {
      return prop.substr(prop.lastIndexOf('\\') + 1) || 'Прикрепить файл';
    }
  });
}
