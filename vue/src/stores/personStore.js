import { defineStore } from "pinia";
import { useAddressStore } from "~/stores";

export const usePersonStore = defineStore({
  id: "person",
  state: () => ({
    person: {},
    addresses: useAddressStore(),
  }),
  actions: {
    async getAll() {
      try {
        this.person = await this.$http
          .get(`${this.$apiUrl}/api/person`)
          .then((d) => {
            return d.data.data;
          });
      } catch (error) {
        this.person = { error };
      }
    },
    async send() {
      try {
        this.person = await this.$http
          .get(`${this.$apiUrl}/api/person`)
          .then((d) => {
            return d.data.data;
          });
      } catch (error) {
        this.person = { error };
      }
    },
  },
});
