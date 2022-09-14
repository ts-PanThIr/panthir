export default function auth({auth}) {
  let isLoggedIn = auth.user; // Can be calculated through store
  // let isLoggedIn = store.getters['sessionData/isLoggedIn']
  if (!isLoggedIn) {
    return { name: "login" };
  }

  return true;
}
