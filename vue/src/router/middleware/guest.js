export default function guest({ auth }) {
  let isLoggedIn = auth.user; // Can be calculated through store
  if (isLoggedIn) {
    return { name: "home" };
  }

  return true;
}
