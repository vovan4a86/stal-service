export const matchMedia = size => {
  if (window.matchMedia(`(max-width: ${size})`).matches) {
    return true;
  }
};
