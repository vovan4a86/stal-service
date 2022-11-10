import 'focus-visible';
import './modules/modules';
import { scrollTop } from './modules/scrollTop';
import { maskedInputs } from './modules/inputMask';

scrollTop({ trigger: '.scrolltop' });

maskedInputs({
  phoneSelector: 'input[name="phone"]',
  emailSelector: 'input[name="email"]',
  innSelector: 'input[name="inn"]'
});
