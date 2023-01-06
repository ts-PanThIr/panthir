import { defineStore } from "pinia";

export const useAuthStore = defineStore({
  id: "auth",
  state: () => ({
    // initialize state from local storage to enable user to stay logged in
    user: JSON.parse(localStorage.getItem("user")),
    returnUrl: null,
  }),
  actions: {
    async login(username, password) {
      try {
        const data = {
          username: username,
          password: password,
        };
        const user = await this.$http.post(
          `${this.$apiUrl}/api/login_check`,
          JSON.stringify(data),
          {
            headers: { "Content-Type": "application/json" },
          }
        );

        this.user = user.data;
        localStorage.setItem("user", JSON.stringify(user.data));
        this.$router.push("/");
      } catch (error) {
        // const alertStore = useAlertStore();
        // alertStore.error(error);
      }
    },
    logout() {
      debugger;
      this.user = null;
      localStorage.removeItem("user");
      this.$router.push("/account/login");
    },
  },
});
