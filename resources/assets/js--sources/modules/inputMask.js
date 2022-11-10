import Inputmask from 'inputmask';

////
export const maskedInputs = ({ phoneSelector, emailSelector, innSelector }) => {
  const phones = document.querySelectorAll(phoneSelector);
  const emails = document.querySelectorAll(emailSelector);
  const innFields = document.querySelectorAll(innSelector);

  const phoneParams = {
    mask: '+7 (999) 999-99-99',
    showMaskOnHover: false
  };

  const innParams = {
    mask: '99 9999 9999',
    showMaskOnHover: false
  };

  const emailParams = { showMaskOnHover: false };

  if (phones)
    phones.forEach(phone => {
      Inputmask(phoneParams).mask(phone);
    });

  if (emails)
    emails.forEach(email => {
      Inputmask('email', emailParams).mask(email);
    });

  if (innFields)
    innFields.forEach(innField => {
      Inputmask(innParams).mask(innField);
    });
};
