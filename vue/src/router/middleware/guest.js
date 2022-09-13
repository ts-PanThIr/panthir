export default function guest() {
  let isLoggedIn = false; // Can be calculated through store
  if (isLoggedIn) {
    return { name: "home" };
  }

  return true;
}
