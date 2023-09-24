export const replaceToProducts = () => {
  window.history.replaceState(null, "", "/products");
  window.location.reload();
};

export const replaceToLogin = () => {
  window.history.replaceState(null, "", "/login");
  window.location.reload();
};
