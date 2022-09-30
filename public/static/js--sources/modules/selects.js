import SlimSelect from '../plugins/slimselect.min';

export const selectInit = select => {
  new SlimSelect({
    select: select,
    searchPlaceholder: 'Найти:',
    searchText: 'Не найдено',
    closeOnSelect: false,
    hideSelectedOption: true,
    limit: 2
  });
};

export const selectPagesInit = select => {
  new SlimSelect({
    select: select,
    showSearch: false
  });
};

const catalogSelects = document.querySelectorAll('.catalog-select');
const catalogPagesSelect = document.querySelector('.catalog-list__pages');

catalogSelects && catalogSelects.forEach(select => selectInit(select));
catalogPagesSelect && selectPagesInit(catalogPagesSelect);
