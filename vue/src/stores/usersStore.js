import { defineStore } from "pinia";

export const useUsersStore = defineStore({
  id: "users",
  state: () => ({
    users: {},
    user: {},
  }),
  actions: {
    async getAll() {
      try {
        this.users = await this.$http
          .get(`${this.$apiUrl}/api/users`)
          .then((d) => {
            return d.data.data;
          });
      } catch (error) {
        this.users = { error };
      }
    },
  },
});
