export function trimString(str) {
  if (!str) return str;
  return str.replace(/^\s+|\s+$/g, '');
}
